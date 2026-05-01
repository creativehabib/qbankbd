<?php

namespace App\Livewire\Teacher;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class MyEarnings extends Component
{
    public function render(): View
    {
        return view('livewire.teacher.my-earnings', [
            'summary' => [
                'from_questions' => 1250,
                'from_shares' => 840,
                'total' => 2090,
            ],
        ]);
    }
}
