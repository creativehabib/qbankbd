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
        @if($level === 'classes')
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Select Topics for Practice') }}</h2>

            @if($classes->isEmpty())
                <div class="rounded-lg border border-dashed border-zinc-300 p-5 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                    {{ __('কোনো শ্রেণি পাওয়া যায়নি।') }}
                </div>
            @else
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                    @foreach($classes as $class)
                        <button
                            type="button"
                            wire:click="openClass({{ $class->id }})"
                            class="flex items-center justify-between gap-3 rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-left transition hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60"
                        >
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                    <flux:icon.folder class="size-5" />
                                </div>
                                <div>
                                    <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">{{ $class->name }}</p>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">0/{{ $class->mcq_questions_count }} MCQ</p>
                                </div>
                            </div>

                            <flux:icon.chevron-right class="size-5 text-zinc-400" />
                        </button>
                    @endforeach
                </div>
            @endif
        @endif

        @if($level === 'subjects')
            <div class="flex items-center gap-3">
                <button type="button" wire:click="back" class="rounded-md p-1 text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    <flux:icon.arrow-left class="size-5" />
                </button>
                <h3 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $selectedClassName }}</h3>
            </div>

            @if($subjects->isEmpty())
                <div class="rounded-lg border border-dashed border-zinc-300 p-5 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                    {{ __('এই শ্রেণিতে কোনো সাবজেক্ট পাওয়া যায়নি।') }}
                </div>
            @else
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                    @foreach($subjects as $subject)
                        <button
                            type="button"
                            wire:click="openSubject({{ $subject->id }})"
                            class="flex items-center justify-between gap-3 rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-left transition hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60"
                        >
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                    <flux:icon.folder class="size-5" />
                                </div>
                                <div>
                                    <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">{{ $subject->name }}</p>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">0/{{ $subject->mcq_questions_count }} MCQ</p>
                                </div>
                            </div>

                            <flux:icon.chevron-right class="size-5 text-zinc-400" />
                        </button>
                    @endforeach
                </div>
            @endif
        @endif

        @if($level === 'chapters')
            <div class="flex items-center gap-3">
                <button type="button" wire:click="back" class="rounded-md p-1 text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    <flux:icon.arrow-left class="size-5" />
                </button>
                <h3 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $selectedSubjectName }}</h3>
            </div>

            @if($chapters->isEmpty())
                <div class="rounded-lg border border-dashed border-zinc-300 p-5 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                    {{ __('এই সাবজেক্টে কোনো চ্যাপ্টার পাওয়া যায়নি।') }}
                </div>
            @else
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                    @foreach($chapters as $chapter)
                        <a
                            href="{{ route('questions.index', ['subject' => $selectedSubjectId, 'chapter' => $chapter->id]) }}"
                            class="flex items-center justify-between gap-3 rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 transition hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60"
                        >
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                    <flux:icon.folder class="size-5" />
                                </div>
                                <div>
                                    <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">{{ $chapter->name }}</p>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">0/{{ $chapter->mcq_questions_count }} MCQ</p>
                                </div>
                            </div>

                            <flux:icon.chevron-right class="size-5 text-zinc-400" />
                        </a>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</div>
