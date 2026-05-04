<?php

namespace App\Livewire\Students;

use App\Models\MockTest;
use App\Models\Question;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MockTestResult extends Component
{
    public MockTest $mockTest;

    public $aiError = null; // এরর দেখানোর জন্য নতুন ভেরিয়েবল

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

    // AI Explanation Generate Method
    public function generateAiExplanation($questionId)
    {
        $this->aiError = null; // আগের কোনো এরর থাকলে মুছে ফেলা
        $question = Question::findOrFail($questionId);

        if (filled($question->description)) {
            return;
        }

        $apiKey = env('GEMINI_API_KEY');

        if (! $apiKey) {
            $this->aiError = 'Gemini API Key পাওয়া যায়নি! আপনার .env ফাইল চেক করুন।';

            return;
        }

        $optionsText = '';
        $correctAnswerText = '';
        $options = collect($question->extra_content ?? [])->take(4);

        $labels = ['ক', 'খ', 'গ', 'ঘ', 'ঙ'];
        foreach ($options as $index => $opt) {
            $cleanText = strip_tags(html_entity_decode($opt['option_text'] ?? ''));
            $optionsText .= $labels[$index].') '.$cleanText."\n";
            if (! empty($opt['is_correct'])) {
                $correctAnswerText = $cleanText;
            }
        }

        $cleanTitle = strip_tags(html_entity_decode($question->title ?? ''));

        $prompt = "তুমি একজন অভিজ্ঞ এবং বন্ধুসুলভ শিক্ষক। নিচের বহুনির্বাচনী প্রশ্নটি দেখো:\n\n";
        $prompt .= "প্রশ্ন: {$cleanTitle}\n";
        $prompt .= "অপশনসমূহ:\n{$optionsText}\n";
        $prompt .= "সঠিক উত্তর: {$correctAnswerText}\n\n";
        $prompt .= 'শিক্ষার্থীর জন্য বাংলায় খুব সহজ ও সুন্দর করে ৩-৪ লাইনের মধ্যে বুঝিয়ে দাও যে কেন এই উত্তরটি সঠিক এবং অন্যগুলো কেন ভুল বা প্রাসঙ্গিক নয়। উত্তরে কোনো HTML ট্যাগ ব্যবহার করবে না, শুধু সাধারণ প্যারাগ্রাফ আকারে লিখবে।';

        try {
            // সবচেয়ে স্টেবল মডেল 'gemini-pro' ব্যবহার করা হলো
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$apiKey}", [
                'contents' => [
                    ['parts' => [['text' => $prompt]]],
                ],
            ]);

            if ($response->successful()) {
                $explanation = $response->json('candidates.0.content.parts.0.text');

                if ($explanation) {
                    $question->update(['description' => nl2br($explanation)]);
                    $this->mockTest->load('testQuestions.question');
                } else {
                    $this->aiError = 'AI কোনো উত্তর দিতে পারেনি।';
                }
            } else {
                $this->aiError = 'API Error: '.$response->body();
            }
        } catch (\Exception $e) {
            $this->aiError = 'Connection Error: '.$e->getMessage();
        }
    }

    public function render()
    {
        $total = $this->mockTest->total_questions;
        $correct = $this->mockTest->correct_answers;
        $wrong = $this->mockTest->wrong_answers;
        $skipped = $total - ($correct + $wrong);

        $percentage = $total > 0 ? round(($correct / $total) * 100) : 0;

        return view('livewire.students.mock-test-result', [
            'skipped' => $skipped,
            'percentage' => $percentage,
        ])->layout('layouts.app', ['title' => 'Mock Test Result']);
    }
}
