<?php

namespace App\Livewire\Questions;

use App\Livewire\Traits\SlugValidationTrait;
use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\ExamCategory; // Image Upload এর জন্য
use App\Models\Question;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\Topic;
use App\Services\GeminiService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use AuthorizesRequests, SlugValidationTrait, WithFileUploads; // WithFileUploads যুক্ত করা হলো

    public $subject_id;

    public $academic_class_id;

    public $chapter_id;

    public $topic_id;

    public $title;

    public $description;

    public $difficulty = 'easy';

    public $question_type = 'mcq';

    public $marks = 1;

    public $tagIds = [];

    public $options = [];

    public $cq = [];

    public $slug;

    public $exam_category_ids = []; // Target Audience

    public $image; // Written প্রশ্নের ছবির জন্য

    public $aiPrompt = '';

    public function mount(): void
    {
        $this->resetFields();
    }

    public function resetFields(): void
    {
        $this->reset('academic_class_id', 'subject_id', 'chapter_id', 'topic_id', 'title', 'description', 'difficulty', 'question_type', 'marks', 'tagIds', 'options', 'cq', 'slug', 'exam_category_ids', 'image');
        $this->difficulty = 'easy';
        $this->question_type = 'mcq';
        $this->marks = 1;
        $this->resetToMcq();
        $this->setCqDefaults();
        $this->dispatch('reset-selects');
    }

    private function resetToMcq(): void
    {
        $this->options = [
            ['option_text' => '', 'is_correct' => false],
            ['option_text' => '', 'is_correct' => false],
            ['option_text' => '', 'is_correct' => false],
            ['option_text' => '', 'is_correct' => false],
        ];
    }

    // --- MCQ Options Methods ---
    public function addOption(): void
    {
        $this->options[] = ['option_text' => '', 'is_correct' => false];
        $this->dispatch('refresh-editors');
    }

    public function removeOption($index): void
    {
        if (count($this->options) > 2) {
            unset($this->options[$index]);
            $this->options = array_values($this->options);
        }
    }

    // --- CQ Methods ---
    private function setCqDefaults(): void
    {
        $this->cq = [
            ['id' => uniqid(), 'label' => 'ক', 'text' => '', 'answer' => '', 'marks' => 1],
            ['id' => uniqid(), 'label' => 'খ', 'text' => '', 'answer' => '', 'marks' => 2],
            ['id' => uniqid(), 'label' => 'গ', 'text' => '', 'answer' => '', 'marks' => 3],
            ['id' => uniqid(), 'label' => 'ঘ', 'text' => '', 'answer' => '', 'marks' => 4],
        ];
    }

    public function addCqPart(): void
    {
        $labels = ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ', 'ছ', 'জ', 'ঝ', 'ঞ'];
        $nextLabel = $labels[count($this->cq)] ?? '*';

        $this->cq[] = ['id' => uniqid(), 'label' => $nextLabel, 'text' => '', 'answer' => '', 'marks' => 1];

        $this->calculateCqMarks();
        $this->dispatch('refresh-editors');
    }

    public function removeCqPart($index): void
    {
        unset($this->cq[$index]);
        $this->cq = array_values($this->cq);
        $this->calculateCqMarks();
    }

    public function calculateCqMarks(): void
    {
        $this->marks = array_sum(array_column($this->cq, 'marks'));
    }

    public function updated($property, $value): void
    {
        if ($this->question_type === 'cq' && str_starts_with($property, 'cq.') && str_ends_with($property, '.marks')) {
            $this->calculateCqMarks();
        }
    }

    // ইউজার স্লাগ টাইপ করার সাথে সাথে Livewire অটোমেটিক এটি চেক করবে
    public function updatedSlug($value)
    {
        $this->validateOnly('slug', [
            'slug' => 'required|string|max:255|unique:questions,slug',
        ], [
            'slug.unique' => 'এই স্লাগটি আগে থেকেই ব্যবহৃত হচ্ছে। দয়া করে একটু পরিবর্তন করুন।',
        ]);
    }

    public function updatedQuestionType($value): void
    {
        if ($value === 'mcq') {
            $this->marks = 1;
            if (empty($this->options)) {
                $this->resetToMcq();
            }
        } elseif ($value === 'cq') {
            if (empty($this->cq)) {
                $this->setCqDefaults();
            }
            $this->calculateCqMarks();
            $this->options = [];
        } else {
            $this->marks = 2; // Short & Written Question
            $this->options = [];
        }
        $this->dispatch('refresh-editors');
    }

    // 🌟 AI জেনারেটর ফাংশন
    public function generateAiQuestion(): void
    {
        $this->validate([
            'aiPrompt' => 'required|string|max:255',
        ]);

        // প্রশ্ন টাইপ অটোমেটিক MCQ করে দেওয়া হচ্ছে
        $this->question_type = 'mcq';
        if (empty($this->options)) {
            $this->resetToMcq();
        }

        // 🌟 AI এর জন্য কড়া প্রম্পট (Random Answer) 🌟
        $prompt = "Create 1 multiple-choice question in Bengali language about '{$this->aiPrompt}'.
        IMPORTANT RULE: RANDOMLY place the correct answer in A, B, C, or D. Do NOT always make 'A' the correct answer.
        You MUST return the response strictly in the following JSON format, and nothing else (no markdown, no extra text):
        {
            \"question\": \"এখানে প্রশ্ন থাকবে?\",
            \"options\": {
                \"A\": \"প্রথম অপশন\",
                \"B\": \"দ্বিতীয় অপশন\",
                \"C\": \"তৃতীয় অপশন\",
                \"D\": \"চতুর্থ অপশন\"
            },
            \"answer\": \"সঠিক অপশনের Letter (যেমন: B বা C বা D)\"
        }";

        try {
            // 🌟 আমাদের তৈরি করা সার্ভিস ক্লাস ব্যবহার করা হচ্ছে (৬০ সেকেন্ড টাইমআউট) 🌟
            $geminiService = new GeminiService;
            $aiData = $geminiService->generateJson($prompt, 60);

            if (is_array($aiData) && isset($aiData['question'], $aiData['options'])) {
                // 🌟 ফর্মের ফিল্ডগুলো অটোমেটিক পূরণ করা হচ্ছে 🌟
                $this->title = $aiData['question'];

                $this->options = [
                    ['option_text' => $aiData['options']['A'], 'is_correct' => $aiData['answer'] === 'A'],
                    ['option_text' => $aiData['options']['B'], 'is_correct' => $aiData['answer'] === 'B'],
                    ['option_text' => $aiData['options']['C'], 'is_correct' => $aiData['answer'] === 'C'],
                    ['option_text' => $aiData['options']['D'], 'is_correct' => $aiData['answer'] === 'D'],
                ];

                // 🌟 CKEditor রিলোড করার সিগন্যাল 🌟
                $this->dispatch('refresh-editors');
                $this->dispatch('ai-data-filled', title: $this->title, options: $this->options);
                session()->flash('ai_success', 'AI দিয়ে সফলভাবে প্রশ্ন অটো-ফিল করা হয়েছে!');
            } else {
                $this->addError('aiPrompt', 'AI সঠিক ফরম্যাটে উত্তর দিতে পারেনি।');
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            // 🌟 কোটা লিমিট শেষ হলে সুন্দর বাংলা মেসেজ 🌟
            if (str_contains($errorMessage, 'Quota exceeded') || str_contains($errorMessage, '429')) {
                $this->addError('aiPrompt', 'AI সার্ভারে এখন অনেক চাপ। অনুগ্রহ করে ১ মিনিট অপেক্ষা করে আবার চেষ্টা করুন।');
            } else {
                $this->addError('aiPrompt', 'Error: '.$errorMessage);
            }
        }
    }

    public function updatedSubjectId($value)
    {
        $this->chapter_id = null;
        $this->topic_id = null;
        $chapters = Chapter::where('subject_id', $value)->get()->map(fn ($s) => ['value' => $s->id, 'text' => $s->name])->all();
        $this->dispatch('chaptersUpdated', chapters: $chapters);

        $this->dispatch('topicsUpdated', topics: []);
    }

    public function updatedAcademicClassId($value): void
    {
        $this->subject_id = null;
        $this->chapter_id = null;
        $this->topic_id = null;

        $subjects = Subject::query()
            ->where('academic_class_id', $value)
            ->orderBy('name')
            ->get()
            ->map(fn ($subject) => ['value' => $subject->id, 'text' => $subject->name])
            ->all();

        $this->dispatch('subjectsUpdated', subjects: $subjects);
        $this->dispatch('chaptersUpdated', chapters: []);
        $this->dispatch('topicsUpdated', topics: []);
    }

    public function updatedChapterId($value)
    {
        $this->topic_id = null;
        $topics = $value ? Topic::where('chapter_id', $value)->get()->map(fn ($c) => ['value' => $c->id, 'text' => $c->name])->all() : [];
        $this->dispatch('topicsUpdated', topics: $topics);
    }

    public function save()
    {
        $currentUser = auth()->user();

        abort_unless($currentUser?->hasPermission('questions.create'), 403);

        $rules = [
            'academic_class_id' => 'required|exists:academic_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'chapter_id' => 'nullable|exists:chapters,id',
            'topic_id' => 'required_with:chapter_id|nullable|exists:topics,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'question_type' => 'required|in:mcq,cq,short,written', // written যুক্ত করা হয়েছে
            'marks' => 'required|integer|min:0',
            'tagIds' => 'nullable|array',
            'exam_category_ids' => 'required|array|min:1', // Target Audience Required
            'exam_category_ids.*' => 'exists:exam_categories,id',
            'slug' => ['required', 'string', 'max:255', Rule::unique('questions', 'slug')],
            'image' => 'nullable|image|max:2048', // ইমেজের ভ্যালিডেশন
        ];

        if ($this->question_type === 'mcq') {
            $rules['options'] = 'required|array|min:2';
            $rules['options.*.option_text'] = 'required|string';
        }

        $validated = $this->validate($rules);

        $subject = Subject::query()
            ->whereKey($validated['subject_id'])
            ->where('academic_class_id', $validated['academic_class_id'])
            ->first();

        if (! $subject) {
            $this->addError('subject_id', 'Please select a subject from the selected class.');

            return;
        }

        DB::transaction(function () use ($currentUser, $subject) {
            $extraData = null;

            // টাইপ অনুযায়ী extra_content এ ডাটা সেট
            if ($this->question_type === 'cq') {
                $extraData = $this->cq;
            } elseif ($this->question_type === 'mcq') {
                $extraData = $this->options;
            } elseif ($this->question_type === 'written') {
                $imagePath = null;
                if ($this->image) {
                    $imagePath = $this->image->store('questions', 'public');
                }
                $extraData = ['image' => $imagePath];
            }

            $question = Question::create([
                'subject_id' => $subject->id,
                'chapter_id' => $this->chapter_id ?: null,
                'topic_id' => $this->topic_id ?: null,
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'difficulty' => $this->difficulty,
                'question_type' => $this->question_type,
                'marks' => (float) $this->marks == floor((float) $this->marks) ? (int) $this->marks : (float) $this->marks,
                'status' => $currentUser?->hasPermission('questions.publish') ? 'active' : 'pending',
                'is_paid' => false,
                'extra_content' => $extraData,
                'user_id' => $currentUser?->id,
            ]);

            // Tags যুক্ত করা
            if ($this->tagIds) {
                $tagIds = collect($this->tagIds)->map(fn ($tag) => is_numeric($tag) ? (int) $tag : Tag::firstOrCreate(['name' => $tag])->id)->toArray();
                $question->tags()->sync($tagIds);
            }

            // Exam Categories (Target Audience) যুক্ত করা
            if (! empty($this->exam_category_ids)) {
                $question->examCategories()->sync($this->exam_category_ids);
            }

        });

        return redirect()->route('questions.index')->with('success', 'Question created successfully.');
    }

    public function render()
    {
        $layout = auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.panel';

        return view('livewire.admin.questions.create', [
            'classes' => AcademicClass::query()->orderBy('name')->get(),
            'subjects' => $this->academic_class_id
                ? Subject::query()
                    ->where('academic_class_id', $this->academic_class_id)
                    ->orderBy('name')
                    ->get()
                : collect(),
            'chapters' => Chapter::where('subject_id', $this->subject_id)->get(),
            'topics' => Topic::where('chapter_id', $this->chapter_id)->get(),
            'allTags' => Tag::all(),
            'allExamCategories' => ExamCategory::all(), // টার্গেট ক্যাটাগরি পাঠানো হলো
        ])->layout('layouts.app', ['title' => 'Manage Questions']);
    }
}
