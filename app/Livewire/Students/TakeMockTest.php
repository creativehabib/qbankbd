<?php

namespace App\Livewire\Students;

use App\Models\MockTest;
use Livewire\Component;
use Livewire\Attributes\Layout;

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
            return redirect()->route('students.practice.index');
        }

        // সময় ক্যালকুলেশন (পেজ রিলোড দিলেও যেন সময় ঠিক থাকে)
        $endTime = $this->mockTest->started_at->copy()->addMinutes($this->mockTest->duration_minutes);
        $this->remainingSeconds = now()->diffInSeconds($endTime, false);

        // যদি সময় আগেই শেষ হয়ে গিয়ে থাকে, তবে সাথে সাথে সাবমিট করে দেওয়া
        if ($this->remainingSeconds <= 0) {
            $this->submitExam();
            return;
        }

        // প্রশ্নগুলো লোড করা
        $this->testQuestions = $this->mockTest->testQuestions()->with('question')->get();

        // আগে থেকে কোনো উত্তর দিয়ে থাকলে তা ফর্মে সেট করা (যদি রিলোড দেয়)
        foreach ($this->testQuestions as $tq) {
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

        foreach ($this->testQuestions as $testQuestion) {
            $userAnsIndex = $this->answers[$testQuestion->id] ?? null;
            $isCorrect = false;

            if ($userAnsIndex !== null && $userAnsIndex !== '') {
                // ইউজারের দেওয়া উত্তরের সাথে সঠিক উত্তর মেলানো
                $options = collect($testQuestion->question->extra_content ?? [])->take(4);
                $selectedOption = $options[$userAnsIndex] ?? null;

                if ($selectedOption && !empty($selectedOption['is_correct'])) {
                    $isCorrect = true;
                    $correctCount++;
                } else {
                    $wrongCount++;
                }
            }

            // ইউজারের উত্তর ডাটাবেসে সেভ করা
            $testQuestion->update([
                'user_answer' => $userAnsIndex,
                'is_correct' => $isCorrect,
            ]);
        }

        // মূল মক টেস্ট আপডেট করা
        $this->mockTest->update([
            'correct_answers' => $correctCount,
            'wrong_answers' => $wrongCount,
            'total_score' => $correctCount, // ১টি সঠিক উত্তরে ১ মার্ক ধরা হলো
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // পরীক্ষা শেষে রেজাল্ট পেজে রিডাইরেক্ট (আপাতত প্র্যাকটিস পেজে পাঠানো হচ্ছে, রেজাল্ট পেজ পরে বানাবো)
        return redirect()->route('students.practice.index');
    }

    #[Layout('layouts.guest')] // ডিস্ট্রাকশন-ফ্রি রাখার জন্য guest লেআউট ব্যবহার করা হলো (সাইডবার থাকবে না)
    public function render()
    {
        return view('livewire.students.take-mock-test', [
            'subjectName' => $this->mockTest->subject?->name ?? 'Mixed Subjects',
        ])->title('Mock Test Running');
    }
}
