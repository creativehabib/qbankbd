<?php

namespace App\Livewire\Teacher;

use App\Models\Package;
use App\Models\UserSubscription;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PricingPlans extends Component
{
    public function purchase(int $packageId): void
    {
        $package = Package::query()->where('is_active', true)->findOrFail($packageId);
        $wallet = Wallet::query()->firstOrCreate(['user_id' => auth()->id()], ['credit_balance' => 0, 'reward_balance' => 0]);

        if ((float) $wallet->credit_balance < (float) $package->price) {
            $this->addError('purchase', 'প্যাকেজ কেনার জন্য পর্যাপ্ত ব্যালেন্স নেই। আগে রিচার্জ করুন।');

            return;
        }

        $wallet->decrement('credit_balance', (float) $package->price);

        WalletTransaction::query()->create([
            'wallet_id' => $wallet->id,
            'type' => 'recharge',
            'amount' => -1 * (float) $package->price,
            'status' => 'approved',
            'notes' => 'Package purchase: '.$package->name,
        ]);

        UserSubscription::query()->create([
            'user_id' => auth()->id(),
            'package_id' => $package->id,
            'started_at' => now(),
            'expires_at' => now()->addDays((int) $package->validity_days),
            'remaining_question_limit' => (int) $package->question_create_limit,
            'status' => 'active',
        ]);

        session()->flash('success', 'প্যাকেজ সফলভাবে কেনা হয়েছে।');
    }

    public function render(): View
    {
        return view('livewire.teacher.pricing-plans', [
            'plans' => Package::query()->where('is_active', true)->orderBy('price')->get(),
        ]);
    }
}
