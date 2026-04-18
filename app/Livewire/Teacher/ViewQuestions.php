<?php

namespace App\Livewire\Teacher;

use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\ExamCategory;
use App\Models\Question;
use App\Models\QuestionSet;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Livewire\Component;

class ViewQuestions extends Component
{
    // UI State Properties
    public $showExplanationFor = null;

    public QuestionSet $questionSet;

    public $availableQuestions;

    public $selectedQuestions = [];

    // Base Criteria (QuestionSet থেকে আসবে)
    public $baseType;

    public $baseSubjectId;

    public $baseChapterId;

    public $baseTopicId;

    public $baseClassId;

    // Search Properties
    public $searchKeyword = '';

    // Cascading Dropdown Properties
    public $selectedClassId = null;

    public $selectedSubjectId = null;

    public $selectedChapterId = null;

    // Checkbox Filter Properties
    public $selectedTypes = [];

    public $selectedDifficulties = [];

    public $selectedTopics = [];

    public $selectedTags = [];

    public $selectedExamCategories = [];

    // Available Options for Filter Sidebar
    public $availableClasses = [];

    public $availableSubjects = [];

    public $availableChapters = [];

    public $availableTopics = [];

    public $availableTags = [];

    public $availableExamCategories = [];

    public $activeTagIds = [];

    public $activeExamCategoryIds = [];

    public function mount(Request $request)
    {
        $qsetId = $request->query('qset');
        $this->questionSet = QuestionSet::findOrFail($qsetId);

        $this->selectedQuestions = $this->questionSet->questions->pluck('id')->map(fn ($id) => (string) $id)->toArray();

        $criteria = $this->questionSet->generation_criteria;
        $this->baseType = $criteria['type'] ?? null;
        $this->baseClassId = $criteria['academic_class_id'] ?? null;
        $this->baseSubjectId = $criteria['subject_id'] ?? null;
        $this->baseChapterId = $criteria['chapter_id'] ?? null;
        $this->baseTopicId = $criteria['topic_id'] ?? null;

        $this->selectedClassId = $this->baseClassId;
        $this->selectedSubjectId = $this->baseSubjectId;
        $this->selectedChapterId = $this->baseChapterId;

        $this->loadFilterOptions();
    }

    public function loadFilterOptions()
    {
        $this->availableClasses = AcademicClass::where('is_active', true)->orderBy('name')->pluck('name', 'id')->toArray();

        $subjectQuery = Subject::where('is_active', true);
        if ($this->selectedClassId) {
            $subjectQuery->where('academic_class_id', $this->selectedClassId);
        }
        $this->availableSubjects = $subjectQuery->orderBy('name')->pluck('name', 'id')->toArray();

        $chapterQuery = Chapter::where('is_active', true);
        if ($this->selectedSubjectId) {
            $chapterQuery->where('subject_id', $this->selectedSubjectId);
        }
        $this->availableChapters = $chapterQuery->orderBy('order_sequence')->pluck('name', 'id')->toArray();

        $topicQuery = Topic::where('is_active', true);
        if ($this->selectedChapterId) {
            $topicQuery->where('chapter_id', $this->selectedChapterId);
        } elseif ($this->selectedSubjectId) {
            $topicQuery->where('subject_id', $this->selectedSubjectId);
        }
        $this->availableTopics = $topicQuery->orderBy('name')->pluck('name', 'id')->toArray();

        $this->availableTags = Tag::orderBy('name')->pluck('name', 'id')->toArray();
        $this->availableExamCategories = ExamCategory::orderBy('name')->pluck('name', 'id')->toArray();
    }

    public function updatedSelectedClassId()
    {
        $this->selectedSubjectId = null;
        $this->selectedChapterId = null;
        $this->selectedTopics = [];
        $this->loadFilterOptions();
    }

    public function updatedSelectedSubjectId()
    {
        $this->selectedChapterId = null;
        $this->selectedTopics = [];
        $this->loadFilterOptions();
    }

    public function updatedSelectedChapterId()
    {
        $this->selectedTopics = [];
        $this->loadFilterOptions();
    }

    public function toggleSelectAll()
    {
        if (count($this->selectedQuestions) === count($this->availableQuestions)) {
            $this->selectedQuestions = [];
        } else {
            $this->selectedQuestions = $this->availableQuestions->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        }
    }

