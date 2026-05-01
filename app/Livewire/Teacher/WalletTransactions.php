<?php

namespace App\Livewire\Teacher;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class WalletTransactions extends Component
{
    public string $activeTab = 'recharge';

    public ?float $amount = null;

    public string $paymentMethod = 'bkash';

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function submitRecharge(): void
    {
        $validated = $this->validate([
            'amount' => ['required', 'numeric', 'min:20'],
            'paymentMethod' => ['required', 'in:bkash,nagad,sslcommerz'],
        ]);

        $wallet = Wallet::query()->firstOrCreate(['user_id' => auth()->id()], ['credit_balance' => 0, 'reward_balance' => 0]);

        WalletTransaction::query()->create([
            'wallet_id' => $wallet->id,
            'type' => 'recharge',
            'amount' => (float) $validated['amount'],
            'status' => 'pending',
            'payment_method' => $validated['paymentMethod'],
        ]);

        $this->reset('amount');
        session()->flash('success', 'Recharge request জমা হয়েছে। Admin approve করলে balance add হবে।');
    }

    public function submitWithdraw(): void
    {
        $validated = $this->validate([
            'amount' => ['required', 'numeric', 'min:20'],
            'paymentMethod' => ['required', 'in:bkash,nagad,sslcommerz'],
        ]);

        $wallet = Wallet::query()->firstOrCreate(['user_id' => auth()->id()], ['credit_balance' => 0, 'reward_balance' => 0]);

        if ((float) $wallet->reward_balance < (float) $validated['amount']) {
            $this->addError('amount', 'Reward balance পর্যাপ্ত নয়।');

            return;
        }

        WalletTransaction::query()->create([
            'wallet_id' => $wallet->id,
            'type' => 'withdraw',
            'amount' => (float) $validated['amount'],
            'status' => 'pending',
            'payment_method' => $validated['paymentMethod'],
        ]);

        $this->reset('amount');
        session()->flash('success', 'Withdraw request জমা হয়েছে। Admin approve করলে প্রসেস হবে।');
    }

    public function render(): View
    {
        $wallet = Wallet::query()->firstOrCreate(['user_id' => auth()->id()], ['credit_balance' => 0, 'reward_balance' => 0]);

        return view('livewire.teacher.wallet-transactions', [
            'wallet' => $wallet,
            'transactions' => $wallet->transactions()->latest()->limit(10)->get(),
        ]);
    }
}
