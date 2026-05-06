<?php

namespace App\Livewire\Students;

use App\Models\MockTest;
use Livewire\Component;

class TakeMockTest extends Component
{
    public MockTest $mockTest;

    public $testQuestions;

    // ইউজারের সিলেক্ট করা উত্তরগুলো এখানে জমা হবে (Key হবে question_id, Value হবে অপশনের ইনডেক্স)
    public array $answers = [];

    // আর কত সেকেন্ড বাকি আছে
    public int $remainingSeconds = 0;

    public function mount($testId)
    {
        // মক টেস্টটি খুঁজে বের করা এবং ভেরিফাই করা যে এটি এই স্টুডেন্টেরই কিনা
        $this->mockTest = MockTest::where('id', $testId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // পরীক্ষা যদি ইতোমধ্যে শেষ হয়ে থাকে, তবে প্র্যাকটিস পেজে পাঠিয়ে দেওয়া
        if ($this->mockTest->status === 'completed') {
            return redirect()->route('student.practice.index');
        }

        // সময় ক্যালকুলেশন (পেজ রিলোড দিলেও যেন সময় ঠিক থাকে)
        $endTime = $this->mockTest->started_at->copy()->addMinutes((int) $this->mockTest->duration_minutes);
        $this->remainingSeconds = now()->diffInSeconds($endTime, false);

        // যদি সময় আগেই শেষ হয়ে গিয়ে থাকে, তবে সাথে সাথে সাবমিট করে দেওয়া
        if ($this->remainingSeconds <= 0) {
            $this->submitExam();
            return;
        }

        // প্রশ্নগুলো লোড করা
        $this->testQuestions = $this->mockTest->testQuestions()->with('question')->get();

        // আগে থেকে কোনো উত্তর দিয়ে থাকলে তা ফর্মে সেট করা (যদি রিলোড দেয়)
        // null এরর এড়াতে এখানে ?? [] ব্যবহার করা হয়েছে
        foreach ($this->testQuestions ?? [] as $tq) {
            if ($tq->user_answer !== null) {
                $this->answers[$tq->id] = $tq->user_answer;
            }
        }
    }

    public function submitExam()
    {
        // পরীক্ষা শেষ হওয়ার লজিক
        $correctCount = 0;
        $wrongCount = 0;

        // লাইভওয়্যার যেন null না দেয়, তাই সাবমিটের সময় প্রশ্নগুলো আবার লোড করে নেওয়া হলো
        $questions = $this->mockTest->testQuestions()->with('question')->get();

        foreach ($questions as $testQuestion) {
            $userAnsIndex = $this->answers[$testQuestion->id] ?? null;
            $isCorrect = false;

            if ($userAnsIndex !== null && $userAnsIndex !== '') {
                $options = collect($testQuestion->question->extra_content ?? [])->take(4);
                $selectedOption = $options[$userAnsIndex] ?? null;

                if ($selectedOption && ! empty($selectedOption['is_correct'])) {
                    $isCorrect = true;
                    $correctCount++;
                } else {
                    $wrongCount++;
                }
            }

            $testQuestion->update([
                'user_answer' => $userAnsIndex,
                'is_correct' => $isCorrect,
            ]);
        }

        // ১. মূল মক টেস্ট আপডেট করা
        $this->mockTest->update([
            'correct_answers' => $correctCount,
            'wrong_answers' => $wrongCount,
            'total_score' => $correctCount,
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // ==================================================
        // ২. এখানে XP যোগ করার লজিক (নতুন যুক্ত করা হয়েছে)
        // ==================================================
        $earnedXp = ($correctCount * 10); // প্রতিটি সঠিক উত্তরের জন্য ১০ XP

        if ($earnedXp > 0) {
            $user = auth()->user();
            $user->increment('xp', $earnedXp);
        }
        // ==================================================

        // ৩. পরীক্ষা শেষে রেজাল্ট পেজে রিডাইরেক্ট
        return redirect()->route('student.mock-test.result', ['testId' => $this->mockTest->id]);
    }

    public function render()
    {
        return view('livewire.students.take-mock-test', [
            'subjectName' => $this->mockTest->subject?->name ?? 'Mixed Subjects',
        ])
            ->layout('layouts.app')
            ->title('Mock Test Running');
    }
}
