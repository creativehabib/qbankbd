<div class="flex flex-col lg:flex-row gap-6">

    <!-- বাম সাইড: মূল কন্টেন্ট -->
    <div class="flex-1 min-w-0">
        <div
            x-data
            @keydown.escape.window="if(document.activeElement.tagName !== 'INPUT') Livewire.dispatch('back')"
            class="space-y-5 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 relative"
        >
            <!-- লোডিং ওভারলে -->
            <div wire:loading class="absolute inset-0 z-10 flex items-center justify-center rounded-xl bg-white/60 backdrop-blur-sm dark:bg-zinc-900/60">
                <div class="flex flex-col items-center gap-2">
                    <flux:icon.arrow-path class="size-8 animate-spin text-emerald-600" />
                    <span class="text-xs font-medium text-zinc-600 dark:text-zinc-300">লোড হচ্ছে...</span>
                </div>
            </div>
            <!-- Tabs -->
            <div class="border-b border-zinc-200 dark:border-zinc-700">
                <div class="grid grid-cols-2">
                    <button type="button" wire:click="$set('activeTab', 'fast')" class="border-b-2 px-4 py-3 text-base font-semibold transition {{ $activeTab === 'fast' ? 'border-emerald-600 text-zinc-900 dark:text-zinc-100' : 'border-transparent text-zinc-400 hover:text-zinc-600 dark:text-zinc-500' }}">
                        {{ __('Fast Practice') }}
                    </button>
                    <button type="button" wire:click="$set('activeTab', 'mock')" class="border-b-2 px-4 py-3 text-base font-semibold transition {{ $activeTab === 'mock' ? 'border-emerald-600 text-zinc-900 dark:text-zinc-100' : 'border-transparent text-zinc-400 hover:text-zinc-600 dark:text-zinc-500' }}">
                        {{ __('Mock Test') }}
                    </button>
                </div>
            </div>

            <div class="space-y-4">
                @if($activeTab === 'mock')
                    <div class="flex flex-col items-center justify-center py-10 text-center">
                        <flux:icon.clock class="mb-3 size-12 text-zinc-300 dark:text-zinc-600" />
                        <p class="text-lg font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Coming Soon') }}</p>
                    </div>
                @else

                    <!-- লাইভ ফিল্টার ভিউ -->
                    @if($level === 'filtered-questions')
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">
                                    ফিল্টার করা প্রশ্নসমূহ
                                    <span class="text-sm font-normal text-zinc-400">({{ $filteredQuestions->total() }} টি)</span>
                                </h2>
                                <button
                                    type="button"
                                    onclick="confirmDeleteAction(() => @this.resetFilter(), {
                                        title: 'ফিল্টার মুছুন?',
                                        text: 'ফিল্টার মুছে মূল চ্যাপ্টারে ফিরে যাবেন।',
                                        confirmButtonText: 'হ্যাঁ, মুছুন',
                                        confirmButtonColor: '#ef4444'
                                    })"
                                    class="text-sm font-medium text-red-500 hover:text-red-700 flex items-center gap-1"
                                >
                                    <flux:icon.x-mark class="size-4" /> মুছুন
                                </button>
                            </div>

                            <!-- অ্যাক্টিভ ফিল্টার পিলস -->
                            <div class="flex flex-wrap gap-2">
                                @foreach($filterQuestionTypes as $type)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                        {{ strtoupper($type) }}
                                    </span>
                                @endforeach
                                @foreach($filterClasses as $id)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                                        {{ $filterOptions['classes'][$id] ?? '' }}
                                    </span>
                                @endforeach
                                @foreach($filterSubjects as $id)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-violet-100 px-3 py-1 text-xs font-semibold text-violet-700 dark:bg-violet-500/20 dark:text-violet-300">
                                        {{ $filterOptions['subjects'][$id] ?? '' }}
                                    </span>
                                @endforeach
                                @foreach($filterTeachers as $id)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">
                                        {{ $filterOptions['teachers'][$id] ?? '' }}
                                    </span>
                                @endforeach
                                @if(filled($filterSearch))
                                    <span class="inline-flex items-center gap-1 rounded-full bg-zinc-200 px-3 py-1 text-xs font-semibold text-zinc-700 dark:bg-zinc-700 dark:text-zinc-200">
                                        "{{ $filterSearch }}"
                                    </span>
                                @endif
                            </div>

                            @if($filteredQuestions->isEmpty())
                                <div class="rounded-lg border border-dashed border-zinc-300 p-8 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                                    <flux:icon.folder-open class="mx-auto mb-2 size-8 text-zinc-300 dark:text-zinc-600" />
                                    {{ __('এই ফিল্টার অনুযায়ী কোনো প্রশ্ন পাওয়া যায়নি।') }}
                                </div>
                            @else
                                @php($labels = ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ'])
                                <div class="space-y-4">
                                    @foreach($filteredQuestions as $question)
                                        @php($options = collect($question->extra_content ?? [])->take(4))
                                        @php($questionTitle = preg_replace('/^\s*<p>(.*)<\/p>\s*$/is', '$1', html_entity_decode($question->title ?? '')) ?? html_entity_decode($question->title ?? ''))
                                        <article class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800/70">
                                            <h5 class="text-lg font-bold text-zinc-900 dark:text-zinc-100" data-math-content>{!! $loop->iteration . '. ' . $questionTitle !!}</h5>
                                            <div class="mt-2 flex flex-wrap gap-2 text-xs">
                                                <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->academicClass?->name }}</span>
                                                <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->subject?->name }}</span>
                                                <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ strtoupper($question->question_type) }}</span>
                                            </div>
                                            <div class="mt-3 grid grid-cols-1 gap-2 md:grid-cols-2">
                                                @foreach($options as $index => $option)
                                                    <div class="flex items-center gap-2 rounded-lg border px-3 py-2 {{ !empty($option['is_correct']) ? 'border-emerald-300 bg-emerald-50 dark:border-emerald-600 dark:bg-emerald-900/20' : 'border-zinc-200 bg-white dark:border-zinc-600 dark:bg-zinc-800' }}">
                                                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border text-xs font-semibold {{ !empty($option['is_correct']) ? 'border-emerald-500 bg-emerald-500 text-white' : 'border-zinc-300 text-zinc-700 dark:border-zinc-600 dark:text-zinc-200' }}">{{ $labels[$index] ?? $index + 1 }}</span>
                                                        <span class="text-sm text-zinc-800 dark:text-zinc-100" data-math-content>{!! html_entity_decode($option['option_text'] ?? '') !!}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                                <div class="pt-2">{{ $filteredQuestions->links() }}</div>
                            @endif
                        </div>

                    @else
                        <!-- ড্রিল-ডাউন কন্টেন্ট -->
                        @if($level === 'classes')
                            <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Select Topics for Practice') }}</h2>
                            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                @foreach($classes as $class)
                                    <button type="button" wire:click="openClass({{ $class->id }})" class="flex items-center justify-between cursor-pointer gap-3 rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-left transition hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300"><flux:icon.folder class="size-5" /></div>
                                            <div>
                                                <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">{{ $class->name }}</p>
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $class->mcq_questions_count }} MCQ</p>
                                            </div>
                                        </div>
                                        <flux:icon.chevron-right class="size-5 shrink-0 text-zinc-400" />
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        @if($level !== 'classes')
                            <div class="flex items-center gap-2 text-sm">
                                <button type="button" wire:click="back" class="rounded-md p-1 text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-800" title="Back (Esc)"><flux:icon.arrow-left class="size-5" /></button>
                                <div class="flex flex-wrap items-center gap-1.5 text-zinc-500 dark:text-zinc-400">
                                    @if($selectedClassName)
                                        <span class="cursor-pointer font-medium text-zinc-700 hover:text-emerald-600 dark:text-zinc-200 dark:hover:text-emerald-400" wire:click="$set('level', 'classes'); $set('selectedClassId', null); $set('selectedSubjectId', null); $set('selectedChapterId', null);">{{ $selectedClassName }}</span>
                                    @endif
                                    @if($selectedSubjectName)
                                        <flux:icon.chevron-right class="size-3.5 text-zinc-400" />
                                        <span class="cursor-pointer font-medium text-zinc-700 hover:text-emerald-600 dark:text-zinc-200 dark:hover:text-emerald-400" @if($level === 'chapters' || $level === 'questions') wire:click="$set('level', 'subjects'); $set('selectedSubjectId', null); $set('selectedChapterId', null);" @endif>{{ $selectedSubjectName }}</span>
                                    @endif
                                    @if($selectedChapterName)
                                        <flux:icon.chevron-right class="size-3.5 text-zinc-400" />
                                        <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $selectedChapterName }}</span>
                                    @endif
                                </div>
                            </div>

                            @if($level === 'subjects' || $level === 'chapters')
                                <div class="relative">
                                    <flux:icon.magnifying-glass class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-zinc-400" />
                                    <input type="text" wire:model.live.debounce.150ms="search" placeholder="খুঁজুন..." class="w-full rounded-lg border border-zinc-200 bg-zinc-50 py-2.5 pl-10 pr-4 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100" />
                                </div>
                            @endif

                            @if($level === 'subjects')
                                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                    @foreach($subjects as $subject)
                                        <button type="button" wire:click="openSubject({{ $subject->id }})" class="flex items-center justify-between gap-3 rounded-xl border cursor-pointer border-zinc-200 bg-zinc-50 px-4 py-3 text-left transition hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300"><flux:icon.book-open class="size-5" /></div>
                                                <div>
                                                    <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">{{ $subject->name }}</p>
                                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $subject->mcq_questions_count }} MCQ</p>
                                                </div>
                                            </div>
                                            <flux:icon.chevron-right class="size-5 shrink-0 text-zinc-400" />
                                        </button>
                                    @endforeach
                                </div>
                            @endif

                            @if($level === 'chapters')
                                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                    @foreach($chapters as $chapter)
                                        <button type="button" wire:click="openChapter({{ $chapter->id }})" class="group flex items-center justify-between gap-3 rounded-xl cursor-pointer border border-zinc-200 bg-zinc-50 px-4 py-3 text-left transition hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300"><flux:icon.document-text class="size-5" /></div>
                                                <div>
                                                    <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">{{ $chapter->name }}</p>
                                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $chapter->mcq_questions_count }} MCQ</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white opacity-0 transition group-hover:opacity-100 dark:bg-emerald-500"><flux:icon.play class="size-3.5" /> Start</div>
                                        </button>
                                    @endforeach
                                </div>
                            @endif

                            @if($level === 'questions')
                                @if($latestQuestions->isEmpty())
                                    <div class="rounded-lg border border-dashed border-zinc-300 p-8 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                                        <flux:icon.folder-open class="mx-auto mb-2 size-8 text-zinc-300 dark:text-zinc-600" />
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
                                                <div class="mt-2 flex flex-wrap gap-2 text-xs">
                                                    <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->academicClass?->name }}</span>
                                                    <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->subject?->name }}</span>
                                                    <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ strtoupper($question->difficulty) }}</span>
                                                </div>
                                                <div class="mt-3 grid grid-cols-1 gap-2 md:grid-cols-2">
                                                    @foreach($options as $index => $option)
                                                        <div class="flex items-center gap-2 rounded-lg border px-3 py-2 {{ !empty($option['is_correct']) ? 'border-emerald-300 bg-emerald-50 dark:border-emerald-600 dark:bg-emerald-900/20' : 'border-zinc-200 bg-white dark:border-zinc-600 dark:bg-zinc-800' }}">
                                                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border text-xs font-semibold {{ !empty($option['is_correct']) ? 'border-emerald-500 bg-emerald-500 text-white' : 'border-zinc-300 text-zinc-700 dark:border-zinc-600 dark:text-zinc-200' }}">{{ $labels[$index] ?? $index + 1 }}</span>
                                                            @php($optionText = preg_replace('/^\s*<p>(.*)<\/p>\s*$/is', '$1', html_entity_decode($option['option_text'] ?? '')) ?? html_entity_decode($option['option_text'] ?? ''))
                                                            <span class="text-sm text-zinc-800 dark:text-zinc-100" data-math-content>{!! $optionText !!}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div x-data="{ openDescription: false }" class="mt-3 space-y-3">
                                                    <div class="flex items-center justify-between">
                                                        <button type="button" @click="openDescription = !openDescription" class="inline-flex items-center gap-1 text-sm font-semibold text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">
                                                            <span>Explanation</span>
                                                            <flux:icon.chevron-down class="size-4 transition" x-bind:class="openDescription ? 'rotate-180' : ''" />
                                                        </button>
                                                        <div class="flex items-center gap-4 text-sm text-zinc-500 dark:text-zinc-400">
                                                            <span class="inline-flex items-center gap-1"><flux:icon.eye class="size-4" />{{ $question->views }}</span>
                                                            <span class="inline-flex items-center gap-1"><flux:icon.calendar-days class="size-4" />{{ $question->created_at?->format('d M Y') }}</span>
                                                        </div>
                                                    </div>
                                                    <div x-show="openDescription" x-cloak class="rounded-xl border border-dashed border-zinc-300 p-5 dark:border-zinc-600">
                                                        @if(filled($question->description))
                                                            <div class="prose prose-sm max-w-none text-zinc-700 dark:prose-invert dark:text-zinc-200" data-math-content>{!! $question->description !!}</div>
                                                        @else
                                                            <div class="space-y-3 text-center">
                                                                <flux:icon.sparkles class="mx-auto size-6 text-violet-500" />
                                                                <p class="font-semibold text-zinc-600 dark:text-zinc-300">{{ __('No explanation yet') }}</p>
                                                                <button type="button" class="rounded-full bg-violet-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-violet-700">✨ AI Generate</button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
                                    <div class="pt-2">{{ $latestQuestions->links() }}</div>
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- ডান সাইড: ফিল্টার সাইডবার -->
    @if($level === 'questions' || $level === 'filtered-questions')
        <div class="w-full lg:w-80 shrink-0">
            <div class="rounded-xl border p-5 shadow-sm sticky top-6 transition-colors duration-300 dark:bg-zinc-900 {{ $level === 'filtered-questions' ? 'bg-emerald-50/50 border-emerald-300 dark:border-emerald-700' : 'bg-white border-zinc-200 dark:border-zinc-700' }}">

                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">ফিল্টার</h3>
                    @if($level === 'filtered-questions')
                        <span class="flex h-2.5 w-2.5 relative"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span></span>
                    @endif
                </div>

                <div class="relative mb-5">
                    <flux:icon.magnifying-glass class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-zinc-400" />
                    <input type="text" wire:model.live.debounce.250ms="filterSearch" placeholder="প্রশ্ন লিখে খুঁজুন..." class="w-full rounded-lg border border-zinc-200 bg-zinc-50 py-2.5 pl-10 pr-4 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100" />
                </div>

                <div class="max-h-[calc(100vh-320px)] space-y-5 overflow-y-auto pr-1">
                    <!-- প্রশ্নের ধরন -->
                    <div x-data="{ open: true }">
                        <button @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                            প্রশ্নের ধরন
                            <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="open ? 'rotate-180' : ''" />
                        </button>
                        <div x-show="open" x-collapse x-cloak class="mt-3 space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" value="mcq" wire:model.live="filterQuestionTypes" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600" />
                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-zinc-100 transition">বহুনির্বাচনী (MCQ)</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" value="cq" wire:model.live="filterQuestionTypes" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600" />
                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-zinc-100 transition">রচনামূলক (CQ)</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" value="mcq+cq" wire:model.live="filterQuestionTypes" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600" />
                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-zinc-100 transition">MCQ + CQ</span>
                            </label>
                        </div>
                    </div>

                    <hr class="border-zinc-200 dark:border-zinc-700">

                    <!-- শ্রেণি -->
                    <div x-data="{ open: true }">
                        <button @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                            শ্রেণি নির্বাচন
                            <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="open ? 'rotate-180' : ''" />
                        </button>
                        <div x-show="open" x-collapse x-cloak class="mt-3 space-y-3 max-h-40 overflow-y-auto pr-1">
                            @foreach($filterOptions['classes'] as $id => $name)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" value="{{ $id }}" wire:model.live="filterClasses" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600" />
                                    <span class="text-sm text-zinc-600 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-zinc-100 transition">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-zinc-200 dark:border-zinc-700">

                    <!-- বিষয় -->
                    <div x-data="{ open: true }">
                        <button @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                            বিষয় নির্বাচন
                            <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="open ? 'rotate-180' : ''" />
                        </button>
                        <div x-show="open" x-collapse x-cloak class="mt-3 space-y-3 max-h-40 overflow-y-auto pr-1">
                            @foreach($filterOptions['subjects'] as $id => $name)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" value="{{ $id }}" wire:model.live="filterSubjects" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600" />
                                    <span class="text-sm text-zinc-600 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-zinc-100 transition">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-zinc-200 dark:border-zinc-700">

                    <!-- শিক্ষক -->
                    <div x-data="{ open: true }">
                        <button @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                            শিক্ষক নির্বাচন
                            <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="open ? 'rotate-180' : ''" />
                        </button>
                        <div x-show="open" x-collapse x-cloak class="mt-3 space-y-3 max-h-40 overflow-y-auto pr-1">
                            @foreach($filterOptions['teachers'] as $id => $name)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" value="{{ $id }}" wire:model.live="filterTeachers" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600" />
                                    <span class="text-sm text-zinc-600 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-zinc-100 transition">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- রিসেট বাটন -->
                <div class="mt-6 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                    <button
                        type="button"
                        onclick="confirmDeleteAction(() => @this.resetFilter(), {
                            title: 'ফিল্টার মুছুন?',
                            text: 'ফিল্টার মুছে মূল চ্যাপ্টারে ফিরে যাবেন।',
                            confirmButtonText: 'হ্যাঁ, মুছুন',
                            confirmButtonColor: '#10b981'
                        })"
                        class="w-full flex items-center justify-center gap-2 rounded-lg border border-zinc-300 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 hover:bg-zinc-100 transition dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700"
                    >
                        <flux:icon.arrow-path class="size-4" />
                        সব ফিল্টার মুছুন
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
