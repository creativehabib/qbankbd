<?php

namespace App\Livewire\Admin\ModelTests;

use App\Models\ModelTest;
use Livewire\Component;
use Livewire\WithPagination;

class ModelTestIndex extends Component
{
    use WithPagination;

    public function delete(ModelTest $modelTest)
    {
        $modelTest->delete();
        session()->flash('success', 'মডেল টেস্ট মুছে ফেলা হয়েছে।');
    }

    public function render()
    {
        return view('livewire.admin.model-tests.model-test-index', [
            'modelTests' => ModelTest::withCount('questions')->latest()->paginate(20),
        ])->layout('layouts.app', ['title' => 'Model Tests']);
    }
}
