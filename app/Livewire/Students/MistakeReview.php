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

    // ফিল্টার ট্র্যাক করার জন্য (wrong, right, skipped)
    public string $filter = 'wrong';

    public function mount()
    {
        abort_unless(auth()->user()?->isStudent(), 403);
    }

    // ফিল্টার পরিবর্তন করার মেথড
    public function setFilter($type)
    {
        $this->filter = $type;
        $this->resetPage(); // পেজিনেশন রিসেট হবে
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
        $prompt = 'তুমি একজন বিশেষজ্ঞ শিক্ষক। প্রশ্ন: '.$cleanTitle.'. সঠিক উত্তর: '.$correctAnswerText.'. ';
        $prompt .= 'কেন সঠিক তা বাংলায় ৩ লাইনে ব্যাখ্যা করো। ';
        $prompt .= 'গুরুত্বপূর্ণ: কোনো গাণিতিক সমীকরণ বা সংকেত থাকলে তা অবশ্যই LaTeX ফরম্যাটে লিখবে। ';
        $prompt .= 'ইনলাইন সমীকরণের জন্য একটি ডলার সাইন (যেমন: $x^2$) এবং আলাদা লাইনের বড় সমীকরণের জন্য ডাবল ডলার ব্যবহার করো।';

        try {
            $response = Http::withoutVerifying()->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key={$apiKey}", [
                'contents' => [['parts' => [['text' => $prompt]]]],
            ]);

            if ($response->successful()) {
                $result = $response->json();
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $explanation = $result['candidates'][0]['content']['parts'][0]['text'];
                    $question->update(['description' => nl2br(trim($explanation))]);

                    $this->dispatch('practice-content-updated');
                }
            } else {
                $errorBody = $response->json();
                $this->aiError = 'API Error: '.($errorBody['error']['message'] ?? 'ব্যাখ্যা তৈরি করা সম্ভব হয়নি।');
            }
        } catch (\Exception $e) {
            $this->aiError = 'Error: '.$e->getMessage();
        }
    }

    public function render()
    {
        // ইউজারের সকল মক টেস্টের প্রশ্নগুলোর বেস কুয়েরি
        $baseQuery = MockTestQuestion::whereHas('mockTest', fn ($q) => $q->where('user_id', auth()->id()));

        // ১. উপরের ব্যানারের পরিসংখ্যান (Stats) হিসাব করা
        $rightCount = (clone $baseQuery)->where('is_correct', true)->count();
        $wrongCount = (clone $baseQuery)->where('is_correct', false)->whereNotNull('user_answer')->count();
        $skippedCount = (clone $baseQuery)->whereNull('user_answer')->count();
        $totalCount = $rightCount + $wrongCount + $skippedCount;

        $accuracy = $totalCount > 0 ? round(($rightCount / $totalCount) * 100, 1) : 0;

        // ২. ফিল্টার অনুযায়ী প্রশ্ন আলাদা করা
        $filteredQuery = clone $baseQuery;
        if ($this->filter === 'right') {
            $filteredQuery->where('is_correct', true);
        } elseif ($this->filter === 'skipped') {
            $filteredQuery->whereNull('user_answer');
        } else {
            $filteredQuery->where('is_correct', false)->whereNotNull('user_answer');
        }

        $filteredQuestionIds = $filteredQuery->distinct()->pluck('question_id');

        // মূল প্রশ্নগুলো আনা (চ্যাপ্টার বা টপিক রিলেশন থাকলে সেটাও এড করে নিন)
        $questions = Question::query()
            ->whereIn('id', $filteredQuestionIds)
            ->with(['academicClass:id,name', 'subject:id,name'])
            ->latest('id')
            ->paginate(15);

        // ৩. ডানদিকের Subjects Report এর জন্য ডাইনামিক ডাটা তৈরি
        // শুধুমাত্র সেই সাবজেক্টগুলো আনবে যেগুলোতে প্রশ্ন আছে
        $subjectReports = \App\Models\Subject::withCount('questions as total_mcq')->having('total_mcq', '>', 0)->get()->map(function($subject) {

            // এই নির্দিষ্ট সাবজেক্টে ইউজারের পারফরম্যান্স
            $userAttempts = MockTestQuestion::whereHas('mockTest', fn($q) => $q->where('user_id', auth()->id()))
                ->whereHas('question', fn($q) => $q->where('subject_id', $subject->id))
                ->get();

            $subRight = $userAttempts->where('is_correct', true)->count();
            $subTotalAttended = $userAttempts->count();

            $subAccuracy = $subTotalAttended > 0 ? round(($subRight / $subTotalAttended) * 100, 2) : 0;

            return [
                'id' => $subject->id,
                'name' => $subject->name,
                'accuracy' => $subAccuracy,
                'total_mcq' => $subject->total_mcq,
                'right_mcq' => $subRight, // ছাত্র কয়টি সঠিক করেছে
                // যদি আপনার CQ বা Content টেবিল থাকে, তবে সেগুলোর কাউন্ট এখানে বসাতে পারেন। আপাতত ডামি হিসেবে 0 রাখা হলো।
                'total_cq' => 0,
                'total_content' => 0,
            ];
        });

        return view('livewire.students.mistake-review', [
            'questions' => $questions,
            'subjectReports' => $subjectReports, // নতুন ভেরিয়েবল পাঠানো হলো
            'stats' => [
                'right' => $rightCount,
                'wrong' => $wrongCount,
                'skipped' => $skippedCount,
                'total' => $totalCount,
                'accuracy' => $accuracy
            ]
        ])->layout('layouts.app', ['title' => 'Mistake Vault']);
    }
}
