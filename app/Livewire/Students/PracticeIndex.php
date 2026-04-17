<?php

namespace App\Livewire\Students;

use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class PracticeIndex extends Component
{
    public function render(): View
    {
        $subjects = Subject::query()
            ->where('is_active', true)
            ->withCount([
                'questions as mcq_questions_count' => function (Builder $query): void {
                    $query->where('question_type', 'mcq');
                },
            ])
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return view('livewire.students.practice-index', [
            'subjects' => $subjects,
        ])->layout('layouts.app', ['title' => 'Practice']);
    }
}
