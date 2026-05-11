<?php

namespace App\Livewire\OMR;

use App\Models\OmrTemplate;
use App\Models\OmrToken;
use Illuminate\Support\Str;
use Livewire\Component;

class ManageTokens extends Component
{
    public bool $showModal = false;

    // ফর্ম ইনপুট ভ্যারিয়েবলস
    public $title;
    public $selectedTemplateId;
    public $templateType = 'signature';
    public $totalQuestions;
    public $unique_code;
    public string $negativeMark = '';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'selectedTemplateId' => 'required|exists:omr_templates,id',
            'totalQuestions' => 'required|integer|min:10|max:100',

            // 🌟 ডাটাবেজ ম্যাচিং (exists:omr_templates,unique_code) বাদ দেওয়া হলো 🌟
            'unique_code' => $this->templateType !== 'signature'
                ? 'required|string|max:50'
                : 'nullable',

            'negativeMark' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'unique_code.required' => 'OMR Sheet Code প্রদান করা আবশ্যক!',
            // 🌟 unique_code.exists এর মেসেজটিও মুছে দেওয়া হলো 🌟
            'totalQuestions.required' => 'মোট প্রশ্ন সংখ্যা দেওয়া আবশ্যক!',
            'title.required' => 'পরীক্ষার একটি টাইটেল দিন!',
            'negativeMark.required' => 'নেগেটিভ মার্কিং সিলেক্ট করুন!',
        ];
    }
    public function openModal()
    {
        $this->reset(['title', 'selectedTemplateId', 'totalQuestions', 'negativeMark', 'unique_code', 'templateType']);

        $defaultTemplate = OmrTemplate::where('type', 'signature')->first();
        if ($defaultTemplate) {
            $this->selectedTemplateId = $defaultTemplate->id;
            $this->templateType = 'signature';
            $this->totalQuestions = $defaultTemplate->total_questions;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function selectTemplate($templateId, $type)
    {
        $this->selectedTemplateId = $templateId;
        $this->templateType = $type;

        $template = OmrTemplate::find($templateId);
        if ($template) {
            $this->totalQuestions = $template->total_questions;
        }
    }

    public function updatedUniqueCode($value)
    {
        // প্রাথমিক ফরম্যাট চেক (১ম ও ৩য় ডিজিট ১ হতে হবে)
        if (strlen($value) >= 4 && $value[0] === '1' && in_array($value[1], ['2', '3', '4']) && $value[2] === '1') {

            $cols = (int) $value[1]; // ২য় ডিজিট (কলাম)
            $q_count = (int) substr($value, 3); // ৩য় ডিজিটের পর থেকে প্রশ্ন সংখ্যা

            // 🌟 নতুন শর্ত অনুযায়ী ভ্যালিডেশন চেক 🌟
            if ($q_count > 70 && $cols < 4) {
                $this->addError('unique_code', '৭০ এর বেশি প্রশ্নের জন্য কোডটি অবশ্যই ১৪১... (৪ কলাম) দিয়ে শুরু হতে হবে।');
                $this->totalQuestions = null;
            } elseif ($q_count > 50 && $cols < 3) {
                $this->addError('unique_code', '৫০ এর বেশি প্রশ্নের জন্য কোডটি অন্তত ১৩১... (৩ কলাম) দিয়ে শুরু হতে হবে।');
                $this->totalQuestions = null;
            } else {
                // সব ঠিক থাকলে প্রশ্ন সংখ্যা সেট হবে
                $this->totalQuestions = $q_count;
                $this->resetErrorBag('unique_code');
            }

        } else {
            $this->totalQuestions = null;
        }
    }

    public function generateToken()
    {
        $this->validate();

        $template = OmrTemplate::find($this->selectedTemplateId);
        $tokenId = 'TOK-'.strtoupper(Str::random(6));

        // 🌟 omr_tokens টেবিলে unique_code কলাম না থাকায় সেটি এখান থেকে বাদ দেওয়া হয়েছে 🌟
        OmrToken::create([
            'token_id' => $tokenId,
            'omr_template_id' => $template->id,
            'title' => $this->title,
            'answer_key' => array_fill(1, $this->totalQuestions, ''),
            'correct_mark' => 1.00,
            'negative_mark' => floatval($this->negativeMark),
            'total_questions' => $this->totalQuestions,
        ]);

        $this->showModal = false;

        return redirect()->route('tokens.map-answers', ['token_id' => $tokenId]);
    }

    public function render()
    {
        return view('livewire.omr.manage-tokens', [
            'tokens' => OmrToken::with('template')->latest()->get(),
            'templates' => OmrTemplate::all(),
        ]);
    }
}
