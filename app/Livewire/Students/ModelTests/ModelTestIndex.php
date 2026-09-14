<?php

namespace App\Livewire\Students\ModelTests;

use App\Models\ModelTest;
use Livewire\Component;
use Livewire\WithPagination;

class ModelTestIndex extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.students.model-tests.model-test-index', [
            'modelTests' => ModelTest::with(['package'])
                ->withCount('questions')
                ->where('is_published', true)
                ->latest()
                ->paginate(15),
        ])->layout('layouts.app', ['title' => 'Available Model Tests']);
    }
}
