<?php

namespace App\Livewire\Students\ModelTests;

use App\Models\ModelTest;
use App\Models\ModelTestResult;
use Livewire\Component;

class ModelTestAttempt extends Component
{
    public ModelTest $modelTest;
    public $questions;
    public array $answers = [];
    public int $timeRemaining;
    
    public function mount(ModelTest $modelTest)
    {
        if (! $modelTest->is_published) {
            abort(404);
        }

        $this->modelTest = $modelTest->load('questions');
        $this->questions = $this->modelTest->questions;
        $this->timeRemaining = $this->modelTest->duration_minutes * 60;
    }

    public function submit()
    {
        $correctCount = 0;
        $wrongCount = 0;
        $unansweredCount = 0;

        foreach ($this->questions as $question) {
            $selectedOptionIndex = $this->answers[$question->id] ?? null;

            if ($selectedOptionIndex === null || $selectedOptionIndex === '') {
                $unansweredCount++;
                continue;
            }

            // Find the correct option index
            // Assuming extra_content stores options like [['option_text' => '...', 'is_correct' => true]]
            $options = is_string($question->extra_content) ? json_decode($question->extra_content, true) : $question->extra_content;
            
            $isCorrect = false;
            if (isset($options[$selectedOptionIndex])) {
                $isCorrect = (bool) ($options[$selectedOptionIndex]['is_correct'] ?? false);
            }

            if ($isCorrect) {
                $correctCount++;
            } else {
                $wrongCount++;
            }
        }

        $negativeMark = $wrongCount * $this->modelTest->negative_mark_weight;
        $totalScore = $correctCount - $negativeMark;

        $timeTaken = ($this->modelTest->duration_minutes * 60) - $this->timeRemaining;
        if ($timeTaken < 0) $timeTaken = 0;

        $result = ModelTestResult::create([
            'model_test_id' => $this->modelTest->id,
            'user_id' => auth()->id(),
            'correct_count' => $correctCount,
            'wrong_count' => $wrongCount,
            'unanswered_count' => $unansweredCount,
            'total_score' => $totalScore > 0 ? $totalScore : 0,
            'time_taken_seconds' => $timeTaken,
        ]);

        // 🌟 Gamification: Add 10 XP per correct answer
        if ($correctCount > 0) {
            auth()->user()->increment('xp', $correctCount * 10);
        }

        session()->flash('success', 'পরীক্ষা সফলভাবে সম্পন্ন হয়েছে!');
        $this->redirectRoute('student.model-tests.result', $result->id, navigate: true);
    }

    public function render()
    {
        return view('livewire.students.model-tests.model-test-attempt')
            ->layout('layouts.app', ['title' => 'Taking Exam: ' . $this->modelTest->title]);
    }
}
