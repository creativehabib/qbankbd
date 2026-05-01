<?php

use App\Livewire\Admin\WalletApprovalPanel;
use App\Livewire\Teacher\WalletTransactions;
use App\Models\User;
use App\Models\Wallet;
use Livewire\Livewire;

it('teacher can submit recharge request and admin can approve', function () {
    $teacher = User::factory()->teacher()->create();
    $admin = User::factory()->create();
    $admin->syncRoles(['super_admin']);

    $this->actingAs($teacher);

    Livewire::test(WalletTransactions::class)
        ->set('activeTab', 'recharge')
        ->set('amount', 200)
        ->set('paymentMethod', 'bkash')
        ->call('submitRecharge')
        ->assertHasNoErrors();

    $wallet = Wallet::query()->where('user_id', $teacher->id)->firstOrFail();
    $transaction = $wallet->transactions()->where('type', 'recharge')->latest('id')->firstOrFail();

    expect($transaction->status)->toBe('pending');

    $this->actingAs($admin);

    Livewire::test(WalletApprovalPanel::class)
        ->call('approve', $transaction->id);

    $transaction->refresh();
    $wallet->refresh();

    expect($transaction->status)->toBe('approved')
        ->and((float) $wallet->credit_balance)->toBe(200.0);
});
