<?php

namespace App\Livewire\Teacher;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class WalletTransactions extends Component
{
    public string $activeTab = 'recharge';

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function render(): View
    {
        return view('livewire.teacher.wallet-transactions');
    }
}
