<?php

namespace App\Livewire\Students;

use App\Models\MockTest;
use App\Models\Question;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MockTestResult extends Component
{
    public MockTest $mockTest;

    public $aiError = null;

    public function mount($testId)
    {
        $this->mockTest = MockTest::where('id', $testId)
            ->where('user_id', auth()->id())
            ->with(['testQuestions.question', 'subject'])
            ->firstOrFail();

        if ($this->mockTest->status !== 'completed') {
            return redirect()->route('student.mock-test.take', ['testId' => $this->mockTest->id]);
        }
    }

    public function generateAiExplanation($questionId): void
    {
        $this->aiError = null;
        $question = Question::findOrFail($questionId);

        if (filled($question->description)) {
            return;
        }

        // নতুন ফ্রি এপিআই কী-টি এখানে দিন (অথবা .env থেকে নিন)
        $apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');

        if (! $apiKey) {
            $this->aiError = 'ফ্রি এপিআই কী পাওয়া যায়নি।';

            return;
        }

        // ডাটা প্রসেসিং
        $optionsText = '';
        $correctAnswerText = '';
        $options = collect($question->extra_content ?? [])->take(4);
        $labels = ['ক', 'খ', 'গ', 'ঘ'];

        foreach ($options as $index => $opt) {
            $cleanText = strip_tags(html_entity_decode($opt['option_text'] ?? ''));
            $optionsText .= $labels[$index].') '.$cleanText."\n";
            if (! empty($opt['is_correct'])) {
                $correctAnswerText = $cleanText;
            }
        }

        $cleanTitle = strip_tags(html_entity_decode($question->title ?? ''));
        $prompt = "প্রশ্ন: {$cleanTitle}. সঠিক উত্তর: {$correctAnswerText}. কেন এটি সঠিক তা বাংলায় ৩ লাইনে ব্যাখ্যা করো।";

        try {
            // gemini-2.5-flash-lite মডেলটি ফ্রি ইউজারদের জন্য বেস্ট
            $response = Http::withoutVerifying()->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [['text' => $prompt]],
                    ],
                ],
            ]);

            if ($response->successful()) {
                $result = $response->json();
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $explanation = $result['candidates'][0]['content']['parts'][0]['text'];
                    $question->update(['description' => nl2br(trim($explanation))]);
                    $this->mockTest->load('testQuestions.question');
                    $this->dispatch('practice-content-updated');
                }
            } else {
                $errorBody = $response->json();
                $this->aiError = 'API Error: '.($errorBody['error']['message'] ?? 'ক্রেডিট শেষ বা কি সমস্যা।');
            }
        } catch (\Exception $e) {
            $this->aiError = 'Error: '.$e->getMessage();
        }
    }

    // --- Dynamic Actions (Scalable Approach) ---

    public function toggleLike(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $toggled = $question->likes()->toggle(auth()->id());

        if (count($toggled['attached']) > 0) {
            $question->increment('likes_count');
        } elseif (count($toggled['detached']) > 0) {
            $question->decrement('likes_count');
        }
    }

    public function toggleBookmark(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $toggled = $question->bookmarks()->toggle(auth()->id());

        if (count($toggled['attached']) > 0) {
            $question->increment('bookmarks_count');
        } elseif (count($toggled['detached']) > 0) {
            $question->decrement('bookmarks_count');
        }
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
