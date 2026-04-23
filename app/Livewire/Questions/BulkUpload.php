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
     * @var array<int, array{title: string, options: array<int, array{option_text: string, is_correct: bool}>}>
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

    public function processQuestions(): void
    {
        $rawText = trim($this->rawText);

        if ($rawText === '') {
            $this->addError('rawText', 'অনুগ্রহ করে OCR / Raw প্রশ্ন টেক্সট দিন, তারপর Process Questions ক্লিক করুন।');

            return;
        }

        $validated = $this->validate([
            'rawText' => 'string|min:20',
        ], [
            'rawText.min' => 'কমপক্ষে ২০ অক্ষরের প্রশ্ন টেক্সট দিন।',
        ]);

        $this->processedQuestions = QuestionTextParser::parseMcqText($validated['rawText']);

        if (empty($this->processedQuestions)) {
            $this->addError('rawText', 'টেক্সট থেকে কোন MCQ প্রশ্ন পাওয়া যায়নি। নম্বর + (ক)/(খ)/(গ)/(ঘ) ফরম্যাটে দিন।');

            return;
        }

        $this->rawText = $this->formatProcessedQuestionsForTextarea();

        session()->flash('success', count($this->processedQuestions).'টি প্রশ্ন প্রসেস করা হয়েছে। OCR / Raw প্রশ্ন টেক্সট বক্সে দেখুন, তারপর Submit করুন।');
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
        ]);

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

        DB::transaction(function () use ($subject, $validated, $storedImagePath, $currentUser): void {
            foreach ($validated['processedQuestions'] as $parsedQuestion) {
                $question = Question::query()->create([
                    'subject_id' => $subject->id,
                    'chapter_id' => $this->chapter_id,
                    'topic_id' => $this->topic_id,
                    'title' => $parsedQuestion['title'],
                    'slug' => Str::slug(Str::limit($parsedQuestion['title'], 100, '')).'-'.Str::lower(Str::random(6)),
                    'difficulty' => $this->difficulty,
                    'question_type' => 'mcq',
                    'marks' => $this->marks,
                    'status' => $currentUser?->hasPermission('questions.publish') ? 'active' : 'pending',
                    'extra_content' => [
                        'options' => $parsedQuestion['options'],
                        'source_image' => $storedImagePath,
                        'uploaded_via' => 'bulk_upload',
                    ],
                    'user_id' => $currentUser?->id,
                ]);

                $question->examCategories()->sync($this->exam_category_ids);
            }
        });

        session()->flash('success', count($validated['processedQuestions']).'টি প্রশ্ন সফলভাবে ডাটাবেজে সাবমিট করা হয়েছে।');
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
