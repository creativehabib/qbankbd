<?php

namespace App\Livewire\Admin;

use App\Models\WalletTransaction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class WalletApprovalPanel extends Component
{
    public function approve(int $transactionId): void
    {
        $transaction = WalletTransaction::query()->where('status', 'pending')->findOrFail($transactionId);

        if ($transaction->type === 'recharge') {
            $transaction->wallet()->increment('credit_balance', (float) $transaction->amount);
        }

        if ($transaction->type === 'withdraw') {
            $transaction->wallet()->decrement('reward_balance', (float) $transaction->amount);
        }

        $transaction->update(['status' => 'approved']);
    }

    public function reject(int $transactionId): void
    {
        $transaction = WalletTransaction::query()->where('status', 'pending')->findOrFail($transactionId);
        $transaction->update(['status' => 'rejected']);
    }

    public function render(): View
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        return view('livewire.admin.wallet-approval-panel', [
            'pendingTransactions' => WalletTransaction::query()->with('wallet.user')->where('status', 'pending')->latest()->get(),
        ]);
    }
}
