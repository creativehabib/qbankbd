<?php

namespace App\Livewire\Teacher;

use App\Models\Wallet;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MyEarnings extends Component
{
    public function render(): View
    {
        $wallet = Wallet::query()->with('transactions')->where('user_id', auth()->id())->first();

        $fromQuestions = (float) optional($wallet)->transactions?->where('type', 'earn_question')->where('status', 'approved')->sum('amount');
        $fromShares = (float) optional($wallet)->transactions?->where('type', 'earn_share')->where('status', 'approved')->sum('amount');

        return view('livewire.teacher.my-earnings', [
            'summary' => [
                'from_questions' => $fromQuestions,
                'from_shares' => $fromShares,
                'total' => $fromQuestions + $fromShares,
            ],
        ]);
    }
}
