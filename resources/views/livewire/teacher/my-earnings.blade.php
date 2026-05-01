<div class="space-y-6">
    <h1 class="text-2xl font-bold">আমার উপার্জন</h1>
    <p class="text-zinc-600 dark:text-zinc-300">প্রশ্ন সংযোজন ও শেয়ারের মাধ্যমে উপার্জন করতে পারবেন।</p>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-sm text-zinc-500">প্রশ্ন সংযোজন</p>
            <p class="text-2xl font-bold">৳{{ $summary['from_questions'] }}</p>
        </div>
        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-sm text-zinc-500">শেয়ার</p>
            <p class="text-2xl font-bold">৳{{ $summary['from_shares'] }}</p>
        </div>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-5 dark:border-emerald-700 dark:bg-emerald-900/20">
            <p class="text-sm text-emerald-700 dark:text-emerald-300">মোট উপার্জন</p>
            <p class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">৳{{ $summary['total'] }}</p>
        </div>
    </div>
</div>
