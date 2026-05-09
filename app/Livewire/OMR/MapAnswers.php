<?php

namespace App\Livewire\OMR;

use App\Models\OmrToken;
use Livewire\Component;

class MapAnswers extends Component
{
    public $token;

    public $answers = [];

    public function mount($token_id)
    {
        $this->token = OmrToken::where('token_id', $token_id)->firstOrFail();
        $this->answers = $this->token->answer_key ?? array_fill(1, $this->token->total_questions, '');
    }

    public function setAnswer($questionNum, $option)
    {
        $this->answers[$questionNum] = $option;
    }

    public function saveAnswers()
    {
        $this->token->update([
            'answer_key' => $this->answers,
        ]);
        session()->flash('message', 'উত্তরপত্র ড্রাফট হিসেবে সেভ হয়েছে!');
    }

    public function completeSetup()
    {
        $this->token->update([
            'answer_key' => $this->answers,
        ]);
        session()->flash('success_message', 'উত্তরপত্র সফলভাবে সম্পূর্ণ হয়েছে!');

        return redirect()->route('tokens.list');
    }

    public function render()
    {
        return view('livewire.omr.map-answers');
    }
}
