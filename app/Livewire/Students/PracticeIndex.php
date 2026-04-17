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

    public function mount(): void
    {
        abort_unless(auth()->user()?->isStudent(), 403);
    }

    // লাইভ ফিল্টার হুক
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

        // ফিল্টার থাকলে filtered-questions এ নিয়ে যাবে
        if ($hasFilters) {
            if ($this->level !== 'filtered-questions') {
                $this->level = 'filtered-questions';
            }
        } else {
            // সব ফিল্টার খালি হয়ে গেলে আগের অবস্থায় (চ্যাপ্টারের প্রশ্নে) ফিরিয়ে আনবে
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

        // যদি ফিল্টার ভিউতে থাকে, তাহলে মূল চ্যাপ্টারের প্রশ্নে ফিরিয়ে আনবে (ক্লাসে নয়)
        if ($this->level === 'filtered-questions') {
            $this->level = 'questions';
        }

        $this->resetPage();
        $this->dispatch('practice-content-updated');
    }

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

    public function back(): void
    {
        match ($this->level) {
            'filtered-questions' => [$this->level] = ['questions'], // ফিল্টার থেকে ব্যাক ক্লিক করলে চ্যাপ্টারে যাবে
            'questions' => [$this->selectedChapterId, $this->level] = [null, 'chapters'],
            'chapters' => [$this->selectedSubjectId, $this->selectedChapterId, $this->level] = [null, null, 'subjects'],
            'subjects' => [$this->selectedClassId, $this->selectedSubjectId, $this->selectedChapterId, $this->level] = [null, null, null, 'classes'],
            default => null,
        };
        $this->search = '';
        $this->resetPage();
        $this->dispatch('practice-content-updated');
    }

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
        if ($this->selectedChapterId === null) {
            return new LengthAwarePaginator([], 0, 20, 1);
        }

        return Question::query()
            ->where('question_type', 'mcq')->where('status', 'active')->where('chapter_id', $this->selectedChapterId)
            ->with(['academicClass:id,name', 'subject:id,name', 'chapter:id,name', 'examCategories:id,name'])
            ->latest('id')->paginate(20);
    }

    /**
     * @return LengthAwarePaginator<int, Question>
     */
    protected function filteredQuestions(): LengthAwarePaginator
    {
        return Question::query()
            // গুরুত্বপূর্ণ: when ব্যবহার করা হয়েছে, যাতে ফাঁকা থাকলে এরর না দেখায়
            ->when(! empty($this->filterQuestionTypes), function (Builder $query): void {
                $query->whereIn('question_type', $this->filterQuestionTypes);
            })
            ->where('status', 'active')
            ->when(! empty($this->filterClasses), function (Builder $query): void {
                $query->whereIn('academic_class_id', $this->filterClasses);
            })
            ->when(! empty($this->filterSubjects), function (Builder $query): void {
                $query->whereIn('subject_id', $this->filterSubjects);
            })
            ->when(! empty($this->filterTeachers), function (Builder $query): void {
                $query->whereIn('user_id', $this->filterTeachers);
            })
            ->when(filled($this->filterSearch), function (Builder $query): void {
                $query->where('title', 'like', '%'.$this->filterSearch.'%');
            })
            ->with(['academicClass:id,name', 'subject:id,name', 'chapter:id,name'])
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
