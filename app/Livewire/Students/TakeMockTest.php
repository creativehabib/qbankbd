<?php

namespace App\Livewire\Students;

use App\Models\MockTest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TakeMockTest extends Component
{
    public MockTest $mockTest;

    public $testQuestions;

    // ইউজারের সিলেক্ট করা উত্তরগুলো এখানে জমা হবে (Key হবে question_id, Value হবে অপশনের ইনডেক্স)
    public array $answers = [];

    // আর কত সেকেন্ড বাকি আছে
    public int $remainingSeconds = 0;

    public function mount(int $testId): ?RedirectResponse
    {
        // মক টেস্টটি খুঁজে বের করা এবং ভেরিফাই করা যে এটি এই স্টুডেন্টেরই কিনা
        $this->mockTest = MockTest::query()
            ->with('subject:id,name')
            ->where('id', $testId)
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
            return $this->submitExam();
        }

        // প্রশ্নগুলো লোড করা
        $this->testQuestions = $this->testQuestions();

        // আগে থেকে কোনো উত্তর দিয়ে থাকলে তা ফর্মে সেট করা (যদি রিলোড দেয়)
        // null এরর এড়াতে এখানে ?? [] ব্যবহার করা হয়েছে
        foreach ($this->testQuestions ?? [] as $tq) {
            if ($tq->user_answer !== null) {
                $this->answers[$tq->id] = $tq->user_answer;
            }
        }

        return null;
    }

    /**
     * Persist the answers only once, when the student submits the test.
     *
     * @param  array<int|string, int|string>  $answers
     */
    public function submitExam(array $answers = []): RedirectResponse
    {
        $submittedAnswers = $answers === [] ? $this->answers : $answers;

        DB::transaction(function () use ($submittedAnswers): void {
            $mockTest = MockTest::query()
                ->whereKey($this->mockTest->id)
                ->where('user_id', auth()->id())
                ->lockForUpdate()
                ->firstOrFail();

            if ($mockTest->status === 'completed') {
                return;
            }

            $correctCount = 0;
            $wrongCount = 0;
            $testQuestions = $mockTest->testQuestions()->with('question')->get();

            foreach ($testQuestions as $testQuestion) {
                $userAnswerIndex = $submittedAnswers[$testQuestion->id] ?? null;
                $isCorrect = false;

                if ($userAnswerIndex !== null && $userAnswerIndex !== '') {
                    $options = collect($testQuestion->question->extra_content ?? [])->take(4);
                    $selectedOption = $options[(int) $userAnswerIndex] ?? null;
                    $isCorrect = (bool) ($selectedOption['is_correct'] ?? false);

                    if ($isCorrect) {
                        $correctCount++;
                    } else {
                        $wrongCount++;
                    }
                }

                $testQuestion->update([
                    'user_answer' => $userAnswerIndex,
                    'is_correct' => $isCorrect,
                ]);
            }

            $mockTest->update([
                'correct_answers' => $correctCount,
                'wrong_answers' => $wrongCount,
                'total_score' => $correctCount,
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            if ($correctCount > 0) {
                $mockTest->user()->increment('xp', $correctCount * 10);
            }
        });

        return redirect()->route('student.mock-test.result', ['testId' => $this->mockTest->id]);
    }

    public function render(): View
    {
        return view('livewire.students.take-mock-test', [
            'subjectName' => $this->mockTest->subject?->name ?? 'Mixed Subjects',
        ])
            ->layout('layouts.app')
            ->title('Mock Test Running');
    }
}
