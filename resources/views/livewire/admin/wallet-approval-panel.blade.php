<div class="space-y-4">
    <h1 class="text-2xl font-bold">Recharge / Withdraw Approval</h1>

    <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
        <table class="min-w-full text-sm">
            <thead>
            <tr class="text-left text-zinc-500">
                <th class="py-2">User</th><th class="py-2">Type</th><th class="py-2">Amount</th><th class="py-2">Method</th><th class="py-2">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($pendingTransactions as $transaction)
                <tr class="border-t border-zinc-200 dark:border-zinc-700">
                    <td class="py-2">{{ $transaction->wallet->user->name ?? '-' }}</td>
                    <td class="py-2">{{ strtoupper($transaction->type) }}</td>
                    <td class="py-2">৳{{ $transaction->amount }}</td>
                    <td class="py-2">{{ $transaction->payment_method }}</td>
                    <td class="py-2 space-x-2">
                        <button wire:click="approve({{ $transaction->id }})" class="rounded bg-emerald-600 px-3 py-1 text-white">Approve</button>
                        <button wire:click="reject({{ $transaction->id }})" class="rounded bg-rose-600 px-3 py-1 text-white">Reject</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-6 text-center text-zinc-500">No pending request.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
