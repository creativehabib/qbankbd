<?php

namespace App\Livewire\OMR;

use App\Models\OmrTemplate;
use App\Models\OmrToken;
use Illuminate\Support\Str;
use Livewire\Component;

class ManageTokens extends Component
{
    public bool $showModal = false;

    // ফর্ম ইনপুট ভ্যারিয়েবলস
    public $title;

    public $selectedTemplateId;

    public $totalQuestions;

    public string $negativeMark = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'selectedTemplateId' => 'required|exists:omr_templates,id',
        'totalQuestions' => 'required|integer|min:10|max:100',
        'negativeMark' => 'required',
    ];

    public function openModal()
    {
        $this->reset(['title', 'selectedTemplateId', 'totalQuestions', 'negativeMark']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    // ওএমআর টেমপ্লেট কার্ডে ক্লিক করলে ডাইনামিক সিলেকশন ও প্রশ্ন সংখ্যা সেট করা
    public function selectTemplate($templateId)
    {
        $this->selectedTemplateId = $templateId;
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

        // প্রাথমিক ফাঁকা উত্তরপত্রসহ টোকেন তৈরি করা
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

        // টোকেন জেনারেট শেষে সরাসরি আপনার উত্তরপত্র সাজানোর পেজে রিডাইরেক্ট করা
        return redirect()->route('tokens.map-answers', ['token_id' => $tokenId]);
    }

    public function render()
    {
        return view('livewire.omr.manage-tokens', [
            'tokens' => OmrToken::with('template')->latest()->get(),
            'templates' => OmrTemplate::all(), // ডাটাবেস থেকে টেমপ্লেট তালিকা রিড করা
        ]);
    }
}
