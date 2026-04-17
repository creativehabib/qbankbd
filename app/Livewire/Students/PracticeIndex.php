<?php

namespace App\Livewire\Students;

use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;

class PracticeIndex extends Component
{
    public string $level = 'classes';

    public ?int $selectedClassId = null;

    public ?int $selectedSubjectId = null;

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
            $this->level = 'subjects';
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
            $this->level = 'chapters';
        }
    }

    public function back(): void
    {
        if ($this->level === 'chapters') {
            $this->selectedSubjectId = null;
            $this->level = 'subjects';

            return;
        }

        if ($this->level === 'subjects') {
            $this->selectedClassId = null;
            $this->selectedSubjectId = null;
            $this->level = 'classes';
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

    public function render(): View
    {
        $selectedClassName = AcademicClass::query()->whereKey($this->selectedClassId)->value('name');
        $selectedSubjectName = Subject::query()->whereKey($this->selectedSubjectId)->value('name');

        return view('livewire.students.practice-index', [
            'classes' => $this->classes(),
            'subjects' => $this->subjects(),
            'chapters' => $this->chapters(),
            'selectedClassName' => $selectedClassName,
            'selectedSubjectName' => $selectedSubjectName,
        ])->layout('layouts.app', ['title' => 'Practice']);
    }
}
