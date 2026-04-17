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
                            class="flex items-center justify-between cursor-pointer gap-3 rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-left transition hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60"
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
                            class="flex items-center justify-between gap-3 rounded-xl border cursor-pointer border-zinc-200 bg-zinc-50 px-4 py-3 text-left transition hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60"
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
                        <button
                            type="button"
                            wire:click="openChapter({{ $chapter->id }})"
                            class="flex items-center justify-between gap-3 rounded-xl cursor-pointer border border-zinc-200 bg-zinc-50 px-4 py-3 text-left transition hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60"
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
                        </button>
                    @endforeach
                </div>
            @endif
        @endif

        @if($level === 'questions')
            <div class="flex items-center gap-3">
                <button type="button" wire:click="back" class="rounded-md p-1 text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    <flux:icon.arrow-left class="size-5" />
                </button>
                <h3 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $selectedChapterName }}</h3>
            </div>

            @if($latestQuestions->isEmpty())
                <div class="rounded-lg border border-dashed border-zinc-300 p-5 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                    {{ __('এই চ্যাপ্টারে এখনো কোনো MCQ পাওয়া যায়নি।') }}
                </div>
            @else
                @php($labels = ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ'])
                <div class="space-y-4">
                    @foreach($latestQuestions as $question)
                        @php($options = collect($question->extra_content ?? [])->take(4))
                        @php($questionTitle = preg_replace('/^\s*<p>(.*)<\/p>\s*$/is', '$1', html_entity_decode($question->title ?? '')) ?? html_entity_decode($question->title ?? ''))
                        <article class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800/70">
                            <h5 class="text-lg font-bold text-zinc-900 dark:text-zinc-100" data-math-content>{!! $loop->iteration . '. ' . $questionTitle !!}</h5>

                            <div class="mt-2 flex flex-wrap gap-া2 text-xs">
                                <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->academicClass?->name }}</span>
                                <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->subject?->name }}</span>
                                <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->chapter?->name }}</span>
                                <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ strtoupper($question->difficulty) }}</span>
                            </div>

                            <div class="mt-3 grid grid-cols-1 gap-2 md:grid-cols-2">
                                @foreach($options as $index => $option)
                                    <div class="flex items-center gap-2 rounded-lg border px-3 py-2 {{ !empty($option['is_correct']) ? 'border-emerald-300 bg-emerald-50 dark:border-emerald-600 dark:bg-emerald-900/20' : 'border-zinc-200 bg-white dark:border-zinc-600 dark:bg-zinc-800' }}">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full border text-xs font-semibold {{ !empty($option['is_correct']) ? 'border-emerald-500 bg-emerald-500 text-white' : 'border-zinc-300 text-zinc-700 dark:border-zinc-600 dark:text-zinc-200' }}">{{ $labels[$index] ?? $index + 1 }}</span>
                                        @php($optionText = preg_replace('/^\s*<p>(.*)<\/p>\s*$/is', '$1', html_entity_decode($option['option_text'] ?? '')) ?? html_entity_decode($option['option_text'] ?? ''))
                                        <span class="text-sm text-zinc-800 dark:text-zinc-100" data-math-content>{!! $optionText !!}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div x-data="{ openDescription: false }" class="mt-3 space-y-3">
                                <div class="flex items-center justify-between">
                                    <button
                                        type="button"
                                        @click="openDescription = !openDescription"
                                        class="inline-flex items-center gap-1 text-sm font-semibold text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200"
                                    >
                                        <span>DES</span>
                                        <flux:icon.chevron-down class="size-4 transition" x-bind:class="openDescription ? 'rotate-180' : ''" />
                                    </button>

                                    <div class="flex items-center gap-4 text-sm text-zinc-500 dark:text-zinc-400">
                                        <span class="inline-flex items-center gap-1"><flux:icon.eye class="size-4" />{{ $question->views }}</span>
                                        <span class="inline-flex items-center gap-1"><flux:icon.calendar-days class="size-4" />{{ $question->created_at?->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <div x-show="openDescription" class="rounded-xl border border-dashed border-zinc-300 p-5 dark:border-zinc-600" style="display: none;">
                                    @if(filled($question->description))
                                        <div class="prose prose-sm max-w-none text-zinc-700 dark:prose-invert dark:text-zinc-200">
                                            {!! $question->description !!}
                                        </div>
                                    @else
                                        <div class="space-y-3 text-center">
                                            <flux:icon.sparkles class="mx-auto size-6 text-violet-500" />
                                            <p class="font-semibold text-zinc-600 dark:text-zinc-300">{{ __('No explanation yet') }}</p>
                                            <button type="button" class="rounded-full bg-violet-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-violet-700">
                                                ✨ AI Generate
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</div>
