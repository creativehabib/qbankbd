<div class="space-y-6">
    <div class="grid gap-4 md:grid-cols-2">
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900"><p class="text-sm uppercase text-zinc-500">Credit Balance</p><p class="text-3xl font-bold">৳ 0</p></div>
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900"><p class="text-sm uppercase text-zinc-500">Reward Balance</p><p class="text-3xl font-bold">৳ 5</p></div>
    </div>

    <div class="inline-flex rounded-full border border-zinc-200 bg-white p-1 dark:border-zinc-700 dark:bg-zinc-900">
        <button wire:click="setTab('recharge')" class="rounded-full px-5 py-2 text-sm {{ $activeTab === 'recharge' ? 'bg-indigo-600 text-white' : '' }}">Recharge</button>
        <button wire:click="setTab('withdraw')" class="rounded-full px-5 py-2 text-sm {{ $activeTab === 'withdraw' ? 'bg-indigo-600 text-white' : '' }}">Withdraw</button>
        <button wire:click="setTab('report')" class="rounded-full px-5 py-2 text-sm {{ $activeTab === 'report' ? 'bg-indigo-600 text-white' : '' }}">Report</button>
    </div>

    <div class="mx-auto max-w-3xl rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
        @if($activeTab === 'recharge')
            <h2 class="mb-4 text-2xl font-semibold">Recharge Account</h2>
            <p class="mb-3 text-sm">Amount (৳)</p>
            <input class="mb-4 w-full rounded-xl border border-zinc-300 px-4 py-3 dark:border-zinc-700 dark:bg-zinc-800" placeholder="Enter amount" />
            <p class="mb-2 text-sm">Payment Method</p>
            <div class="grid gap-3 md:grid-cols-3">
                <button class="rounded-xl border-2 border-indigo-500 p-4 font-semibold">bKash</button>
                <button class="rounded-xl border border-zinc-300 p-4 font-semibold">Nagad</button>
                <button class="rounded-xl border border-zinc-300 p-4 font-semibold">SSLCOMMERZ</button>
            </div>
            <button class="mt-5 w-full rounded-xl bg-indigo-600 py-3 font-semibold text-white">Recharge Now</button>
        @elseif($activeTab === 'withdraw')
            <h2 class="mb-4 text-2xl font-semibold">Withdraw</h2>
            <p class="text-sm text-zinc-500">উপার্জনের ব্যালেন্স থেকে উইথড্র অনুরোধ করুন।</p>
        @else
            <h2 class="mb-4 text-2xl font-semibold">Report</h2>
            <p class="text-sm text-zinc-500">Recharge ও Withdraw history রিপোর্ট এখানে দেখাবে।</p>
        @endif
    </div>
</div>
