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

            // 🌟 ডাটাবেজের সাথে ম্যাচিং ভ্যালিডেশন
            'unique_code' => $this->templateType !== 'signature'
                ? 'required|string|max:50|exists:omr_templates,unique_code'
                : 'nullable',

            'negativeMark' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'unique_code.required' => 'OMR Sheet Code প্রদান করা আবশ্যক!',
            'unique_code.exists' => 'OMR কোডটি ডাটাবেজের সাথে ম্যাচ করেনি! দয়া করে সঠিক কোড দিন।',
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
