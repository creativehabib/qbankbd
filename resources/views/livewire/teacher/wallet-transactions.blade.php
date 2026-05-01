<div class="space-y-6">
    <div class="grid gap-4 md:grid-cols-2">
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900"><p class="text-sm uppercase text-zinc-500">Credit Balance</p><p class="text-3xl font-bold">৳ {{ number_format((float) $wallet->credit_balance, 2) }}</p></div>
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900"><p class="text-sm uppercase text-zinc-500">Reward Balance</p><p class="text-3xl font-bold">৳ {{ number_format((float) $wallet->reward_balance, 2) }}</p></div>
    </div>

    @if (session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="inline-flex rounded-full border border-zinc-200 bg-white p-1 dark:border-zinc-700 dark:bg-zinc-900">
        <button wire:click="setTab('recharge')" class="rounded-full px-5 py-2 text-sm {{ $activeTab === 'recharge' ? 'bg-indigo-600 text-white' : '' }}">Recharge</button>
        <button wire:click="setTab('withdraw')" class="rounded-full px-5 py-2 text-sm {{ $activeTab === 'withdraw' ? 'bg-indigo-600 text-white' : '' }}">Withdraw</button>
        <button wire:click="setTab('report')" class="rounded-full px-5 py-2 text-sm {{ $activeTab === 'report' ? 'bg-indigo-600 text-white' : '' }}">Report</button>
    </div>

    <div class="mx-auto max-w-3xl rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
        @if($activeTab === 'recharge' || $activeTab === 'withdraw')
            <h2 class="mb-4 text-2xl font-semibold">{{ ucfirst($activeTab) }} Request</h2>
            <input type="number" step="0.01" wire:model="amount" class="mb-3 w-full rounded-xl border border-zinc-300 px-4 py-3" placeholder="Amount" />
            <select wire:model="paymentMethod" class="mb-3 w-full rounded-xl border border-zinc-300 px-4 py-3">
                <option value="bkash">bKash</option><option value="nagad">Nagad</option><option value="sslcommerz">SSLCOMMERZ</option>
            </select>
            @error('amount')<p class="mb-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            <button wire:click="{{ $activeTab === 'recharge' ? 'submitRecharge' : 'submitWithdraw' }}" class="w-full rounded-xl bg-indigo-600 py-3 font-semibold text-white">Submit {{ ucfirst($activeTab) }}</button>
        @else
            <h2 class="mb-4 text-2xl font-semibold">Report</h2>
            <div class="space-y-2 text-sm">
                @foreach($transactions as $transaction)
                    <div class="rounded border border-zinc-200 p-3">{{ strtoupper($transaction->type) }} - ৳{{ $transaction->amount }} - {{ ucfirst($transaction->status) }}</div>
                @endforeach
            </div>
        @endif
    </div>
</div>