    public function toggleExplanation($questionId)
    {
        $this->showExplanationFor = $this->showExplanationFor === $questionId ? null : $questionId;
    }

    public function toggleSelection($questionId)
    {
        $questionId = (string) $questionId;
        if (in_array($questionId, $this->selectedQuestions)) {
            $this->selectedQuestions = array_diff($this->selectedQuestions, [$questionId]);
        } else {
            $this->selectedQuestions[] = $questionId;
        }
    }

    public function saveSelection()
    {
        $dataToSync = [];
        $order = 1;
        foreach ($this->selectedQuestions as $questionId) {
            $dataToSync[$questionId] = ['order' => $order++];
        }
        $this->questionSet->questions()->sync($dataToSync);
        session()->flash('success', count($this->selectedQuestions).'টি প্রশ্ন সফলভাবে সেভ করা হয়েছে!');
    }

    public function render()
    {
        $activeClassId = $this->selectedClassId ?? $this->baseClassId;
        $activeSubjectId = $this->selectedSubjectId ?? $this->baseSubjectId;
        $activeChapterId = $this->selectedChapterId ?? $this->baseChapterId;

        // চেক করা হচ্ছে ইউজার কি ট্যাগ বা এক্সাম ক্যাটাগরি সিলেক্ট করেছে?
        $isGlobalFilterActive = count($this->selectedTags) > 0 || count($this->selectedExamCategories) > 0;

        $query = Question::query()
            ->with(['tags', 'examCategories'])
            ->when($this->baseType, function ($q) {
                if (in_array($this->baseType, ['composite', 'combine'])) {
                    $q->whereIn('question_type', ['mcq', 'cq', 'short']);
                } else {
                    $q->where('question_type', $this->baseType);
                }
            })

            // ক্লাস ফিল্টার (সবসময় থাকবে)
            ->when($activeClassId, fn ($q) => $q->where('academic_class_id', $activeClassId))

            // বিষয় এবং অধ্যায় ফিল্টার (ট্যাগ বা এক্সাম ক্যাটাগরি সিলেক্ট করা থাকলে এগুলো কাজ করবে না)
            ->when(!$isGlobalFilterActive && $activeSubjectId, fn ($q) => $q->where('subject_id', $activeSubjectId))
            ->when(!$isGlobalFilterActive && $activeChapterId, fn ($q) => $q->where('chapter_id', $activeChapterId))

            // অন্যান্য ফিল্টার
            ->when($this->searchKeyword, fn ($q) => $q->where('title', 'LIKE', '%' . $this->searchKeyword . '%'))
            ->when(count($this->selectedTypes) > 0, fn ($q) => $q->whereIn('question_type', $this->selectedTypes))
            ->when(count($this->selectedDifficulties) > 0, fn ($q) => $q->whereIn('difficulty', $this->selectedDifficulties))
            ->when(count($this->selectedTopics) > 0, fn ($q) => $q->whereIn('topic_id', $this->selectedTopics))

            // ট্যাগ ফিল্টার (OR লজিক)
            ->when(count($this->selectedTags) > 0, function ($q) {
                $tagIds = array_map('intval', $this->selectedTags);
                $q->whereHas('tags', fn ($q2) => $q2->whereIn('tags.id', $tagIds));
            })

            // এক্সাম ক্যাটাগরি ফিল্টার (OR লজিক)
            ->when(count($this->selectedExamCategories) > 0, function ($q) {
                $catIds = array_map('intval', $this->selectedExamCategories);
                $q->whereHas('examCategories', fn ($q2) => $q2->whereIn('exam_categories.id', $catIds));
            })

            ->orderBy('topic_id', 'asc')->orderBy('id', 'asc');

        $this->availableQuestions = $query->get();

        if ($this->availableQuestions->isNotEmpty()) {
            $this->activeTagIds = $this->availableQuestions->flatMap->tags->pluck('id')->unique()->values()->toArray();
            $this->activeExamCategoryIds = $this->availableQuestions->flatMap->examCategories->pluck('id')->unique()->values()->toArray();
        } else {
            $this->activeTagIds = [];
            $this->activeExamCategoryIds = [];
        }

        return view('livewire.teacher.view-questions')
            ->layout('layouts.app');
    }
}
