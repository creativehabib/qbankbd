<?php

namespace App\Livewire\Students;

use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Subject;
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

    public ?int $selectedClassId = null;

    public ?int $selectedSubjectId = null;

    public ?int $selectedChapterId = null;

    public function mount(): void
    {
        abort_unless(auth()->user()?->isStudent(), 403);
    }

    public function openClass(int $classId): void
    {
        $isValidClass = AcademicClass::query()
            ->whereKey($classId)
            ->where('is_active', true)
            ->exists();

        if ($isValidClass) {
            $this->selectedClassId = $classId;
            $this->selectedSubjectId = null;
            $this->selectedChapterId = null;
            $this->level = 'subjects';
            $this->resetPage();
            $this->dispatch('practice-content-updated');
        }
    }

    public function openSubject(int $subjectId): void
    {
        $isValidSubject = Subject::query()
            ->whereKey($subjectId)
            ->where('academic_class_id', $this->selectedClassId)
            ->where('is_active', true)
            ->exists();

        if ($isValidSubject) {
            $this->selectedSubjectId = $subjectId;
            $this->selectedChapterId = null;
            $this->level = 'chapters';
            $this->resetPage();
            $this->dispatch('practice-content-updated');
        }
    }

    public function openChapter(int $chapterId): void
    {
        $isValidChapter = Chapter::query()
            ->whereKey($chapterId)
            ->where('subject_id', $this->selectedSubjectId)
            ->where('is_active', true)
            ->exists();

        if ($isValidChapter) {
            $this->selectedChapterId = $chapterId;
            $this->level = 'questions';
            $this->resetPage();
            $this->dispatch('practice-content-updated');
        }
    }

    public function back(): void
    {
        if ($this->level === 'questions') {
            $this->selectedChapterId = null;
            $this->level = 'chapters';
            $this->resetPage();
            $this->dispatch('practice-content-updated');

            return;
        }

        if ($this->level === 'chapters') {
            $this->selectedSubjectId = null;
            $this->selectedChapterId = null;
            $this->level = 'subjects';
            $this->resetPage();
            $this->dispatch('practice-content-updated');

            return;
        }

        if ($this->level === 'subjects') {
            $this->selectedClassId = null;
            $this->selectedSubjectId = null;
            $this->selectedChapterId = null;
            $this->level = 'classes';
            $this->resetPage();
            $this->dispatch('practice-content-updated');
        }
    }

    /**
     * @return Collection<int, AcademicClass>
     */
    protected function classes(): Collection
    {
        return AcademicClass::query()
            ->where('is_active', true)
            ->withCount([
                'questions as mcq_questions_count' => function (Builder $query): void {
                    $query->where('question_type', 'mcq');
                },
            ])
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    /**
     * @return Collection<int, Subject>
     */
    protected function subjects(): Collection
    {
        if ($this->selectedClassId === null) {
            return collect();
        }

        return Subject::query()
            ->where('academic_class_id', $this->selectedClassId)
            ->where('is_active', true)
            ->withCount([
                'questions as mcq_questions_count' => function (Builder $query): void {
                    $query->where('question_type', 'mcq');
                },
            ])
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);
    }

    /**
     * @return Collection<int, Chapter>
     */
    protected function chapters(): Collection
    {
        if ($this->selectedSubjectId === null) {
            return collect();
        }

        return Chapter::query()
            ->where('subject_id', $this->selectedSubjectId)
            ->where('is_active', true)
            ->withCount([
                'questions as mcq_questions_count' => function (Builder $query): void {
                    $query->where('question_type', 'mcq');
                },
            ])
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);
    }

    /**
     * @return LengthAwarePaginator<int, Question>
     */
    protected function latestQuestions(): LengthAwarePaginator
    {
        if ($this->selectedChapterId === null) {
            return new LengthAwarePaginator([], 0, 20, 1);
        }

        return Question::query()
            ->where('question_type', 'mcq')
            ->where('status', 'active')
            ->where('chapter_id', $this->selectedChapterId)
            ->with(['academicClass:id,name', 'subject:id,name', 'chapter:id,name', 'examCategories:id,name'])
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
            'selectedClassName' => $selectedClassName,
            'selectedSubjectName' => $selectedSubjectName,
            'selectedChapterName' => $selectedChapterName,
        ])->layout('layouts.app', ['title' => 'Practice']);
    }
}
