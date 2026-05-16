<?php

namespace App\Services;

use App\Models\Question;
use Exception;
use Illuminate\Support\Facades\Http;

class GeminiService
{
    /**
     * Gemini API থেকে রেসপন্স এনে JSON এ কনভার্ট করবে (MCQ তৈরির জন্য)
     * @throws Exception
     */
    public function generateJson(string $prompt, int $timeout = 120): ?array
    {
        $this->checkApiKey();

        // API কল
        $response = Http::timeout($timeout)->withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->getApiUrl(), [
            'contents' => [['parts' => [['text' => $prompt]]]],
        ]);

        // রেসপন্স সফল হলে
        if ($response->successful()) {
            $resultText = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // Markdown বা ফালতু টেক্সট ট্রিম করে শুধু JSON বের করা
            $resultText = str_replace(['```json', '```'], '', $resultText);
            $cleanJson = trim($resultText);

            return json_decode($cleanJson, true);
        }

        // এরর হ্যান্ডেলিং
        $this->handleErrorResponse($response);
    }

    /**
     * Gemini API থেকে সাধারণ টেক্সট বা ব্যাখ্যা (Explanation) আনবে (মক টেস্টের জন্য)
     *
     * @throws Exception
     */
    public function generateText(string $prompt, int $timeout = 60): string
    {
        $this->checkApiKey();

        $response = Http::withoutVerifying()->timeout($timeout)->withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->getApiUrl(), [
            'contents' => [['parts' => [['text' => $prompt]]]],
        ]);

        if ($response->successful()) {
            return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';
        }

        $this->handleErrorResponse($response);
    }

    /**
     * একটি নির্দিষ্ট প্রশ্নের জন্য AI থেকে ব্যাখ্যা (Explanation) তৈরি এবং সেভ করবে
     */
    public function generateAndSaveExplanation(Question $question): void
    {
        // যদি আগেই ব্যাখ্যা থাকে, তবে আর API কল করার দরকার নেই
        if (filled($question->description)) {
            return;
        }

        $this->checkApiKey();

        // প্রশ্ন ও অপশন প্রসেসিং
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

        // প্রম্পট তৈরি
        $prompt = 'তুমি একজন বিশেষজ্ঞ শিক্ষক। প্রশ্ন: '.$cleanTitle.'. সঠিক উত্তর: '.$correctAnswerText.'. ';
        $prompt .= 'কেন সঠিক তা বাংলায় ৩ লাইনে ব্যাখ্যা করো। ';
        $prompt .= 'গুরুত্বপূর্ণ: কোনো গাণিতিক সমীকরণ বা সংকেত থাকলে তা অবশ্যই LaTeX ফরম্যাটে লিখবে। ';
        $prompt .= 'ইনলাইন সমীকরণের জন্য একটি ডলার সাইন (যেমন: $x^2$) এবং আলাদা লাইনের বড় সমীকরণের জন্য ডাবল ডলার ব্যবহার করো।';

        // API কল
        $response = Http::withoutVerifying()
            ->timeout(60)
            ->post($this->getApiUrl(), [
                'contents' => [['parts' => [['text' => $prompt]]]],
            ]);

        // রেসপন্স হ্যান্ডেলিং
        if ($response->successful()) {
            $result = $response->json();
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $explanation = $result['candidates'][0]['content']['parts'][0]['text'];
                // ডাটাবেজে আপডেট করা
                $question->update(['description' => nl2br(trim($explanation))]);

                return;
            }
        }

        $this->handleErrorResponse($response);
    }

    // ==========================================
    // 🌟 হেল্পার ফাংশন সমূহ (কোড ক্লিন রাখার জন্য) 🌟
    // ==========================================

    /**
     * API URL জেনারেট করবে (মডেল ডাইনামিক এবং ১০০% সেফ করার জন্য)
     */
    private function getApiUrl(): string
    {
        $apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');

        // .env থেকে মডেল রিড করবে, না থাকলে ডিফল্ট হিসেবে ২.৫ লাইট ব্যবহার করবে
        $model = env('GEMINI_MODEL', 'gemini-2.5-flash-lite');

        // 🌟 ১.৫ সিরিজের মডেল হলে একরকম ইউআরএল, ২.৫ সিরিজের হলে আরেক রকম ইউআরএল
        if (str_contains($model, 'gemini-1.5')) {
            return "https://generativelanguage.googleapis.com/v1/models/{$model}:generateContent?key={$apiKey}";
        }

        // ডিফল্ট ২.৫ সিরিজের জন্য আপনার বর্তমান ইউআরএল
        return "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
    }

    /**
     * API Key আছে কিনা চেক করবে
     */
    private function checkApiKey(): void
    {
        $apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');
        if (! $apiKey) {
            throw new Exception('API Key পাওয়া যায়নি। অনুগ্রহ করে .env ফাইল চেক করুন।');
        }
    }

    /**
     * 🌟 বিশাল এরর মেসেজকে সুন্দর বাংলায় কনভার্ট করার ম্যাজিক 🌟
     */
    private function handleErrorResponse($response): void
    {
        $errorBody = $response->json();
        $errorMessage = $errorBody['error']['message'] ?? $response->body();

        // গুগল যদি Quota Exceeded বা 429 স্ট্যাটাস পাঠায়
        if ($response->status() === 429 || str_contains($errorMessage, 'Quota exceeded')) {
            throw new Exception('AI সার্ভারে এখন অনেক চাপ বা লিমিট শেষ হয়েছে। অনুগ্রহ করে ১ মিনিট অপেক্ষা করে আবার চেষ্টা করুন।');
        }

        // অন্যান্য যেকোনো এররের জন্য
        throw new Exception('API Error: '.$errorMessage);
    }
}
