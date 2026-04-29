<?php

namespace App\Livewire\Teacher;

use App\Models\QuestionSet;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MyQuestionSets extends Component
{
    public function render(): View
    {
        $questionSets = QuestionSet::query()
            ->where('user_id', auth()->id())
            ->withCount('questions')
            ->with(['questions:id,question_type'])
            ->latest()
            ->get();

        return view('livewire.teacher.my-question-sets', [
            'questionSets' => $questionSets,
        ])->layout('layouts.app');
    }
}
