<?php

namespace App\Livewire\Teacher;

use App\Models\Package;
use App\Models\UserSubscription;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PackageCheckout extends Component
{
    public Package $package;

    public string $paymentMethod = 'wallet';

    public function mount(Package $package): void
    {
        abort_unless($package->is_active, 404);

        $this->package = $package;
    }

    public function confirmPurchase(): void
    {
        $wallet = Wallet::query()->firstOrCreate(['user_id' => auth()->id()], ['credit_balance' => 0, 'reward_balance' => 0]);
        $totalBalance = (float) $wallet->credit_balance + (float) $wallet->reward_balance;

        if ($this->paymentMethod !== 'wallet') {
            $this->addError('paymentMethod', 'এই মেথডটি শিগগিরই চালু হবে। আপাতত A/C Balance দিয়ে পেমেন্ট করুন।');

            return;
        }

        if ($totalBalance < (float) $this->package->price) {
            $this->addError('paymentMethod', 'প্যাকেজ কেনার জন্য পর্যাপ্ত ব্যালেন্স নেই। আগে রিচার্জ করুন।');

            return;
        }

        $deductFromCredit = min((float) $wallet->credit_balance, (float) $this->package->price);
        $remaining = (float) $this->package->price - $deductFromCredit;

        if ($deductFromCredit > 0) {
            $wallet->decrement('credit_balance', $deductFromCredit);
        }

        if ($remaining > 0) {
            $wallet->decrement('reward_balance', $remaining);
        }

        WalletTransaction::query()->create([
            'wallet_id' => $wallet->id,
            'type' => 'recharge',
            'amount' => -1 * (float) $this->package->price,
            'status' => 'approved',
            'notes' => 'Package purchase: '.$this->package->name,
        ]);

        UserSubscription::query()->create([
            'user_id' => auth()->id(),
            'package_id' => $this->package->id,
            'started_at' => now(),
            'expires_at' => now()->addDays((int) $this->package->validity_days),
            'remaining_question_limit' => (int) $this->package->question_create_limit,
            'status' => 'active',
        ]);

        session()->flash('success', 'প্যাকেজ সফলভাবে কেনা হয়েছে।');

        $this->redirectRoute('teacher.subscription', navigate: true);
    }

    public function render(): View
    {
        $wallet = Wallet::query()->firstOrCreate(['user_id' => auth()->id()], ['credit_balance' => 0, 'reward_balance' => 0]);

        return view('livewire.teacher.package-checkout', [
            'wallet' => $wallet,
            'totalBalance' => (float) $wallet->credit_balance + (float) $wallet->reward_balance,
        ]);
    }
}
