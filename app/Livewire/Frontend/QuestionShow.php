<?php

namespace App\Livewire\Frontend;

use App\Models\Question;
use Livewire\Component;

class QuestionShow extends Component
{
    public $question;

    public function mount($slug)
    {
        $this->question = Question::where('slug', $slug)
            ->with(['subject', 'chapter', 'topic', 'pastExams'])
            ->firstOrFail();
            
        // Increment views
        $this->question->increment('views');
    }

    public function render()
    {
        // Get chapter stats for sidebar
        $chapterStats = [];
        if ($this->question->subject_id) {
            $chapterStats = \App\Models\Chapter::where('subject_id', $this->question->subject_id)
                ->withCount('questions')
                ->get();
        }

        // Get related questions
        $relatedQuestions = Question::where('id', '!=', $this->question->id)
            ->where(function ($query) {
                if ($this->question->topic_id) {
                    $query->where('topic_id', $this->question->topic_id);
                } elseif ($this->question->chapter_id) {
                    $query->where('chapter_id', $this->question->chapter_id);
                } else {
                    $query->where('subject_id', $this->question->subject_id);
                }
            })
            ->limit(5)
            ->get();

        // Get Prev and Next questions
        $prevQuestion = Question::where('id', '<', $this->question->id)
            ->orderBy('id', 'desc')
            ->first();
            
        $nextQuestion = Question::where('id', '>', $this->question->id)
            ->orderBy('id', 'asc')
            ->first();

        return view('livewire.frontend.question-show', [
            'chapterStats' => $chapterStats,
            'relatedQuestions' => $relatedQuestions,
            'prevQuestion' => $prevQuestion,
            'nextQuestion' => $nextQuestion
        ])->layout('layouts.frontend', ['title' => strip_tags($this->question->title)]);
    }
}
