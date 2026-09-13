<?php

namespace App\Services;

use App\Models\Question;
use App\Support\SettingsStore;
use Exception;
use Illuminate\Support\Facades\Http;

class AiService
{
    private string $provider;
    private string $openAiKey;
    private string $openAiModel;
    private string $geminiKey;
    private string $geminiModel;
    private bool $geminiFallbackEnabled;
    private string $geminiFallbackModel;

    public function __construct()
    {
        $settings = SettingsStore::group('ai');
        
        $this->provider = $settings['ai_provider'] ?? 'gemini';
        $this->openAiKey = $settings['openai_api_key'] ?? env('OPENAI_API_KEY', '');
        $this->openAiModel = $settings['openai_model'] ?? 'gpt-3.5-turbo';
        
        $this->geminiKey = $settings['gemini_api_key'] ?? env('GEMINI_API_KEY', '');
        $this->geminiModel = $settings['gemini_model'] ?? 'gemini-1.5-flash';
        $this->geminiFallbackEnabled = (bool) ($settings['enable_gemini_fallback'] ?? false);
        $this->geminiFallbackModel = $settings['gemini_fallback_model'] ?? 'gemini-1.5-flash';
    }

    /**
     * AI API থেকে রেসপন্স এনে JSON এ কনভার্ট করবে (MCQ তৈরির জন্য)
     * @throws Exception
     */
    public function generateJson(string $prompt, int $timeout = 120): ?array
    {
        if ($this->provider === 'openai') {
            return $this->generateJsonOpenAi($prompt, $timeout);
        }

        return $this->generateJsonGemini($prompt, $timeout);
    }

    /**
     * AI API থেকে সাধারণ টেক্সট বা ব্যাখ্যা (Explanation) আনবে (মক টেস্টের জন্য)
     * @throws Exception
     */
    public function generateText(string $prompt, int $timeout = 60): string
    {
        if ($this->provider === 'openai') {
            return $this->generateTextOpenAi($prompt, $timeout);
        }

        return $this->generateTextGemini($prompt, $timeout);
    }

