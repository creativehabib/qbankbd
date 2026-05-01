<div class="mx-auto w-full max-w-3xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">প্রতিষ্ঠানের তথ্য</h1>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">শিক্ষক প্রোফাইলের জন্য প্রতিষ্ঠানের তথ্য আপডেট করুন।</p>
    </div>

    @if (session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-4 rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
        <flux:input wire:model="institutionName" label="প্রতিষ্ঠানের নাম" placeholder="যেমন: ঢাকা কলেজ" />
        <flux:input wire:model="institutionType" label="প্রতিষ্ঠানের ধরন" placeholder="যেমন: কলেজ / স্কুল / মাদ্রাসা" />
        <flux:textarea wire:model="institutionAddress" label="প্রতিষ্ঠানের ঠিকানা" rows="4" />

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">আপডেট করুন</flux:button>
        </div>
    </form>
</div>
