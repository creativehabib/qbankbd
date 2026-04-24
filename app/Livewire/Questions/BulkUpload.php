<?php

namespace App\Livewire\Questions;

use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\ExamCategory;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Support\QuestionTextParser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class BulkUpload extends Component
{
    use WithFileUploads;

    public ?int $academic_class_id = null;

    public ?int $subject_id = null;

    public ?int $chapter_id = null;

    public ?int $topic_id = null;

    public string $difficulty = 'easy';

    public float $marks = 1;

    public array $exam_category_ids = [];

    public ?TemporaryUploadedFile $sourceImage = null;

    public string $rawText = '';

    /**
     * @var array<int, array{
     *     title: string,
     *     options: array<int, array{option_text: string, is_correct: bool}>
     * }>
     */
    public array $processedQuestions = [];

    public function updatedAcademicClassId($value): void
    {
        $this->subject_id = null;
        $this->chapter_id = null;
        $this->topic_id = null;
    }

    public function updatedSubjectId($value): void
    {
        $this->chapter_id = null;
        $this->topic_id = null;
    }

    public function updatedChapterId($value): void
    {
        $this->topic_id = null;
    }

    /**
     * Blade থেকে radio button ক্লিক করলে সঠিক উত্তর সেট হবে।
     * একটি প্রশ্নে একটিই correct option থাকবে।
     */
    public function setCorrectOption(int $questionIndex, int $optionIndex): void
    {
        if (! isset($this->processedQuestions[$questionIndex])) {
            return;
        }

        foreach ($this->processedQuestions[$questionIndex]['options'] as $i => $option) {
            $this->processedQuestions[$questionIndex]['options'][$i]['is_correct'] = ($i === $optionIndex);
        }
    }

    public function processQuestions(): void
    {
        $rawText = trim($this->rawText);

        if ($rawText === '' && $this->sourceImage) {
            $rawText = $this->extractRawTextFromImage();
            $this->rawText = $rawText;
        }

        if ($rawText === '') {
            $this->addError('rawText', 'অনুগ্রহ করে প্রশ্নের টেক্সট দিন অথবা একটি ইমেজ আপলোড করুন, তারপর Process Questions ক্লিক করুন।');

            return;
        }

        $validated = $this->validate([
            'rawText' => 'string|min:20',
        ], [
            'rawText.min' => 'কমপক্ষে ২০ অক্ষরের প্রশ্ন টেক্সট দিন।',
        ]);

        $parsed = QuestionTextParser::parseMcqText($validated['rawText']);

        if (empty($parsed)) {
            $this->addError('rawText', 'টেক্সট থেকে কোন MCQ প্রশ্ন পাওয়া যায়নি। নম্বর + (ক)/(খ)/(গ)/(ঘ) ফরম্যাটে দিন।');

            return;
        }

        // প্রতিটি option এ is_correct: false নিশ্চিত করা (parser যদি field না দেয়)
        foreach ($parsed as $qi => $question) {
            foreach ($question['options'] as $oi => $option) {
                $parsed[$qi]['options'][$oi]['is_correct'] = (bool) ($option['is_correct'] ?? false);
            }
        }

        $this->processedQuestions = $parsed;
        $this->rawText = $this->formatProcessedQuestionsForTextarea();

        session()->flash('success', count($this->processedQuestions).'টি প্রশ্ন প্রসেস করা হয়েছে। নিচে সঠিক উত্তর (✓) চিহ্নিত করুন, তারপর Submit করুন।');
    }

    protected function extractRawTextFromImage(): string
    {
        $this->validate([
            'sourceImage' => 'nullable|image|max:4096',
        ]);

        if (! $this->sourceImage) {
            return '';
        }

        $imagePath = $this->sourceImage->getRealPath();

        if (! $imagePath || ! is_readable($imagePath)) {
            $this->addError('sourceImage', 'ইমেজ ফাইলটি পড়া যাচ্ছে না। আবার আপলোড করুন।');

            return '';
        }

        // বাংলা আগে চেষ্টা করা হবে, তারপর English fallback
        $languages = ['ben', 'eng'];
        $ocrErrors = [];

        foreach ($languages as $language) {
            $fileStream = fopen($imagePath, 'r');

            if ($fileStream === false) {
                continue;
            }

            $payload = [
                'apikey' => config('services.ocr_space.key', env('OCR_SPACE_KEY', 'helloworld')),
                'isOverlayRequired' => 'false',
                'OCREngine' => $language === 'ben' ? '1' : '2',
                'language' => $language,
                'detectOrientation' => 'true',
                'scale' => 'true',
                'isTable' => 'false',
            ];

            $response = Http::timeout(60)
                ->attach('file', $fileStream, $this->sourceImage->getClientOriginalName())
                ->post('https://api.ocr.space/parse/image', $payload);

            fclose($fileStream);

            if (! $response->successful()) {
                $ocrErrors[] = 'OCR server response failed ('.$language.').';

                continue;
            }

            $json = $response->json();
            $parsedResults = data_get($json, 'ParsedResults', []);

            $ocrText = collect($parsedResults)
                ->pluck('ParsedText')
                ->filter(fn ($text) => is_string($text) && trim($text) !== '')
                ->implode(PHP_EOL);

            if (trim($ocrText) !== '') {
                if ($this->isLowQualityOcrText($ocrText, $language)) {
                    $ocrErrors[] = 'OCR text quality is too low for language '.$language;

                    continue;
                }

                return trim($ocrText);
            }

            $errorMessage = data_get($json, 'ErrorMessage');
            $errorDetails = data_get($json, 'ErrorDetails');

            if (is_array($errorMessage)) {
                $errorMessage = implode(' ', $errorMessage);
            }

            $ocrErrors[] = trim(collect([$errorMessage, $errorDetails])->filter()->implode(' | '))
                ?: 'OCR text empty for language '.$language;
        }

        $this->addError(
            'sourceImage',
            'আপলোডকৃত ইমেজ থেকে ভালো OCR টেক্সট পাওয়া যায়নি। স্ক্যান করা পরিষ্কার/সোজা ছবি (ছায়া ছাড়া) দিন অথবা টেক্সট ম্যানুয়ালি পেস্ট করুন।'
            .(! empty($ocrErrors) ? ' বিস্তারিত: '.implode(' ; ', $ocrErrors) : '')
        );

        return '';
    }

    protected function isLowQualityOcrText(string $text, string $language): bool
    {
        $trimmedText = trim($text);

        if ($trimmedText === '') {
            return true;
        }

        if ($language === 'eng') {
            return mb_strlen($trimmedText) < 20;
        }

        // বাংলা Unicode block: U+0980–U+09FF
        preg_match_all('/[\x{0980}-\x{09FF}]/u', $trimmedText, $banglaMatches);
        preg_match_all('/[\p{L}]/u', $trimmedText, $letterMatches);

        $banglaCount = count($banglaMatches[0]);
        $letterCount = count($letterMatches[0]);

        if ($letterCount === 0) {
            return true;
        }

        $banglaRatio = $banglaCount / $letterCount;

        return $banglaCount < 20 || $banglaRatio < 0.25;
    }

    protected function formatProcessedQuestionsForTextarea(): string
    {
        $lines = [];
        $labels = ['ক', 'খ', 'গ', 'ঘ'];

        foreach ($this->processedQuestions as $index => $question) {
            $lines[] = ($index + 1).'. '.$question['title'];

            foreach ($question['options'] as $optionIndex => $option) {
                $label = $labels[$optionIndex] ?? (string) ($optionIndex + 1);
                $lines[] = '('.$label.') '.$option['option_text'];
            }

            $lines[] = '';
        }

        return trim(implode(PHP_EOL, $lines));
    }

    public function submitProcessedQuestions(): void
    {
        abort_unless(auth()->user()?->hasPermission('questions.create'), 403);

        $validated = $this->validate([
            'academic_class_id' => 'required|exists:academic_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'chapter_id' => 'nullable|exists:chapters,id',
            'topic_id' => 'required_with:chapter_id|nullable|exists:topics,id',
            'difficulty' => 'required|in:easy,medium,hard',
            'marks' => 'required|numeric|min:0.25',
            'exam_category_ids' => 'required|array|min:1',
            'exam_category_ids.*' => 'required|exists:exam_categories,id',
            'sourceImage' => 'nullable|image|max:4096',
            'processedQuestions' => 'required|array|min:1',
            'processedQuestions.*.title' => 'required|string',
            'processedQuestions.*.options' => 'required|array|min:2',
            'processedQuestions.*.options.*.option_text' => 'required|string',
            'processedQuestions.*.options.*.is_correct' => 'required|boolean',
        ]);

        // প্রতিটি প্রশ্নে কমপক্ষে একটি সঠিক উত্তর চিহ্নিত আছে কিনা চেক
        foreach ($validated['processedQuestions'] as $qIndex => $parsedQuestion) {
            $hasCorrect = collect($parsedQuestion['options'])->contains('is_correct', true);

            if (! $hasCorrect) {
                $this->addError(
                    'processedQuestions',
                    ($qIndex + 1).' নম্বর প্রশ্নের জন্য সঠিক উত্তর (✓) চিহ্নিত করুন।'
                );

                return;
            }
        }

        $subject = Subject::query()
            ->whereKey($validated['subject_id'])
            ->where('academic_class_id', $validated['academic_class_id'])
            ->first();

        if (! $subject) {
            $this->addError('subject_id', 'Please select a subject from the selected class.');

            return;
        }

        $currentUser = auth()->user();
        $storedImagePath = $this->sourceImage?->store('questions/bulk-source', 'public');

        DB::transaction(function () use ($subject, $validated, $currentUser): void {
            foreach ($validated['processedQuestions'] as $index => $parsedQuestion) {

                // ১. স্লাগ তৈরি (টাইটেল থেকে সরাসরি, কোনো র‍্যান্ডম স্ট্রিং ছাড়া)
                $slug = Str::slug($parsedQuestion['title']);

                if (empty($slug)) {
                    $slug = preg_replace('/\s+/u', '-', trim($parsedQuestion['title']));
                    $slug = str_replace(['?', '!', "'", '"', ',', '.', '(', ')', '[', ']', '{', '}'], '', $slug);
                }

                // ২. ডাটাবেজে একই স্লাগ আছে কি না চেক (Error Handling)
                $exists = Question::where('slug', $slug)->exists();
                if ($exists) {
                    // লুপ থামিয়ে ইরর মেসেজ থ্রো করবে।
                    // এটি ট্রানজেকশনের ভেতরে থাকায় কোনো ডাটা সেভ হবে না।
                    throw new \Exception('প্রশ্ন নম্বর ('.($index + 1)."): '".$parsedQuestion['title']."' এই স্লাগটি অলরেডি ডাটাবেজে আছে। দয়া করে টাইটেল পরিবর্তন করুন।");
                }

                // ৩. অপশন ফরম্যাট করা
                $formattedOptions = collect($parsedQuestion['options'])
                    ->map(fn ($opt) => [
                        'option_text' => '<p>'.e(trim($opt['option_text'])).'</p>'."\n",
                        'is_correct' => (bool) ($opt['is_correct'] ?? false),
                    ])
                    ->values()
                    ->toArray();

                // ৪. ডাটাবেজে প্রশ্ন তৈরি
                $question = Question::query()->create([
                    'subject_id' => $subject->id,
                    'chapter_id' => $this->chapter_id,
                    'topic_id' => $this->topic_id,
                    'title' => $parsedQuestion['title'],
                    'slug' => $slug, // ক্লিন স্লাগ সেভ হবে
                    'difficulty' => $this->difficulty,
                    'question_type' => 'mcq',
                    'marks' => $this->marks,
                    'status' => $currentUser?->hasPermission('questions.publish') ? 'active' : 'pending',
                    'extra_content' => $formattedOptions,
                    'user_id' => $currentUser?->id,
                ]);

                $question->examCategories()->sync($this->exam_category_ids);
            }
        });

        session()->flash('success', count($validated['processedQuestions']).'টি প্রশ্ন সফলভাবে ডাটাবেজে সাবমিট করা হয়েছে।');
        $this->redirectRoute('questions.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.questions.bulk-upload', [
            'classes' => AcademicClass::query()->orderBy('name')->get(),
            'subjects' => $this->academic_class_id
                ? Subject::query()->where('academic_class_id', $this->academic_class_id)->orderBy('name')->get()
                : collect(),
            'chapters' => $this->subject_id
                ? Chapter::query()->where('subject_id', $this->subject_id)->orderBy('name')->get()
                : collect(),
            'topics' => $this->chapter_id
                ? Topic::query()->where('chapter_id', $this->chapter_id)->orderBy('name')->get()
                : collect(),
            'allExamCategories' => ExamCategory::query()->orderBy('name')->get(),
        ])->layout('layouts.app', ['title' => 'Bulk Question Upload']);
    }
}
