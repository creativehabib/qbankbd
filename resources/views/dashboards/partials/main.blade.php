@php
    $panelTitle = $panelTitle ?? 'Dashboard Panel';
    $welcomeTitle = $welcomeTitle ?? 'অনলাইন ডিজিটাল স্কুল';
    $welcomeSubtitle = $welcomeSubtitle ?? 'রোল: ব্যবহারকারী';
    $description = $description ?? 'ড্যাশবোর্ড তথ্য';
    $isTeacher = auth()->user()?->hasRole('teacher');
@endphp

<x-layouts::app :title="$panelTitle">
    <div class="space-y-4 sm:space-y-5">
        <section class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-1">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 sm:text-xl">{{ $welcomeTitle }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $welcomeSubtitle }}</p>
                </div>

                <div class="grid w-full grid-cols-1 gap-2 sm:w-auto sm:grid-cols-2">
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">তথ্য পরিবর্তন</a>
                    <a href="{{ $isTeacher ? route('teacher.institution-info') : route('dashboard') }}" class="inline-flex items-center justify-center rounded-lg border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700">প্রতিষ্ঠান তথ্য</a>
                </div>
            </div>
        </section>

        @if($isTeacher)
            <section class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">নতুন অপশনসমূহ</h3>
                    <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">Teacher Tools</span>
                </div>

                <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    <a href="{{ route('teacher.subscription') }}" class="rounded-xl border border-zinc-200 p-4 transition hover:border-indigo-300 hover:bg-indigo-50 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500">আমার সাবস্ক্রিপশন</p>
                        <p class="mt-1 text-lg font-semibold">Package & Validity</p>
                    </a>
                    <a href="{{ route('teacher.pricing') }}" class="rounded-xl border border-zinc-200 p-4 transition hover:border-indigo-300 hover:bg-indigo-50 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500">প্রাইসিং</p>
                        <p class="mt-1 text-lg font-semibold">Buy Package</p>
                    </a>
                    <a href="{{ route('teacher.earnings') }}" class="rounded-xl border border-zinc-200 p-4 transition hover:border-indigo-300 hover:bg-indigo-50 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500">আমার উপার্জন</p>
                        <p class="mt-1 text-lg font-semibold">Earnings Summary</p>
                    </a>
                    <a href="{{ route('teacher.wallet') }}" class="rounded-xl border border-zinc-200 p-4 transition hover:border-indigo-300 hover:bg-indigo-50 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500">রিচার্জ / উইথড্র</p>
                        <p class="mt-1 text-lg font-semibold">Wallet & Report</p>
                    </a>
                </div>
            </section>
        @endif

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
