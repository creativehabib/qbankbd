<?php

namespace App\Livewire\Questions;

use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\ExamCategory;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Support\QuestionTextParser;
use Google\ApiCore\ValidationException;
use Google\Cloud\Vision\V1\AnnotateFileRequest;
use Google\Cloud\Vision\V1\BatchAnnotateFilesRequest;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\InputConfig;
use Illuminate\Support\Facades\DB;
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

    public ?TemporaryUploadedFile $sourceFile = null; // ← image + PDF দুটোই

    public string $rawText = '';

    public array $processedQuestions = [];

    public function updatedAcademicClassId(): void
    {
        $this->subject_id = null;
        $this->chapter_id = null;
        $this->topic_id = null;
    }

    public function updatedSubjectId(): void
    {
        $this->chapter_id = null;
        $this->topic_id = null;
    }

    public function updatedChapterId(): void
    {
        $this->topic_id = null;
    }

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

        if ($rawText === '' && $this->sourceFile) {
            $rawText = $this->extractTextFromFile();
            $this->rawText = $rawText;
        }

        if ($rawText === '') {
            $this->addError('rawText', 'অনুগ্রহ করে প্রশ্নের টেক্সট দিন অথবা একটি ইমেজ/PDF আপলোড করুন।');

            return;
        }

        $validated = $this->validate([
            'rawText' => 'string|min:20',
        ], [
            'rawText.min' => 'কমপক্ষে ২০ অক্ষরের প্রশ্ন টেক্সট দিন।',
        ]);

        $parsed = QuestionTextParser::parseMcqText($validated['rawText']);

        if (empty($parsed)) {
            $this->addError('rawText', 'টেক্সট থেকে কোন MCQ প্রশ্ন পাওয়া যায়নি।');

            return;
        }

        foreach ($parsed as $qi => $question) {
            foreach ($question['options'] as $oi => $option) {
                $parsed[$qi]['options'][$oi]['is_correct'] = (bool) ($option['is_correct'] ?? false);
            }
        }

        $this->processedQuestions = $parsed;
        $this->rawText = $this->formatProcessedQuestionsForTextarea();
        session()->flash('success', count($this->processedQuestions).'টি প্রশ্ন প্রসেস হয়েছে।');
    }

    protected function extractTextFromFile(): string
    {
        $this->validate([
            'sourceFile' => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:10240',
        ]);

        if (! $this->sourceFile) {
            return '';
        }

        $mimeType = $this->sourceFile->getMimeType();
        $isPdf = $mimeType === 'application/pdf'
            || strtolower($this->sourceFile->getClientOriginalExtension()) === 'pdf';

        if ($isPdf) {
            return $this->extractTextFromPdfViaVision();
        }

        return $this->extractTextFromImageViaVision();
    }

    /**
     * Image → Google Vision OCR (বাংলা সহ সব ভাষা)
     */
    protected function extractTextFromImageViaVision(): string
    {
        $filePath = $this->sourceFile->getRealPath();

        if (! $filePath || ! is_readable($filePath)) {
            $this->addError('sourceFile', 'ফাইলটি পড়া যাচ্ছে না।');

            return '';
        }

        try {
            $imageAnnotator = $this->makeVisionClient();
            $imageContent = file_get_contents($filePath);

            // document_text_detection → dense/structured text (বাংলার জন্য ভালো)
            $response = $imageAnnotator->documentTextDetection($imageContent);
            $imageAnnotator->close();

            $annotation = $response->getFullTextAnnotation();

            if (! $annotation) {
                $this->addError('sourceFile', 'ইমেজ থেকে কোনো টেক্সট পাওয়া যায়নি।');

                return '';
            }

            return trim($annotation->getText());

        } catch (\Exception $e) {
            $this->addError('sourceFile', 'Google Vision Error: '.$e->getMessage());

            return '';
        }
    }

    /**
     * PDF → Google Vision (প্রতিটি পেজ image হিসেবে OCR)
     * ছোট PDF (≤5 পেজ) এর জন্য synchronous approach
     */
    protected function extractTextFromPdfViaVision(): string
    {
        $filePath = $this->sourceFile->getRealPath();

        if (! $filePath || ! is_readable($filePath)) {
            $this->addError('sourceFile', 'PDF ফাইলটি পড়া যাচ্ছে না।');

            return '';
        }

        try {
            // পদ্ধতি ১: PDF content সরাসরি Vision API-তে (DOCUMENT_TEXT_DETECTION)
            // এটি PDF-এর প্রতিটি পেজ internally render করে OCR করে
            $imageAnnotator = $this->makeVisionClient();

            $pdfContent = file_get_contents($filePath);
            $encodedPdf = base64_encode($pdfContent);

            // Vision API-র inputConfig দিয়ে PDF পাঠানো
            $inputConfig = new InputConfig([
                'mime_type' => 'application/pdf',
                'content' => $pdfContent,
            ]);

            $features = [
                new Feature([
                    'type' => Type::DOCUMENT_TEXT_DETECTION,
                ]),
            ];

            $request = new AnnotateFileRequest([
                'input_config' => $inputConfig,
                'features' => $features,
                // প্রথম ৫ পেজ (Vision sync limit)
                'pages' => range(1, 5),
            ]);

            $batchRequest = new BatchAnnotateFilesRequest([
                'requests' => [$request],
            ]);

            $batchResponse = $imageAnnotator->batchAnnotateFiles($batchRequest);
            $imageAnnotator->close();

            $allText = [];
            foreach ($batchResponse->getResponses() as $fileResponse) {
                foreach ($fileResponse->getResponses() as $pageResponse) {
                    $annotation = $pageResponse->getFullTextAnnotation();
                    if ($annotation && trim($annotation->getText()) !== '') {
                        $allText[] = trim($annotation->getText());
                    }
                }
            }

            if (empty($allText)) {
                $this->addError('sourceFile', 'PDF থেকে কোনো টেক্সট পাওয়া যায়নি। পরিষ্কার স্ক্যান করা PDF দিন।');

                return '';
            }

            return implode("\n\n", $allText);

        } catch (\Exception $e) {
            $this->addError('sourceFile', 'PDF OCR Error: '.$e->getMessage());

            return '';
        }
    }

    /**
     * @throws ValidationException
     */
    protected function makeVisionClient(): ImageAnnotatorClient
    {
        $credentialsPath = config('services.google_vision.credentials');
        $credentialsJson = config('services.google_vision.credentials_json');

        $options = [];

        if ($credentialsJson) {
            // JSON string সরাসরি (যেমন Heroku/Render-এ env var হিসেবে)
            $options['credentials'] = json_decode($credentialsJson, true);
        } elseif ($credentialsPath && file_exists($credentialsPath)) {
            $options['keyFilePath'] = $credentialsPath;
        }
        // credentials না দিলে Application Default Credentials (ADC) ব্যবহার হবে

        return new ImageAnnotatorClient($options);
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
            'sourceFile' => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:10240',
            'processedQuestions' => 'required|array|min:1',
            'processedQuestions.*.title' => 'required|string',
            'processedQuestions.*.options' => 'required|array|min:2',
            'processedQuestions.*.options.*.option_text' => 'required|string',
            'processedQuestions.*.options.*.is_correct' => 'required|boolean',
        ]);

        foreach ($validated['processedQuestions'] as $qIndex => $parsedQuestion) {
            $hasCorrect = collect($parsedQuestion['options'])->contains('is_correct', true);
            if (! $hasCorrect) {
                $this->addError('processedQuestions', ($qIndex + 1).' নম্বর প্রশ্নের সঠিক উত্তর চিহ্নিত করুন।');

                return;
            }
        }

        $subject = Subject::query()
            ->whereKey($validated['subject_id'])
            ->where('academic_class_id', $validated['academic_class_id'])
            ->first();

        if (! $subject) {
            $this->addError('subject_id', 'নির্বাচিত ক্লাসের বিষয় সিলেক্ট করুন।');

            return;
        }

        $currentUser = auth()->user();
        $storedFilePath = $this->sourceFile?->store('questions/bulk-source', 'public');

        DB::transaction(function () use ($subject, $validated, $currentUser): void {
            foreach ($validated['processedQuestions'] as $index => $parsedQuestion) {
                $slug = Str::slug($parsedQuestion['title']);
                if (empty($slug)) {
                    $slug = preg_replace('/\s+/u', '-', trim($parsedQuestion['title']));
                    $slug = str_replace(['?', '!', "'", '"', ',', '.', '(', ')', '[', ']', '{', '}'], '', $slug);
                }

                if (Question::where('slug', $slug)->exists()) {
                    throw new \Exception('প্রশ্ন '.($index + 1).': এই স্লাগটি ইতিমধ্যে আছে।');
                }

                $formattedOptions = collect($parsedQuestion['options'])
                    ->map(fn ($opt) => [
                        'option_text' => '<p>'.e(trim($opt['option_text'])).'</p>'."\n",
                        'is_correct' => (bool) ($opt['is_correct'] ?? false),
                    ])
                    ->values()->toArray();

                $question = Question::query()->create([
                    'subject_id' => $subject->id,
                    'chapter_id' => $this->chapter_id,
                    'topic_id' => $this->topic_id,
                    'title' => $parsedQuestion['title'],
                    'slug' => $slug,
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

        session()->flash('success', count($validated['processedQuestions']).'টি প্রশ্ন সফলভাবে সাবমিট হয়েছে।');
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
