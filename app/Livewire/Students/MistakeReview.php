<?php

namespace App\Livewire\Students;

use App\Models\MockTestQuestion;
use App\Models\Question;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class MistakeReview extends Component
{
    use WithPagination;

    public ?string $aiError = null;

    public function mount()
    {
        abort_unless(auth()->user()?->isStudent(), 403);
    }

    public function generateAiExplanation($questionId): void
    {
        $this->aiError = null;
        $question = Question::findOrFail($questionId);

        if (filled($question->description)) {
            return;
        }

        session()->flash('last_question_id', $questionId);
        $apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');

        if (! $apiKey) {
            $this->aiError = 'ফ্রি এপিআই কী পাওয়া যায়নি।';
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
        $prompt = 'তুমি একজন বিশেষজ্ঞ শিক্ষক। প্রশ্ন: ' . $cleanTitle . '. সঠিক উত্তর: ' . $correctAnswerText . '. ';
        $prompt .= 'কেন সঠিক তা বাংলায় ৩ লাইনে ব্যাখ্যা করো। ';
        $prompt .= 'গুরুত্বপূর্ণ: কোনো গাণিতিক সমীকরণ বা সংকেত থাকলে তা অবশ্যই LaTeX ফরম্যাটে লিখবে। ';
        $prompt .= 'ইনলাইন সমীকরণের জন্য একটি ডলার সাইন (যেমন: $x^2$) এবং আলাদা লাইনের বড় সমীকরণের জন্য ডাবল ডলার ব্যবহার করো।';

        try {
            $response = Http::withoutVerifying()->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key={$apiKey}", [
                'contents' => [['parts' => [['text' => $prompt]]]],
            ]);

            if ($response->successful()) {
                $result = $response->json();
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $explanation = $result['candidates'][0]['content']['parts'][0]['text'];
                    $question->update(['description' => nl2br(trim($explanation))]);

                    // MathJax রেন্ডার করার জন্য ইভেন্ট ডিসপ্যাচ
                    $this->dispatch('practice-content-updated');
                }
            } else {
                $errorBody = $response->json();
                $this->aiError = 'API Error: '.($errorBody['error']['message'] ?? 'ব্যাখ্যা তৈরি করা সম্ভব হয়নি।');
            }
        } catch (\Exception $e) {
            $this->aiError = 'Error: '.$e->getMessage();
        }
    }

    public function render()
    {
        // ইউজারের ভুল করা ইউনিক প্রশ্নগুলোর আইডি বের করা
        $mistakenQuestionIds = MockTestQuestion::query()
            ->whereHas('mockTest', fn($q) => $q->where('user_id', auth()->id()))
            ->where('is_correct', false) // উত্তর সঠিক হয়নি
            ->whereNotNull('user_answer') // স্কিপ করা প্রশ্ন বাদ দেওয়া হলো
            ->distinct()
            ->pluck('question_id');

        // আইডি দিয়ে মূল প্রশ্নগুলো আনা
        $questions = Question::query()
            ->whereIn('id', $mistakenQuestionIds)
            ->with(['academicClass:id,name', 'subject:id,name'])
            ->latest('id')
            ->paginate(15);

        return view('livewire.students.mistake-review', [
            'questions' => $questions
        ])->layout('layouts.app', ['title' => 'আমার ভুলসমূহ']);
    }
}
