<div class="space-y-5 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
    <div class="border-b border-zinc-200 dark:border-zinc-700">
        <div class="grid grid-cols-2">
            <button type="button" class="border-b-2 border-emerald-600 px-4 py-3 text-base font-semibold text-zinc-900 dark:text-zinc-100">
                {{ __('Fast Practice') }}
            </button>
            <button type="button" class="px-4 py-3 text-base font-semibold text-zinc-400 dark:text-zinc-500">
                {{ __('Mock Test') }}
            </button>
        </div>
    </div>

    <div class="space-y-4">
        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Select Topics for Practice') }}</h2>

        @if($subjects->isEmpty())
            <div class="rounded-lg border border-dashed border-zinc-300 p-8 text-center text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                {{ __('এখনো কোনো ক্যাটাগরি পাওয়া যায়নি।') }}
            </div>
        @else
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                @foreach($subjects as $subject)
                    <a
                        href="{{ route('questions.index', ['subject' => $subject->id]) }}"
                        class="flex items-center justify-between gap-3 rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 transition hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60 dark:hover:bg-zinc-800"
                    >
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                <flux:icon.book-open-text class="size-5" />
                            </div>

                            <div>
                                <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">{{ $subject->name }}</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">0/{{ $subject->mcq_questions_count }} MCQ</p>
                            </div>
                        </div>

                        <flux:icon.chevron-right class="size-5 text-zinc-400" />
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
