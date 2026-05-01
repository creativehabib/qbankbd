<div class="space-y-6">
    <div class="grid gap-4 md:grid-cols-2">
        <div class="rounded-2xl border border-zinc-200 bg-white p-5"><p class="text-xs uppercase tracking-[0.18em] text-zinc-500">Credit Balance</p><p class="mt-1 text-4xl font-bold">৳ {{ (int) $wallet->credit_balance }}</p></div>
        <div class="rounded-2xl border border-zinc-200 bg-white p-5"><p class="text-xs uppercase tracking-[0.18em] text-zinc-500">Reward Balance</p><p class="mt-1 text-4xl font-bold">৳ {{ (int) $wallet->reward_balance }}</p></div>
    </div>

    <div class="flex justify-center">
        <div class="inline-flex rounded-2xl border border-zinc-200 bg-white p-1">
            <button wire:click="setTab('recharge')" class="rounded-xl px-4 py-2 text-sm font-semibold {{ $activeTab === 'recharge' ? 'bg-indigo-600 text-white' : 'text-zinc-600' }}">Recharge</button>
            <button wire:click="setTab('withdraw')" class="rounded-xl px-4 py-2 text-sm font-semibold {{ $activeTab === 'withdraw' ? 'bg-indigo-600 text-white' : 'text-zinc-600' }}">Withdraw</button>
            <button wire:click="setTab('report')" class="rounded-xl px-4 py-2 text-sm font-semibold {{ $activeTab === 'report' ? 'bg-indigo-600 text-white' : 'text-zinc-600' }}">Report</button>
        </div>
    </div>

    @if (session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">{{ session('success') }}</div>
    @endif

    @if($activeTab === 'recharge')
        <div class="mx-auto max-w-3xl rounded-2xl border border-zinc-200 bg-white p-6">
            <h2 class="text-3xl font-bold">Recharge Account</h2>
            <div class="mx-auto mt-5 inline-flex rounded-2xl bg-indigo-50 px-5 py-2 text-sm font-semibold text-indigo-700">Total Balance: ৳{{ (int) $wallet->reward_balance }}</div>

            <div class="mt-5 flex flex-wrap gap-2">
                @foreach([20,50,100,200,500] as $preset)
                    <button type="button" wire:click="$set('amount', {{ $preset }})" class="rounded-lg bg-zinc-100 px-4 py-2 text-sm font-semibold">৳{{ $preset }}</button>
                @endforeach
            </div>

            <label class="mt-5 block text-sm font-medium">Amount (৳)</label>
            <input type="number" wire:model="amount" class="mt-2 w-full rounded-xl border border-zinc-300 px-4 py-3" placeholder="Enter amount" />

            <p class="mt-5 text-sm font-medium">Payment Method</p>
            <div class="mt-3 grid gap-3 md:grid-cols-3">
                <button wire:click="setPaymentMethod('bkash')" type="button" class="rounded-2xl border p-5 text-center {{ $paymentMethod === 'bkash' ? 'border-blue-600 bg-blue-50' : 'border-zinc-300' }}"><p class="text-3xl font-extrabold text-pink-600">bKash</p><p class="mt-2 text-sm text-zinc-600">bKash</p></button>
                <button wire:click="setPaymentMethod('nagad')" type="button" class="rounded-2xl border p-5 text-center {{ $paymentMethod === 'nagad' ? 'border-blue-600 bg-blue-50' : 'border-zinc-300' }}"><p class="text-3xl font-extrabold text-orange-600">Nagad</p><p class="mt-2 text-sm text-zinc-600">Nagad</p></button>
                <button wire:click="setPaymentMethod('sslcommerz')" type="button" class="rounded-2xl border p-5 text-center {{ $paymentMethod === 'sslcommerz' ? 'border-blue-600 bg-blue-50' : 'border-zinc-300' }}"><p class="text-3xl font-extrabold text-blue-600">SSLCOMMERZ</p><p class="mt-2 text-sm text-zinc-600">All Cards</p></button>
            </div>

            @error('amount')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            <button wire:click="submitRecharge" class="mt-5 w-full rounded-xl bg-indigo-600 py-3 text-lg font-bold text-white">Recharge Now</button>
        </div>
    @elseif($activeTab === 'withdraw')
        <div class="mx-auto max-w-3xl rounded-2xl border border-zinc-200 bg-white p-6">
            <h2 class="text-3xl font-bold">Request Withdrawal</h2>
            <p class="mt-5 text-sm font-medium">Select Balance Type</p>
            <div class="mt-2 grid gap-3 md:grid-cols-2">
                <button type="button" wire:click="$set('withdrawBalanceType', 'reward')" class="rounded-xl border p-4 text-left {{ $withdrawBalanceType === 'reward' ? 'border-blue-600 bg-blue-50' : 'border-zinc-300' }}">Reward Balance<br><span class="text-sm text-zinc-500">Balance: ৳ {{ (int) $wallet->reward_balance }}</span></button>
                <button type="button" wire:click="$set('withdrawBalanceType', 'credit')" class="rounded-xl border p-4 text-left {{ $withdrawBalanceType === 'credit' ? 'border-blue-600 bg-blue-50' : 'border-zinc-300' }}">Credit Balance<br><span class="text-sm text-zinc-500">Balance: ৳ {{ (int) $wallet->credit_balance }}</span></button>
            </div>
            <p class="mt-3 text-sm text-orange-600">Minimum ৳500 reward balance required to withdraw</p>

            <label class="mt-4 block text-sm font-medium">Amount (৳)</label>
            <input type="number" wire:model="amount" class="mt-2 w-full rounded-xl border border-zinc-300 px-4 py-3" placeholder="Enter amount" />

            <label class="mt-4 block text-sm font-medium">Payment Method</label>
            <select wire:model="paymentMethod" class="mt-2 w-full rounded-xl border border-zinc-300 px-4 py-3"><option value="bkash">bKash</option><option value="nagad">Nagad</option><option value="sslcommerz">SSLCOMMERZ</option></select>

            <label class="mt-4 block text-sm font-medium">Account Number</label>
            <input type="text" wire:model="accountNumber" class="mt-2 w-full rounded-xl border border-zinc-300 px-4 py-3" placeholder="Enter account number" />

            <label class="mt-4 block text-sm font-medium">Notes (Optional)</label>
            <textarea wire:model="notes" rows="3" class="mt-2 w-full rounded-xl border border-zinc-300 px-4 py-3" placeholder="Add any additional notes..."></textarea>
            @error('amount')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            <button wire:click="submitWithdraw" class="mt-5 w-full rounded-xl bg-indigo-600 py-3 text-lg font-bold text-white">Submit Withdrawal Request</button>
        </div>
    @else
        <div class="space-y-4">
            <div class="grid gap-4 md:grid-cols-4">
                <div class="rounded-2xl border border-zinc-200 bg-white p-4"><p class="text-xs uppercase text-zinc-500">Total Transactions</p><p class="text-3xl font-bold">{{ $transactions->count() }}</p></div>
                <div class="rounded-2xl border border-zinc-200 bg-white p-4"><p class="text-xs uppercase text-zinc-500">Total Withdrawals</p><p class="text-3xl font-bold">{{ $transactions->where('type', 'withdraw')->count() }}</p></div>
                <div class="rounded-2xl border border-zinc-200 bg-white p-4"><p class="text-xs uppercase text-zinc-500">Total Revenue</p><p class="text-3xl font-bold">৳ {{ (int) $transactions->where('type', 'recharge')->sum('amount') }}</p></div>
                <div class="rounded-2xl border border-zinc-200 bg-white p-4"><p class="text-xs uppercase text-zinc-500">Total Deposits</p><p class="text-3xl font-bold">{{ $transactions->where('type', 'recharge')->count() }}</p></div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white">
                <table class="min-w-full text-sm">
                    <thead><tr class="text-left text-xs uppercase text-zinc-500"><th class="px-4 py-3">Date</th><th class="px-4 py-3">Type</th><th class="px-4 py-3">Amount</th><th class="px-4 py-3">Payment Method</th><th class="px-4 py-3">Status</th></tr></thead>
                    <tbody>
                    @forelse($transactions as $transaction)
                        <tr class="border-t border-zinc-200">
                            <td class="px-4 py-3">{{ $transaction->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3"><span class="rounded bg-zinc-100 px-2 py-1">{{ $transaction->type }}</span></td>
                            <td class="px-4 py-3">৳ {{ (int) $transaction->amount }}</td>
                            <td class="px-4 py-3">{{ $transaction->payment_method ?? '-' }}</td>
                            <td class="px-4 py-3"><span class="rounded px-2 py-1 {{ $transaction->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($transaction->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">{{ $transaction->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-5 text-center text-zinc-500">No transaction found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
