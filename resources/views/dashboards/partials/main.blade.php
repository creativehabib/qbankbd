@php
    $panelTitle = $panelTitle ?? 'Dashboard Panel';
    $welcomeTitle = $welcomeTitle ?? 'অনলাইন ডিজিটাল স্কুল';
    $welcomeSubtitle = $welcomeSubtitle ?? 'রোল: ব্যবহারকারী';
    $description = $description ?? 'ড্যাশবোর্ড তথ্য';
@endphp

<x-layouts::app :title="$panelTitle">
    <x-slot:header>
        <div class="px-6 py-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $panelTitle }}</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Role based main dashboard') }}</p>
                </div>

                <div class="flex items-center gap-2">
                    <flux:button variant="ghost" icon="moon" size="sm">{{ __('Theme') }}</flux:button>
                    <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />
                </div>
            </div>
        </div>
    </x-slot:header>

    <div class="space-y-5">
        <section class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="space-y-1">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ $welcomeTitle }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $welcomeSubtitle }}</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <flux:button variant="primary" icon="pencil-square">{{ __('তথ্য পরিবর্তন') }}</flux:button>
                    <flux:button variant="primary" icon="building-library">{{ __('প্রতিষ্ঠান নির্বাচন') }}</flux:button>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="space-y-2 text-center">
                <h3 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ __('ড্যাশবোর্ড ওভারভিউ') }}</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</p>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-4">
                <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('মোট প্রশ্ন') }}</p>
                    <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">0</p>
                </div>
                <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('মোট MCQ প্রশ্ন') }}</p>
                    <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">0</p>
                </div>
                <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('মোট লিখিত প্রশ্ন') }}</p>
                    <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">0</p>
                </div>
                <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('মোট খরচ') }}</p>
                    <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">৳ 0</p>
                </div>
            </div>
        </section>
    </div>
</x-layouts::app>
