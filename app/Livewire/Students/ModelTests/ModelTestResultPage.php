<?php

namespace App\Livewire\Students\ModelTests;

use App\Models\ModelTestResult;
use Livewire\Component;

class ModelTestResultPage extends Component
{
    public ModelTestResult $result;
    
    public function mount($resultId)
    {
        $this->result = ModelTestResult::with('modelTest')->where('id', $resultId)->where('user_id', auth()->id())->firstOrFail();
    }

    public function render()
    {
        return view('livewire.students.model-tests.model-test-result-page')
            ->layout('layouts.app', ['title' => 'Exam Result']);
    }
}
