@php
    $panelTitle = $panelTitle ?? 'Dashboard Panel';
    $welcomeTitle = $welcomeTitle ?? 'অনলাইন ডিজিটাল স্কুল';
    $welcomeSubtitle = $welcomeSubtitle ?? 'রোল: ব্যবহারকারী';
    $description = $description ?? 'ড্যাশবোর্ড তথ্য';
@endphp

<x-layouts::app :title="$panelTitle">
    <x-slot:header>
        <div class="px-6 py-2">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ $panelTitle }}</h1>
                </div>

                <div class="flex items-center gap-2">
                    <flux:button variant="ghost" icon="moon" size="sm">{{ __('Theme') }}</flux:button>
                    <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />
                </div>
            </div>
        </div>
    </x-slot:header>

    <div class="space-y-4 sm:space-y-5">
        <section class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-1">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 sm:text-xl">{{ $welcomeTitle }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $welcomeSubtitle }}</p>
                </div>

                <div class="grid w-full grid-cols-1 gap-2 sm:w-auto sm:grid-cols-2">
                    <flux:button class="w-full" variant="primary" icon="pencil-square">{{ __('তথ্য পরিবর্তন') }}</flux:button>
                    <flux:button class="w-full" variant="primary" icon="building-library">{{ __('প্রতিষ্ঠান নির্বাচন') }}</flux:button>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">
            <div class="space-y-2 text-center">
                <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 sm:text-2xl">{{ __('ড্যাশবোর্ড ওভারভিউ') }}</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</p>
            </div>

            <div class="mt-4 grid grid-cols-1 gap-3 sm:mt-5 sm:grid-cols-2 lg:grid-cols-4 sm:gap-4">
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
