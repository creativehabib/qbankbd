<?php

namespace App\Livewire\Students;

use App\Models\MockTest;
use Livewire\Component;
use Livewire\WithPagination;

class MockTestHistory extends Component
{
    use WithPagination;

    public function mount()
    {
        abort_unless(auth()->user()?->isStudent(), 403);
    }

    public function render()
    {
        $histories = MockTest::query()
            ->where('user_id', auth()->id())
            ->with(['academicClass:id,name', 'subject:id,name'])
            ->latest()
            ->paginate(12);

        return view('livewire.students.mock-test-history', [
            'histories' => $histories
        ])->layout('layouts.app', ['title' => 'পরীক্ষার ইতিহাস']);
    }
}