    /**
     * Parse natural language search intent using AI
     */
    public function parseSearchIntent(string $searchQuery): ?array
    {
        $prompt = <<<EOT
তুমি একজন স্মার্ট ডাটাবেজ এসিস্ট্যান্ট। ইউজার একটি স্বাভাবিক বাক্যে প্রশ্ন খুজতে চাইছে। 
তোমাকে ইউজারের বাক্য থেকে কি-ওয়ার্ড বের করে শুধুমাত্র JSON ফরম্যাটে উত্তর দিতে হবে। অন্য কোনো টেক্সট বা মার্কডাউন ব্লক (```json) দিবে না।
ইউজারের বাক্য: "{$searchQuery}"

নিচের JSON ফরম্যাট হুবহু অনুসরণ করবে:
{
  "class_name": "ইউজার যদি বিসিএস, এনটিআরসিএ, ৯ম শ্রেণি ইত্যাদি উল্লেখ করে (না থাকলে null)",
  "subject_name": "ইউজার যদি বাংলা, ইংরেজি, গণিত, বিজ্ঞান ইত্যাদি উল্লেখ করে (না থাকলে null)",
  "limit": ইউজারের চাওয়া প্রশ্নের সংখ্যা (না থাকলে 10 দিবে, integer),
  "difficulty": "hard, medium, বা easy (না থাকলে null)",
  "tags": ["ইউজার যদি নির্দিষ্ট কোনো টপিক বা অধ্যায়ের নাম বলে, যেমন 'সমাস', 'সূচক' ইত্যাদি। না থাকলে ফাকা এরে []"]
}
EOT;

        return $this->generateJson($prompt, 30);
    }

    /**
     * একটি নির্দিষ্ট প্রশ্নের জন্য AI থেকে ব্যাখ্যা (Explanation) তৈরি এবং সেভ করবে
     */
    public function generateAndSaveExplanation(Question $question): void
    {
        if (filled($question->description)) {
            return;
        }

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

        $prompt = 'তুমি একজন বিশেষজ্ঞ শিক্ষক। প্রশ্ন: '.$cleanTitle.'. সঠিক উত্তর: '.$correctAnswerText.'. ';
        $prompt .= 'কেন সঠিক তা বাংলায় ৩ লাইনে ব্যাখ্যা করো। ';
        $prompt .= 'গুরুত্বপূর্ণ: কোনো গাণিতিক সমীকরণ বা সংকেত থাকলে তা অবশ্যই LaTeX ফরম্যাটে লিখবে। ';
        $prompt .= 'ইনলাইন সমীকরণের জন্য একটি ডলার সাইন (যেমন: $x^2$) এবং আলাদা লাইনের বড় সমীকরণের জন্য ডাবল ডলার ব্যবহার করো।';

        try {
            $explanation = $this->generateText($prompt, 60);
            if ($explanation) {
                $question->update(['description' => nl2br(trim($explanation))]);
            }
        } catch (\Exception $e) {
            // Log or ignore silently to not break loops
            report($e);
        }
    }

    // ==========================================
    // 🌟 OpenAI Implementation 🌟
    // ==========================================

    private function generateJsonOpenAi(string $prompt, int $timeout): ?array
    {
        if (empty($this->openAiKey)) {
            throw new Exception('OpenAI API Key পাওয়া যায়নি। সেটিংসে গিয়ে সেট করুন।');
        }

        $response = Http::timeout($timeout)->withToken($this->openAiKey)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->openAiModel,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ]
            ]);

        if ($response->successful()) {
            $cleanJson = $response->json('choices.0.message.content') ?? '';
            // Remove markdown code blocks if any
            $cleanJson = str_replace(['```json', '```'], '', $cleanJson);
            return json_decode(trim($cleanJson), true);
        }

        $this->handleOpenAiError($response);
    }

    private function generateTextOpenAi(string $prompt, int $timeout): string
    {
        if (empty($this->openAiKey)) {
            throw new Exception('OpenAI API Key পাওয়া যায়নি। সেটিংসে গিয়ে সেট করুন।');
        }

        $response = Http::timeout($timeout)->withToken($this->openAiKey)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->openAiModel,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ]
            ]);

        if ($response->successful()) {
            return $response->json('choices.0.message.content') ?? '';
        }

        $this->handleOpenAiError($response);
    }

    private function handleOpenAiError($response): void
    {
        $error = $response->json('error.message') ?? $response->body();
        if ($response->status() === 429) {
            throw new Exception('OpenAI সার্ভারে লিমিট শেষ হয়েছে (Rate Limit)। একটু পরে আবার চেষ্টা করুন।');
        }
        throw new Exception('OpenAI API Error: ' . $error);
    }

    // ==========================================
    // 🌟 Gemini Implementation 🌟
    // ==========================================

    private function generateJsonGemini(string $prompt, int $timeout): ?array
    {
        if (empty($this->geminiKey)) {
            throw new Exception('Gemini API Key পাওয়া যায়নি। সেটিংসে গিয়ে সেট করুন।');
        }

        $modelsToTry = [$this->geminiModel];
        if ($this->geminiFallbackEnabled) {
            $modelsToTry[] = $this->geminiFallbackModel;
            // Add extra built-in fallbacks just in case both user-selected models fail!
            $modelsToTry = array_unique(array_merge($modelsToTry, [
                'gemini-2.5-flash-lite',
                'gemini-2.5-flash',
                'gemini-3.5-flash',
                'gemini-1.5-flash'
            ]));
        }

        $lastResponse = null;

        foreach ($modelsToTry as $model) {
            $response = $this->callGeminiApi($prompt, $model, $timeout);
            $lastResponse = $response;

            if ($response->successful()) {
                $resultText = $response->json('candidates.0.content.parts.0.text') ?? '';
                $resultText = str_replace(['```json', '```'], '', $resultText);
                return json_decode(trim($resultText), true);
            }

            // Only fallback if the error is rate limit or quota exceeded
            if ($response->status() !== 429) {
                break; // If it's a real API error (like invalid key), don't fallback, just break and throw
            }
        }

        $this->handleGeminiError($lastResponse);
    }

    private function generateTextGemini(string $prompt, int $timeout): string
    {
        if (empty($this->geminiKey)) {
            throw new Exception('Gemini API Key পাওয়া যায়নি। সেটিংসে গিয়ে সেট করুন।');
        }

        $modelsToTry = [$this->geminiModel];
        if ($this->geminiFallbackEnabled) {
            $modelsToTry[] = $this->geminiFallbackModel;
            $modelsToTry = array_unique(array_merge($modelsToTry, [
                'gemini-2.5-flash-lite',
                'gemini-2.5-flash',
                'gemini-3.5-flash',
                'gemini-1.5-flash'
            ]));
        }

        $lastResponse = null;

        foreach ($modelsToTry as $model) {
            $response = $this->callGeminiApi($prompt, $model, $timeout);
            $lastResponse = $response;

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text') ?? '';
            }

            if ($response->status() !== 429) {
                break;
            }
        }

        $this->handleGeminiError($lastResponse);
    }

    private function callGeminiApi(string $prompt, string $model, int $timeout)
    {
        $version = str_contains($model, 'gemini-1.5') ? 'v1' : 'v1beta';
        
        $url = "https://generativelanguage.googleapis.com/{$version}/models/{$model}:generateContent?key={$this->geminiKey}";

        return Http::withoutVerifying()->timeout($timeout)->withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, [
            'contents' => [['parts' => [['text' => $prompt]]]],
        ]);
    }

    private function handleGeminiError($response): void
    {
        $errorBody = $response->json();
        $errorMessage = $errorBody['error']['message'] ?? $response->body();

        if ($response->status() === 429 || str_contains($errorMessage, 'Quota exceeded')) {
            throw new Exception('AI সার্ভারে এখন অনেক চাপ বা লিমিট শেষ হয়েছে। অনুগ্রহ করে ১ মিনিট অপেক্ষা করে আবার চেষ্টা করুন।');
        }

        throw new Exception('Gemini API Error: '.$errorMessage);
    }
}
