<?php

namespace App\Livewire\Students;

use App\Models\MockTest;
use App\Models\Question;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class MockTestResult extends Component
{
    public MockTest $mockTest;

    public $aiError = null;

    public function mount($testId)
    {
        $this->mockTest = MockTest::where('id', $testId)
            ->where('user_id', auth()->id())
            ->with([
                'testQuestions.question' => fn ($query) => $query
                    ->withCount(['likes', 'bookmarks'])
                    ->withExists([
                        'likes as is_liked' => fn ($likeQuery) => $likeQuery->where('user_id', auth()->id()),
                        'bookmarks as is_bookmarked' => fn ($bookmarkQuery) => $bookmarkQuery->where('user_id', auth()->id()),
                    ]),
                'subject',
            ])
            ->firstOrFail();

        if ($this->mockTest->status !== 'completed') {
            return redirect()->route('student.mock-test.take', ['testId' => $this->mockTest->id]);
        }
    }

    public function generateAiExplanation($questionId): void
    {
        $this->aiError = null;

        // UI তে কোন প্রশ্নে এরর দেখাবে তা ট্র্যাক করার জন্য
        session()->flash('last_question_id', $questionId);

        try {
            $question = Question::findOrFail($questionId);

            // 🌟 আমাদের তৈরি করা মাস্টার সার্ভিস ক্লাস ব্যবহার করা হচ্ছে 🌟
            $geminiService = new GeminiService;
            $geminiService->generateAndSaveExplanation($question);

            // সফল হলে ডাটা রিফ্রেশ এবং ইভেন্ট ডিসপ্যাচ
            $this->refreshQuestionsData();
            $this->dispatch('practice-content-updated');

        } catch (\Exception $e) {
            // সার্ভিস ক্লাস থেকে পাঠানো এরর সরাসরি এখানে সেট হয়ে যাবে
            $this->aiError = 'Error: '.$e->getMessage();
        }
    }

    // --- Dynamic Actions ---

    public function toggleLike(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $toggled = $question->likes()->toggle(auth()->id());

        if (count($toggled['attached']) > 0) {
            $question->increment('likes_count');
        } elseif (count($toggled['detached']) > 0) {
            if ($question->likes_count > 0) {
                $question->decrement('likes_count');
            }
        }
        // ডাটাবেসে আপডেট হওয়ার সাথে সাথেই সকল প্রশ্নের স্টেট রিফ্রেশ করা হলো
        $this->refreshQuestionsData();
    }

    public function toggleBookmark(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $toggled = $question->bookmarks()->toggle(auth()->id());

        if (count($toggled['attached']) > 0) {
            $question->increment('bookmarks_count');
        } elseif (count($toggled['detached']) > 0) {
            if ($question->bookmarks_count > 0) {
                $question->decrement('bookmarks_count');
            }
        }

        // ডাটাবেসে আপডেট হওয়ার সাথে সাথেই সকল প্রশ্নের স্টেট রিফ্রেশ করা হলো
        $this->refreshQuestionsData();
    }

    public function recordView(int $questionId): void
    {
        $viewerId = auth()->check() ? 'user_'.auth()->id() : 'ip_'.request()->ip();
        $cacheKey = "viewed_question_{$questionId}_by_{$viewerId}";

        if (! Cache::has($cacheKey)) {
            Question::where('id', $questionId)->increment('views_count');
            Cache::put($cacheKey, true, now()->addHours(24));
        }
    }

    // Livewire এর Hydration সমস্যা সমাধানের জন্য হেল্পার ফাংশন
    private function refreshQuestionsData(): void
    {
        $this->mockTest->load([
            'testQuestions.question' => fn ($query) => $query
                ->withCount(['likes', 'bookmarks'])
                ->withExists([
                    'likes as is_liked' => fn ($likeQuery) => $likeQuery->where('user_id', auth()->id()),
                    'bookmarks as is_bookmarked' => fn ($bookmarkQuery) => $bookmarkQuery->where('user_id', auth()->id()),
                ]),
        ]);
    }

    public function render()
    {
        $total = $this->mockTest->total_questions;
        $correct = $this->mockTest->correct_answers;
        $wrong = $this->mockTest->wrong_answers;
        $skipped = max(0, $total - ($correct + $wrong));
        $percentage = $total > 0 ? round(($correct / $total) * 100) : 0;

        return view('livewire.students.mock-test-result', [
            'skipped' => $skipped,
            'percentage' => $percentage,
        ])->layout('layouts.app', ['title' => 'Mock Test Result']);
    }
}
