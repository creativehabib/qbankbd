<?php

namespace App\Livewire\Students\ModelTests;

use App\Models\ModelTest;
use App\Models\ModelTestResult;
use App\Models\ModelTestUserAnswer;
use App\Models\Badge;
use Carbon\Carbon;
use Livewire\Component;
use App\Livewire\Traits\InteractsWithFluxToasts;

class ModelTestAttempt extends Component
{
    use InteractsWithFluxToasts;
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

        $answersData = [];
        foreach ($this->questions as $question) {
            $selectedOptionIndex = $this->answers[$question->id] ?? null;
            $isSkipped = ($selectedOptionIndex === null || $selectedOptionIndex === '');
            
            $isCorrect = false;
            if (!$isSkipped) {
                $options = is_string($question->extra_content) ? json_decode($question->extra_content, true) : $question->extra_content;
                if (isset($options[$selectedOptionIndex])) {
                    $isCorrect = (bool) ($options[$selectedOptionIndex]['is_correct'] ?? false);
                }
            }

            $answersData[] = [
                'model_test_result_id' => $result->id,
                'question_id' => $question->id,
                'subject_id' => $question->subject_id,
                'is_correct' => $isCorrect,
                'is_skipped' => $isSkipped,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        ModelTestUserAnswer::insert($answersData);

        // 🌟 Gamification: Add 10 XP per correct answer
        $user = auth()->user();
        
        if ($correctCount > 0) {
            $user->increment('xp', $correctCount * 10);
        }

        // Streak Calculation
        $today = Carbon::today();
        $lastActivity = $user->last_activity_date ? Carbon::parse($user->last_activity_date)->startOfDay() : null;

        if (!$lastActivity || $lastActivity->diffInDays($today) > 1) {
            // First time or streak broken (more than 1 day gap)
            $user->current_streak = 1;
        } elseif ($lastActivity->diffInDays($today) == 1) {
            // Consecutive day
            $user->current_streak += 1;
        }
        // If diff == 0, it means they already took a test today, so streak remains same

        if ($user->current_streak > $user->longest_streak) {
            $user->longest_streak = $user->current_streak;
        }
        $user->last_activity_date = $today->toDateString();
        $user->save();

        // Badge Unlocking Engine
        $unlockedBadges = $user->badges()->pluck('badges.id')->toArray();
        $newBadgesUnlocked = [];

        $allBadges = Badge::whereNotIn('id', $unlockedBadges)->get();
        
        foreach ($allBadges as $badge) {
            $earned = false;
            if ($badge->requirement_type === 'xp' && $user->xp >= $badge->requirement_value) {
                $earned = true;
            } elseif ($badge->requirement_type === 'streak' && $user->current_streak >= $badge->requirement_value) {
                $earned = true;
            } elseif ($badge->requirement_type === 'subject_mastery') {
                // Check if they got perfect score in this subject today
                $subjectCorrect = collect($answersData)
                    ->where('subject_id', $badge->subject_id)
                    ->where('is_correct', true)->count();
                $subjectTotal = collect($answersData)
                    ->where('subject_id', $badge->subject_id)->count();

                if ($subjectTotal > 0 && ($subjectCorrect / $subjectTotal) * 100 >= $badge->requirement_value) {
                    $earned = true;
                }
            }

            if ($earned) {
                $user->badges()->attach($badge->id);
                $newBadgesUnlocked[] = $badge->name;
            }
        }

        if (count($newBadgesUnlocked) > 0) {
            $this->toastSuccess('🏆 New Badge Unlocked: ' . implode(', ', $newBadgesUnlocked));
        } else {
            $this->toastSuccess('পরীক্ষা সফলভাবে সম্পন্ন হয়েছে!');
        }

        $this->redirectRoute('student.model-tests.result', $result->id, navigate: true);
    }

    public function render()
    {
        return view('livewire.students.model-tests.model-test-attempt')
            ->layout('layouts.app', ['title' => 'Taking Exam: ' . $this->modelTest->title]);
    }
}
