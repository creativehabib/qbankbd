<?php

namespace App\Livewire\Students;

use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class PracticeIndex extends Component
{
    use WithPagination;

    public string $level = 'classes';
    public string $activeTab = 'fast';
    public string $search = '';
    public ?int $selectedClassId = null;
    public ?int $selectedSubjectId = null;
    public ?int $selectedChapterId = null;

    public array $filterQuestionTypes = [];
    public array $filterClasses = [];
    public array $filterSubjects = [];
    public array $filterTeachers = [];
    public string $filterSearch = '';
    public ?string $mockTestError = null;

    public function mount(): void
    {
        abort_unless(auth()->user()?->isStudent(), 403);
    }

    public function updated($property): void
    {
        if (str_starts_with($property, 'filter')) {
            $this->evaluateFilterState();
        }
    }

    private function evaluateFilterState(): void
    {
        $hasFilters = ! empty($this->filterQuestionTypes)
            || ! empty($this->filterClasses)
            || ! empty($this->filterSubjects)
            || ! empty($this->filterTeachers)
            || filled($this->filterSearch);

        if ($hasFilters) {
            if ($this->level !== 'filtered-questions') {
                $this->level = 'filtered-questions';
            }
        } else {
            if ($this->level === 'filtered-questions') {
                $this->level = 'questions';
            }
        }

        $this->resetPage();
        $this->dispatch('practice-content-updated');
    }

    public function resetFilter(): void
    {
        $this->filterQuestionTypes = [];
        $this->filterClasses = [];
        $this->filterSubjects = [];
        $this->filterTeachers = [];
        $this->filterSearch = '';

        if ($this->level === 'filtered-questions') {
            $this->level = 'questions';
        }

        $this->resetPage();
        $this->dispatch('practice-content-updated');
    }

    // --- Navigation Methods ---

    public function openClass(int $classId): void
    {
        $isValidClass = AcademicClass::query()->whereKey($classId)->where('is_active', true)->exists();
        if ($isValidClass) {
            $this->selectedClassId = $classId;
            $this->selectedSubjectId = null;
            $this->selectedChapterId = null;
            $this->level = 'subjects';
            $this->search = '';
            $this->resetPage();
            $this->dispatch('practice-content-updated');
        }
    }

    public function openSubject(int $subjectId): void
    {
        $isValidSubject = Subject::query()->whereKey($subjectId)->where('academic_class_id', $this->selectedClassId)->where('is_active', true)->exists();
        if ($isValidSubject) {
            $this->selectedSubjectId = $subjectId;
            $this->selectedChapterId = null;
            $this->level = 'chapters';
            $this->search = '';
            $this->resetPage();
            $this->dispatch('practice-content-updated');
        }
    }

    public function startSubjectPractice(int $subjectId): void
    {
        $isValidSubject = Subject::query()->whereKey($subjectId)->where('academic_class_id', $this->selectedClassId)->where('is_active', true)->exists();
        if ($isValidSubject) {
            $this->selectedSubjectId = $subjectId;
            $this->selectedChapterId = null;
            $this->level = 'questions';
            $this->search = '';
            $this->resetPage();
            $this->dispatch('practice-content-updated');
        }
    }

    public function openChapter(int $chapterId): void
    {
        $isValidChapter = Chapter::query()->whereKey($chapterId)->where('subject_id', $this->selectedSubjectId)->where('is_active', true)->exists();
        if ($isValidChapter) {
            $this->selectedChapterId = $chapterId;
            $this->level = 'questions';
            $this->search = '';
            $this->resetPage();
            $this->dispatch('practice-content-updated');
        }
    }

    public function startMockTest(): void
    {
        $this->mockTestError = null;

        if (!$this->selectedClassId || !$this->selectedSubjectId) {
            $this->mockTestError = 'দয়া করে শ্রেণি এবং বিষয় নির্বাচন করুন।';
            return;
        }

        $questions = Question::query()
            ->where('subject_id', $this->selectedSubjectId)
            ->where('question_type', 'mcq')
            ->where('status', 'active')
            ->inRandomOrder()
            ->limit(20)
            ->get();

        if ($questions->isEmpty()) {
            $this->mockTestError = 'দুঃখিত! এই বিষয়ে মক টেস্ট তৈরি করার মতো কোনো প্রশ্ন পাওয়া যায়নি।';
            return;
        }

        $mockTest = \App\Models\MockTest::create([
            'user_id' => auth()->id(),
            'academic_class_id' => $this->selectedClassId,
            'subject_id' => $this->selectedSubjectId,
            'total_questions' => $questions->count(),
            'duration_minutes' => 20,
            'status' => 'started',
        ]);

        $mockTestQuestionsData = $questions->map(function ($question) use ($mockTest) {
            return [
                'mock_test_id' => $mockTest->id,
                'question_id' => $question->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        \App\Models\MockTestQuestion::insert($mockTestQuestionsData);

        $this->redirectRoute('student.mock-test.take', ['testId' => $mockTest->id], navigate: true);
    }

    public function back(): void
    {
        if ($this->level === 'filtered-questions') {
            $this->level = 'questions';
        } elseif ($this->level === 'questions') {
            if ($this->selectedChapterId !== null) {
                $this->selectedChapterId = null;
                $this->level = 'chapters';
            } else {
                $this->selectedSubjectId = null;
                $this->level = 'subjects';
            }
        } elseif ($this->level === 'chapters') {
            $this->selectedSubjectId = null;
            $this->selectedChapterId = null;
            $this->level = 'subjects';
        } elseif ($this->level === 'subjects') {
            $this->selectedClassId = null;
            $this->selectedSubjectId = null;
            $this->selectedChapterId = null;
            $this->level = 'classes';
        }

        $this->search = '';
        $this->resetPage();
        $this->dispatch('practice-content-updated');
    }

    // --- Dynamic Actions (Scalable Approach) ---

    public function toggleLike(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $toggled = $question->likes()->toggle(auth()->id());

        if (count($toggled['attached']) > 0) {
            $question->increment('likes_count');
        } elseif (count($toggled['detached']) > 0) {
            $question->decrement('likes_count');
        }
    }

    public function toggleBookmark(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $toggled = $question->bookmarks()->toggle(auth()->id());

        if (count($toggled['attached']) > 0) {
            $question->increment('bookmarks_count');
        } elseif (count($toggled['detached']) > 0) {
            $question->decrement('bookmarks_count');
        }
    }

    public function recordView(int $questionId): void
    {
        $viewerId = auth()->check() ? 'user_' . auth()->id() : 'ip_' . request()->ip();
        $cacheKey = "viewed_question_{$questionId}_by_{$viewerId}";

        if (!Cache::has($cacheKey)) {
            Question::where('id', $questionId)->increment('views_count');
            Cache::put($cacheKey, true, now()->addHours(24));
        }
    }

    // --- Data Fetching ---

    protected function getFilterOptions(): array
    {
        return [
            'classes' => AcademicClass::where('is_active', true)->orderBy('name')->pluck('name', 'id')->toArray(),
            'subjects' => Subject::where('is_active', true)->orderBy('name')->pluck('name', 'id')->toArray(),
            'teachers' => User::role('teacher')->orderBy('name')->pluck('name', 'id')->toArray(),
        ];
    }

    protected function classes(): Collection
    {
        return AcademicClass::query()->where('is_active', true)
            ->withCount(['questions as mcq_questions_count' => fn (Builder $q) => $q->where('question_type', 'mcq')])
            ->orderBy('name')->get(['id', 'name']);
    }

    protected function subjects(): Collection
    {
        if ($this->selectedClassId === null) {
            return collect();
        }

        return Subject::query()->where('academic_class_id', $this->selectedClassId)->where('is_active', true)
            ->when(filled($this->search), fn (Builder $q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->withCount(['questions as mcq_questions_count' => fn (Builder $q) => $q->where('question_type', 'mcq')])
            ->orderBy('name')->get(['id', 'name', 'slug']);
    }

    protected function chapters(): Collection
    {
        if ($this->selectedSubjectId === null) {
            return collect();
        }

        return Chapter::query()->where('subject_id', $this->selectedSubjectId)->where('is_active', true)
            ->when(filled($this->search), fn (Builder $q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->withCount(['questions as mcq_questions_count' => fn (Builder $q) => $q->where('question_type', 'mcq')])
            ->orderBy('name')->get(['id', 'name', 'slug']);
    }

    protected function latestQuestions(): LengthAwarePaginator
    {
        if ($this->selectedSubjectId === null && $this->selectedChapterId === null) {
            return new LengthAwarePaginator([], 0, 20, 1);
        }

        return Question::query()
            ->where('question_type', 'mcq')->where('status', 'active')
            ->when($this->selectedChapterId !== null, fn (Builder $q) => $q->where('chapter_id', $this->selectedChapterId))
            ->when($this->selectedChapterId === null && $this->selectedSubjectId !== null, fn (Builder $q) => $q->where('subject_id', $this->selectedSubjectId))
            ->with(['academicClass:id,name', 'subject:id,name', 'chapter:id,name', 'examCategories:id,name'])
            ->withExists([
                'likes as is_liked' => fn (Builder $q) => $q->where('user_id', auth()->id()),
                'bookmarks as is_bookmarked' => fn (Builder $q) => $q->where('user_id', auth()->id()),
            ])
            ->latest('id')->paginate(20);
    }

    protected function filteredQuestions(): LengthAwarePaginator
    {
        return Question::query()
            ->when(! empty($this->filterQuestionTypes), fn (Builder $query) => $query->whereIn('question_type', $this->filterQuestionTypes))
            ->where('status', 'active')
            ->when(! empty($this->filterClasses), fn (Builder $query) => $query->whereIn('academic_class_id', $this->filterClasses))
            ->when(! empty($this->filterSubjects), fn (Builder $query) => $query->whereIn('subject_id', $this->filterSubjects))
            ->when(! empty($this->filterTeachers), fn (Builder $query) => $query->whereIn('user_id', $this->filterTeachers))
            ->when(filled($this->filterSearch), fn (Builder $query) => $query->where('title', 'like', '%'.$this->filterSearch.'%'))
            ->with(['academicClass:id,name', 'subject:id,name', 'chapter:id,name'])
            ->withExists([
                'likes as is_liked' => fn (Builder $q) => $q->where('user_id', auth()->id()),
                'bookmarks as is_bookmarked' => fn (Builder $q) => $q->where('user_id', auth()->id()),
            ])
            ->latest('id')
            ->paginate(20);
    }

    public function render(): View
    {
        $selectedClassName = AcademicClass::query()->whereKey($this->selectedClassId)->value('name');
        $selectedSubjectName = Subject::query()->whereKey($this->selectedSubjectId)->value('name');
        $selectedChapterName = Chapter::query()->whereKey($this->selectedChapterId)->value('name');

        return view('livewire.students.practice-index', [
            'classes' => $this->classes(),
            'subjects' => $this->subjects(),
            'chapters' => $this->chapters(),
            'latestQuestions' => $this->latestQuestions(),
            'filteredQuestions' => $this->filteredQuestions(),
            'filterOptions' => $this->getFilterOptions(),
            'selectedClassName' => $selectedClassName,
            'selectedSubjectName' => $selectedSubjectName,
            'selectedChapterName' => $selectedChapterName,
        ])->layout('layouts.app', ['title' => 'Practice']);
    }
}
