<div x-data="{ filterOpen: false }" @keydown.escape.window="if(filterOpen) { filterOpen = false; } else if(document.activeElement.tagName !== 'INPUT') Livewire.dispatch('back')" class="relative flex flex-col lg:flex-row gap-5 lg:gap-6">

    <div class="w-full min-w-0 lg:flex-1">
        <div class="space-y-5 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 relative">

            <div wire:loading.remove="hidden" class="hidden absolute inset-0 z-10 flex items-center justify-center rounded-xl bg-white/60 backdrop-blur-sm dark:bg-zinc-900/60">
                <div class="flex flex-col items-center gap-2">
                    <flux:icon.arrow-path class="size-8 animate-spin text-emerald-600" />
                    <span class="text-xs font-medium text-zinc-600 dark:text-zinc-300">লোড হচ্ছে...</span>
                </div>
            </div>

            <div class="border-b border-zinc-200 dark:border-zinc-700">
                <div class="grid grid-cols-2">
                    <button type="button" wire:click="$set('activeTab', 'fast')" class="border-b-2 px-4 py-3 text-base font-semibold cursor-pointer {{ $activeTab === 'fast' ? 'border-emerald-600 text-zinc-900 dark:text-zinc-100' : 'border-transparent text-zinc-400 hover:text-zinc-600 dark:text-zinc-500' }}">
                        {{ __('দ্রুত অনুশীলন') }}
                    </button>
                    <button type="button" wire:click="$set('activeTab', 'mock')" class="border-b-2 px-4 py-3 text-base font-semibold cursor-pointer {{ $activeTab === 'mock' ? 'border-emerald-600 text-zinc-900 dark:text-zinc-100' : 'border-transparent text-zinc-400 hover:text-zinc-600 dark:text-zinc-500' }}">
                        {{ __('Mock Test') }}
                    </button>
                </div>
            </div>

            <div class="space-y-4">
                @if($activeTab === 'mock')
                    <div class="space-y-6 py-4">
                        <div class="text-center">
                            <flux:icon.academic-cap class="mx-auto mb-3 size-12 text-emerald-500" />
                            <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ __('মক টেস্ট শুরু করুন') }}</h2>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('নিচের অপশনগুলো থেকে আপনার পছন্দমতো বিষয় নির্বাচন করে নিজেকে যাচাই করুন।') }}</p>
                        </div>

                        <div class="mx-auto max-w-lg space-y-5 rounded-xl border border-zinc-200 bg-zinc-50 p-6 dark:border-zinc-700 dark:bg-zinc-800/50">

                            <div class="space-y-2">
                                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('শ্রেণি নির্বাচন করুন') }} <span class="text-red-500">*</span></label>
                                <select wire:model.live="selectedClassId" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-zinc-600 dark:bg-zinc-900 dark:text-zinc-100">
                                    <option value="">{{ __('নির্বাচন করুন') }}</option>
                                    @foreach($filterOptions['classes'] as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if($selectedClassId)
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('বিষয় নির্বাচন করুন') }} <span class="text-red-500">*</span></label>
                                    <select wire:model.live="selectedSubjectId" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-zinc-600 dark:bg-zinc-900 dark:text-zinc-100">
                                        <option value="">{{ __('নির্বাচন করুন') }}</option>
                                        @foreach($this->subjects() as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            @if($selectedSubjectId)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 border-t border-zinc-200 pt-5 dark:border-zinc-700">

                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('মোট প্রশ্ন') }}</label>
                                        <select wire:model.live="questionCount" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-zinc-600 dark:bg-zinc-900 dark:text-zinc-100">
                                            <option value="10">১০ টি</option>
                                            <option value="20">২০ টি</option>
                                            <option value="30">৩০ টি</option>
                                            <option value="50">৫০ টি</option>
                                            <option value="100">১০০ টি</option>
                                        </select>
                                    </div>

                                    <div class="space-y-2 flex flex-col justify-center">
                                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('নেগেটিভ মার্কিং') }}</label>
                                        <label class="relative inline-flex cursor-pointer items-center mt-1">
                                            <input type="checkbox" wire:model.live="hasNegativeMark" class="peer sr-only">

                                            <div class="peer h-6 w-11 rounded-full bg-zinc-300 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-zinc-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-500/30 dark:bg-zinc-700 dark:border-zinc-600"></div>

                                            <span class="ml-3 text-xs font-semibold text-zinc-600 dark:text-zinc-400">
                                                {{ $hasNegativeMark ? 'চালু (০.২৫)' : 'বন্ধ' }}
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            @endif

                            <div class="pt-4">
                                <button
                                    type="button"
                                    wire:click="startMockTest"
                                    @if(!$selectedClassId || !$selectedSubjectId) disabled @endif
                                    class="w-full flex justify-center items-center gap-2 rounded-lg bg-emerald-600 px-4 py-3 text-sm font-bold text-white disabled:cursor-not-allowed disabled:opacity-50 hover:bg-emerald-700 shadow-sm"
                                >
                                    <flux:icon.play class="size-5" />
                                    {{ __('মক টেস্ট শুরু করুন') }} {{ $selectedSubjectId ? "($questionCount মিনিট)" : '' }}
                                </button>

                                @if($mockTestError ?? false)
                                    <p class="mt-3 text-center text-sm font-medium text-red-500 dark:text-red-400">
                                        {{ $mockTestError }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @else

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

                            <div class="flex flex-wrap gap-2">
                                @foreach($filterQuestionTypes as $type)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">{{ strtoupper($type) }}</span>
                                @endforeach
                                @foreach($filterClasses as $id)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">{{ $filterOptions['classes'][$id] ?? '' }}</span>
                                @endforeach
                                @foreach($filterSubjects as $id)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-violet-100 px-3 py-1 text-xs font-semibold text-violet-700 dark:bg-violet-500/20 dark:text-violet-300">{{ $filterOptions['subjects'][$id] ?? '' }}</span>
                                @endforeach
                                @foreach($filterTeachers as $id)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">{{ $filterOptions['teachers'][$id] ?? '' }}</span>
                                @endforeach
                                @if(filled($filterSearch))
                                    <span class="inline-flex items-center gap-1 rounded-full bg-zinc-200 px-3 py-1 text-xs font-semibold text-zinc-700 dark:bg-zinc-700 dark:text-zinc-200">"{{ $filterSearch }}"</span>
                                @endif
                            </div>

                            @if($filteredQuestions->isEmpty())
                                <div class="rounded-lg border border-dashed border-zinc-300 p-8 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                                    <flux:icon.folder-open class="mx-auto mb-2 size-8 text-zinc-300 dark:text-zinc-600" />
                                    {{ __('এই ফিল্টার অনুযায়ী কোনো প্রশ্ন পাওয়া যায়নি।') }}
                                </div>
                            @else
                                @php($labels = ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ'])
                                <div class="space-y-4">
                                    @foreach($filteredQuestions as $question)
                                        @php($options = collect($question->extra_content ?? [])->take(4))
                                        @php($questionTitle = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', html_entity_decode($question->title ?? '')) ?? html_entity_decode($question->title ?? ''))
                                        <article class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800/70">

                                            <h5 class="text-lg font-bold text-zinc-900 dark:text-zinc-100" data-math-content>{!! ($filteredQuestions->firstItem() + $loop->index) . '. ' . $questionTitle !!}</h5>

                                            <div class="mt-2 flex flex-wrap gap-2 text-xs">
                                                <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->academicClass?->name }}</span>
                                                <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->subject?->name }}</span>
                                                <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ strtoupper($question->question_type) }}</span>
                                            </div>
                                            <div class="mt-3 grid grid-cols-1 gap-2 md:grid-cols-2">
                                                @foreach($options as $option)
                                                    <div class="flex items-center gap-2 rounded-lg border px-3 py-2 {{ !empty($option['is_correct']) ? 'border-emerald-300 bg-emerald-50 dark:border-emerald-600 dark:bg-emerald-900/20' : 'border-zinc-200 bg-white dark:border-zinc-600 dark:bg-zinc-800' }}">
                                                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border text-xs font-semibold {{ !empty($option['is_correct']) ? 'border-emerald-500 bg-emerald-500 text-white' : 'border-zinc-300 text-zinc-700 dark:border-zinc-600 dark:text-zinc-200' }}">{{ $labels[$loop->index] ?? $loop->index + 1 }}</span>
                                                        @php($optionText = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', html_entity_decode($option['option_text'] ?? '')) ?? html_entity_decode($option['option_text'] ?? ''))
                                                        <span class="text-sm text-zinc-800 dark:text-zinc-100" data-math-content>{!! $optionText !!}</span>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div x-data="{ openDescription: false }" class="mt-4 border-t border-zinc-200/60 pt-3 dark:border-zinc-700/60 space-y-3">
                                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                                                    <button type="button" x-on:click="openDescription = !openDescription" wire:click.once="recordView({{ $question->id }})" class="inline-flex w-fit items-center gap-1 text-sm font-semibold text-zinc-500 hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400 transition">
                                                        <span>Explanation</span>
                                                        <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="openDescription ? 'rotate-180' : ''" />
                                                    </button>

                                                    <div class="flex items-center gap-4 text-zinc-400 dark:text-zinc-500">
                                                        <div class="flex items-center gap-1.5" title="Views">
                                                            <flux:icon.eye class="size-[18px]" />
                                                            <span class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">{{ $question->views_count ?? 0 }}</span>
                                                        </div>
                                                        <button type="button" class="cursor-pointer hover:text-emerald-600 dark:hover:text-emerald-400" title="Statistics">
                                                            <flux:icon.chart-pie class="size-[18px]" />
                                                        </button>
                                                        <button type="button" wire:click="toggleBookmark({{ $question->id }})" class="cursor-pointer {{ $question->is_bookmarked ? 'text-emerald-600 dark:text-emerald-400' : 'hover:text-emerald-600 dark:hover:text-emerald-400' }}" title="{{ $question->is_bookmarked ? 'Remove Bookmark' : 'Save Bookmark' }}">
                                                            <flux:icon.bookmark class="size-[18px]" variant="{{ $question->is_bookmarked ? 'solid' : 'outline' }}" />
                                                        </button>
                                                        <button type="button" wire:click="toggleLike({{ $question->id }})" class="flex items-center gap-1 cursor-pointer {{ $question->is_liked ? 'text-pink-500' : 'hover:text-pink-500' }}" title="{{ $question->is_liked ? 'Unlike' : 'Like' }}">
                                                            <flux:icon.heart class="size-[18px]" variant="{{ $question->is_liked ? 'solid' : 'outline' }}" />
                                                            @if($question->likes_count > 0)
                                                                <span class="text-xs font-medium">{{ $question->likes_count }}</span>
                                                            @endif
                                                        </button>
                                                        <button type="button" @click="$dispatch('open-report-modal', { id: {{ $question->id }} })" class="cursor-pointer hover:text-red-500 dark:hover:text-red-400" title="Report Error">
                                                            <flux:icon.flag class="size-[18px]" />
                                                        </button>
                                                        <button type="button" class="cursor-pointer hover:text-blue-500 dark:hover:text-blue-400" title="Share">
                                                            <flux:icon.share class="size-[18px]" />
                                                        </button>
                                                    </div>
                                                </div>

                                                <div x-show="openDescription" x-collapse x-cloak class="rounded-xl border border-dashed border-zinc-300 p-5 dark:border-zinc-600 mt-3">
                                                    @if(filled($question->description))
                                                        <div class="prose prose-sm tex2jax_process max-w-none text-zinc-700 dark:prose-invert dark:text-zinc-200" data-math-content>{!! $question->description !!}</div>
                                                    @else
                                                        <div class="space-y-3 text-center">
                                                            <flux:icon.sparkles class="mx-auto size-6 text-violet-500" />
                                                            <p class="font-semibold text-zinc-600 dark:text-zinc-300">{{ __('No explanation yet') }}</p>
                                                            <button type="button" class="rounded-full bg-violet-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-violet-700 shadow-sm">✨ AI Generate</button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                                <div class="pt-2">{{ $filteredQuestions->links() }}</div>
                            @endif
                        </div>

                    @else
                        @if($level === 'classes')
                            <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Select Topics for Practice') }}</h2>
                            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                @foreach($classes as $class)
                                    <button type="button" wire:click="openClass({{ $class->id }})" class="flex items-center justify-between cursor-pointer gap-3 rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-left hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60">
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
                                        @if($level === 'chapters' || ($level === 'questions' && $selectedChapterId))
                                            <span class="cursor-pointer font-medium text-zinc-700 hover:text-emerald-600 dark:text-zinc-200 dark:hover:text-emerald-400" wire:click="$set('level', 'subjects'); $set('selectedSubjectId', null); $set('selectedChapterId', null);">{{ $selectedSubjectName }}</span>
                                        @else
                                            <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $selectedSubjectName }}</span>
                                        @endif
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
                                    <input type="text" wire:model.live.debounce.150ms="search" placeholder="খুঁজুন..." class="w-full rounded-lg border border-zinc-200 bg-zinc-50 py-2.5 pl-10 pr-4 text-sm text-zinc-900 outline-none placeholder:text-zinc-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100" />
                                </div>
                            @endif

                            @if($level === 'subjects')
                                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                    @foreach($subjects as $subject)
                                        <div class="group flex items-center justify-between gap-3 rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60">

                                            <div wire:click="openSubject({{ $subject->id }})" class="flex flex-1 items-center gap-3 cursor-pointer">
                                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300"><flux:icon.book-open class="size-5" /></div>
                                                <div>
                                                    <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">{{ $subject->name }}</p>
                                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $subject->mcq_questions_count }} MCQ</p>
                                                </div>
                                            </div>

                                            <div class="flex shrink-0 items-center">
                                                <button type="button" wire:click="startSubjectPractice({{ $subject->id }})" class="hidden items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 group-hover:flex dark:bg-emerald-500 dark:hover:bg-emerald-600">
                                                    <flux:icon.play class="size-3.5" /> Start
                                                </button>
                                                <flux:icon.chevron-right class="size-5 text-zinc-400 group-hover:hidden" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if($level === 'chapters')
                                @if($chapters->isEmpty())
                                    <div class="rounded-lg border border-dashed border-zinc-300 p-8 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                                        <x-heroicon-o-folder-open class="mx-auto mb-2 size-8 text-zinc-300 dark:text-zinc-600" />
                                        {{ __('এই বিষয়ে এখনো কোনো চ্যাপ্টার যোগ করা হয়নি। সরাসরি প্রশ্ন দেখতে ব্যাক করে "Start" বাটনে ক্লিক করুন।') }}
                                    </div>
                                @else
                                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                        @foreach($chapters as $chapter)
                                            <button type="button" wire:click="openChapter({{ $chapter->id }})" class="group flex items-center justify-between gap-3 rounded-xl cursor-pointer border border-zinc-200 bg-zinc-50 px-4 py-3 text-left hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-emerald-500/60">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                                        <x-heroicon-o-document-text class="size-5" />
                                                    </div>
                                                    <div>
                                                        <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">{{ $chapter->name }}</p>
                                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $chapter->mcq_questions_count }} MCQ</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white opacity-0 group-hover:opacity-100 dark:bg-emerald-500">
                                                    <x-heroicon-s-play class="size-3.5" /> Start
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            @endif

                            @if($level === 'questions')
                                @if($latestQuestions->isEmpty())
                                    <div class="rounded-lg border border-dashed border-zinc-300 p-8 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                                        <flux:icon.folder-open class="mx-auto mb-2 size-8 text-zinc-300 dark:text-zinc-600" />
                                        {{ __('এই অংশে এখনো কোনো MCQ পাওয়া যায়নি।') }}
                                    </div>
                                @else
                                    @php($labels = ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ'])
                                    <div class="space-y-4">
                                        @foreach($latestQuestions as $question)
                                            @php($options = collect($question->extra_content ?? [])->take(4))
                                            @php($questionTitle = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', html_entity_decode($question->title ?? '')) ?? html_entity_decode($question->title ?? ''))
                                            <article class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800/70">

                                                <h5 class="text-lg text-zinc-900 dark:text-zinc-100" data-math-content>{!! ($latestQuestions->firstItem() + $loop->index) . '. ' . $questionTitle !!}</h5>

                                                <div class="mt-2 flex flex-wrap gap-2 text-xs">
                                                    <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->academicClass?->name }}</span>
                                                    <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->subject?->name }}</span>
                                                    <span class="rounded-full border border-zinc-300 px-2 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ strtoupper($question->difficulty ?? 'MCQ') }}</span>
                                                </div>

                                                <div class="mt-3 grid grid-cols-1 gap-2 md:grid-cols-2">
                                                    @foreach($options as $option)
                                                        <div class="flex items-center gap-2 rounded-lg border px-3 py-2 {{ !empty($option['is_correct']) ? 'border-emerald-300 bg-emerald-50 dark:border-emerald-600 dark:bg-emerald-900/20' : 'border-zinc-200 bg-white dark:border-zinc-600 dark:bg-zinc-800' }}">
                                                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border text-xs font-semibold {{ !empty($option['is_correct']) ? 'border-emerald-500 bg-emerald-500 text-white' : 'border-zinc-300 text-zinc-700 dark:border-zinc-600 dark:text-zinc-200' }}">{{ $labels[$loop->index] ?? $loop->index + 1 }}</span>
                                                            <span class="text-sm text-zinc-800 dark:text-zinc-100" data-math-content>{!! html_entity_decode($option['option_text'] ?? '') !!}</span>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div x-data="{ openDescription: false }" class="mt-4 border-t border-zinc-200/60 pt-3 dark:border-zinc-700/60 space-y-3">
                                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                                                        <button type="button" x-on:click="openDescription = !openDescription" wire:click.once="recordView({{ $question->id }})" class="inline-flex w-fit items-center gap-1 text-sm font-semibold text-zinc-500 hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400">
                                                            <span>Explanation</span>
                                                            <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="openDescription ? 'rotate-180' : ''" />
                                                        </button>

                                                        <div class="flex items-center gap-4 text-zinc-400 dark:text-zinc-500">
                                                            <div class="flex items-center gap-1.5" title="Views">
                                                                <flux:icon.eye class="size-[18px]" />
                                                                <span class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">{{ $question->views_count ?? 0 }}</span>
                                                            </div>
                                                            <button type="button" class="cursor-pointer hover:text-emerald-600 dark:hover:text-emerald-400" title="Statistics">
                                                                <flux:icon.chart-pie class="size-[18px]" />
                                                            </button>
                                                            <button type="button" wire:click="toggleBookmark({{ $question->id }})" class="cursor-pointer {{ $question->is_bookmarked ? 'text-emerald-600 dark:text-emerald-400' : 'hover:text-emerald-600 dark:hover:text-emerald-400' }}" title="{{ $question->is_bookmarked ? 'Remove Bookmark' : 'Save Bookmark' }}">
                                                                <flux:icon.bookmark class="size-[18px]" variant="{{ $question->is_bookmarked ? 'solid' : 'outline' }}" />
                                                            </button>
                                                            <button type="button" wire:click="toggleLike({{ $question->id }})" class="flex items-center gap-1 cursor-pointer {{ $question->is_liked ? 'text-pink-500' : 'hover:text-pink-500' }}" title="{{ $question->is_liked ? 'Unlike' : 'Like' }}">
                                                                <flux:icon.heart class="size-[18px]" variant="{{ $question->is_liked ? 'solid' : 'outline' }}" />
                                                                @if($question->likes_count > 0)
                                                                    <span class="text-xs font-medium">{{ $question->likes_count }}</span>
                                                                @endif
                                                            </button>
                                                            <button type="button" @click="$dispatch('open-report-modal', { id: {{ $question->id }} })" class="cursor-pointer hover:text-red-500 dark:hover:text-red-400" title="Report Error">
                                                                <flux:icon.flag class="size-[18px]" />
                                                            </button>
                                                            <button type="button" class="cursor-pointer hover:text-blue-500 dark:hover:text-blue-400" title="Share">
                                                                <flux:icon.share class="size-[18px]" />
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div x-show="openDescription" x-collapse x-cloak class="rounded-xl border border-dashed border-zinc-300 p-5 dark:border-zinc-600 mt-3">
                                                        @if(filled($question->description))
                                                            <div class="prose prose-sm tex2jax_process max-w-none text-zinc-700 dark:prose-invert dark:text-zinc-200" data-math-content>
                                                                {!! $question->description !!}
                                                            </div>
                                                        @else
                                                            <div class="space-y-3 text-center">
                                                                <div wire:loading.remove wire:target="generateAiExplanation({{ $question->id }})">
                                                                    <flux:icon.sparkles class="mx-auto size-6 text-violet-500" />
                                                                    <p class="font-semibold text-zinc-600 dark:text-zinc-300">{{ __('No explanation yet') }}</p>

                                                                    <button
                                                                        type="button"
                                                                        wire:click.prevent="generateAiExplanation({{ $question->id }})"
                                                                        class="mt-2 inline-flex items-center gap-2 rounded-full bg-violet-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-violet-700 shadow-sm"
                                                                    >
                                                                        <span>✨ AI Generate</span>
                                                                    </button>
                                                                </div>

                                                                <div wire:loading wire:target="generateAiExplanation({{ $question->id }})">
                                                                    <div class="flex flex-col items-center gap-2">
                                                                        <flux:icon.arrow-path class="size-6 animate-spin text-violet-600" />
                                                                        <p class="text-xs font-medium text-violet-600 animate-pulse">AI ব্যাখ্যা তৈরি করছে...</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if($aiError)
                                                            <div class="mt-2 text-center text-[10px] text-red-500 bg-red-50 dark:bg-red-900/20 p-1 rounded">
                                                                {{ $aiError }}
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

    @if($level === 'questions' || $level === 'filtered-questions')

        <button
            @click="filterOpen = !filterOpen"
            class="fixed bottom-6 right-6 z-40 flex lg:hidden h-14 w-14 items-center justify-center rounded-full bg-emerald-600 text-white shadow-xl hover:bg-emerald-700"
        >
            <flux:icon.adjustments-horizontal class="size-6" />
            @if($level === 'filtered-questions')
                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                </span>
            @endif
        </button>

        <div
            x-show="filterOpen"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="filterOpen = false"
            class="fixed lg:hidden inset-0 z-40 bg-black/50"
            style="display:none;"
        ></div>

        <div
            x-show="filterOpen"
            x-transition:enter="transform ease-in-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed lg:hidden top-0 right-0 z-50 h-full w-[320px] shrink-0 overflow-y-auto bg-white dark:bg-zinc-900 shadow-2xl border-l border-zinc-200 dark:border-zinc-700"
            style="display:none;"
        >

            <div class="sticky top-0 z-10 flex items-center justify-between border-b border-zinc-200 bg-white/80 backdrop-blur-md p-4 dark:border-zinc-700 dark:bg-zinc-900/80">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                    <flux:icon.adjustments-horizontal class="size-5 text-emerald-600" />
                    ফিল্টার
                    @if($level === 'filtered-questions')
                        <span class="flex h-2.5 w-2.5 relative"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span></span>
                    @endif
                </h3>
                <button @click="filterOpen = false" class="rounded-md p-1 text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <flux:icon.x-mark class="size-5" />
                </button>
            </div>

            <div class="p-5 {{ $level === 'filtered-questions' ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : 'bg-white dark:bg-zinc-900' }} transition-colors duration-300">

                <div class="relative mb-5">
                    <flux:icon.magnifying-glass class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-zinc-400" />
                    <input type="text" wire:model.live.debounce.250ms="filterSearch" placeholder="প্রশ্ন লিখে খুঁজুন..." class="w-full rounded-lg border border-zinc-200 bg-zinc-50 py-2.5 pl-10 pr-4 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100" />
                </div>

                <div class="max-h-[calc(100vh-320px)] space-y-5 overflow-y-auto pr-1">
                    <div x-data="{ open: true }">
                        <button @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                            প্রশ্নের ধরন
                            <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="open ? 'rotate-180' : ''" />
                        </button>
                        <div x-show="open" x-collapse x-cloak class="mt-3 space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" value="mcq" wire:model.live="filterQuestionTypes" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600" />
                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-zinc-100">বহুনির্বাচনী (MCQ)</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" value="cq" wire:model.live="filterQuestionTypes" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600" />
                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-zinc-100">রচনামূলক (CQ)</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" value="mcq+cq" wire:model.live="filterQuestionTypes" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600" />
                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-zinc-100">MCQ + CQ</span>
                            </label>
                        </div>
                    </div>

                    <hr class="border-zinc-200 dark:border-zinc-700">

                    <div x-data="{ open: true }">
                        <button @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                            শ্রেণি নির্বাচন
                            <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="open ? 'rotate-180' : ''" />
                        </button>
                        <div x-show="open" x-collapse x-cloak class="mt-3 space-y-3 max-h-40 overflow-y-auto pr-1">
                            @foreach($filterOptions['classes'] as $id => $name)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" value="{{ $id }}" wire:model.live="filterClasses" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600" />
                                    <span class="text-sm text-zinc-600 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-zinc-100">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-zinc-200 dark:border-zinc-700">

                    <div x-data="{ open: true }">
                        <button @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                            বিষয় নির্বাচন
                            <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="open ? 'rotate-180' : ''" />
                        </button>
                        <div x-show="open" x-collapse x-cloak class="mt-3 space-y-3 max-h-40 overflow-y-auto pr-1">
                            @foreach($filterOptions['subjects'] as $id => $name)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" value="{{ $id }}" wire:model.live="filterSubjects" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600" />
                                    <span class="text-sm text-zinc-600 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-zinc-100">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-zinc-200 dark:border-zinc-700">

                    <div x-data="{ open: true }">
                        <button @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                            শিক্ষক নির্বাচন
                            <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="open ? 'rotate-180' : ''" />
                        </button>
                        <div x-show="open" x-collapse x-cloak class="mt-3 space-y-3 max-h-40 overflow-y-auto pr-1">
                            @foreach($filterOptions['teachers'] as $id => $name)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" value="{{ $id }}" wire:model.live="filterTeachers" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600" />
                                    <span class="text-sm text-zinc-600 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-zinc-100">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-6 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                    <button
                        type="button"
                        onclick="confirmDeleteAction(() => @this.resetFilter(), {
                            title: 'ফিল্টার মুছুন?',
                            text: 'ফিল্টার মুছে মূল চ্যাপ্টারে ফিরে যাবেন।',
                            confirmButtonText: 'হ্যাঁ, মুছুন',
                            confirmButtonColor: '#10b981'
                        })"
                        class="w-full flex items-center justify-center gap-2 rounded-lg border border-zinc-300 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 hover:bg-zinc-100 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700"
                    >
                        <flux:icon.arrow-path class="size-4" />
                        সব ফিল্টার মুছুন
                    </button>
                </div>
            </div>
        </div>

        <div class="hidden lg:block w-80 shrink-0 h-fit sticky top-5">
            <div class="space-y-5 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                <div class="flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-700">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                        <flux:icon.adjustments-horizontal class="size-5 text-emerald-600" />
                        ফিল্টার
                        @if($level === 'filtered-questions')
                            <span class="flex h-2.5 w-2.5 relative"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span></span>
                        @endif
                    </h3>
                </div>

                <div class="{{ $level === 'filtered-questions' ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : 'bg-white dark:bg-zinc-900' }} transition-colors duration-300 -mx-5 -mb-5 p-5 rounded-b-xl">

                    <div class="relative mb-5">
                        <flux:icon.magnifying-glass class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-zinc-400" />
                        <input type="text" wire:model.live.debounce.250ms="filterSearch" placeholder="প্রশ্ন লিখে খুঁজুন..." class="w-full rounded-lg border border-zinc-200 bg-zinc-50 py-2.5 pl-10 pr-4 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100" />
                    </div>

                    <div class="max-h-[calc(100vh-400px)] space-y-5 overflow-y-auto pr-1">
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

                        <div x-data="{ open: true }">
                            <button @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                                বিষয় নির্বাচন
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

                    <div class="mt-6 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                        <button
                            type="button"
                            onclick="confirmDeleteAction(() => @this.resetFilter(), {
                                title: 'ফিল্টার মুছুন?',
                                text: 'ফিল্টার মুছে মূল চ্যাপ্টারে ফিরে যাবেন।',
                                confirmButtonText: 'হ্যাঁ, মুছুন',
                                transition: 'bg-emerald-600'
                            })"
                            class="w-full flex items-center justify-center gap-2 rounded-lg border border-zinc-300 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 hover:bg-zinc-100 transition dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700"
                        >
                            <flux:icon.arrow-path class="size-4" />
                            সব ফিল্টার মুছুন
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ─── 🚀 ALPINE + FLUX CUSTOM REPORT ERROR MODAL ─── --}}
    <div
        x-data="{
            showModal: false,
            questionId: null,
            reportReason: 'wrong_answer',
            note: ''
        }"
        @open-report-modal.window="showModal = true; questionId = $event.detail.id; reportReason = 'wrong_answer'; note = '';"
        x-show="showModal"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto"
        style="display: none;"
    >
        <div class="fixed inset-0 bg-zinc-950/40 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>

        <div class="relative w-full max-w-md transform rounded-xl border border-zinc-200 bg-white p-6 shadow-xl transition-all dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between border-b border-zinc-100 pb-3 dark:border-zinc-800">
                <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                    <flux:icon.flag class="size-5 text-red-500" />
                    {{ __('প্রশ্নে ভুল রিপোর্ট করুন') }}
                </h3>
                <button @click="showModal = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">✕</button>
            </div>

            <div class="mt-4 space-y-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('ভুলের ধরণ নির্বাচন করুন') }}</label>
                    <select x-model="reportReason" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-800 outline-none focus:border-emerald-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                        <option value="wrong_answer">সঠিক উত্তর অপশনে নেই / উত্তর ভুল</option>
                        <option value="typing_mistake">প্রশ্ন বা অপশনে বানান ভুল আছে</option>
                        <option value="wrong_explanation">প্রশ্নের ব্যাখ্যাটি সঠিক নয়</option>
                        <option value="blurry_image">সংযুক্ত ছবি বা সমীকরণ অস্পষ্ট</option>
                        <option value="other">অন্যান্য সমস্যা</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">{{ __('বিস্তারিত লিখুন (ঐচ্ছিক)') }}</label>
                    <textarea x-model="note" rows="3" placeholder="ভুলটি সনাক্ত করতে আমাদের সাহায্য করুন..." class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-800 outline-none focus:border-emerald-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-2 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                <button type="button" @click="showModal = false" class="rounded-lg border border-zinc-300 px-4 py-2 text-xs font-semibold text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-700">
                    {{ __('বাতিল') }}
                </button>
                <button
                    type="button"
                    @click="@this.reportQuestionError(questionId, reportReason, note); showModal = false;"
                    class="rounded-lg bg-red-600 px-4 py-2 text-xs font-semibold text-white hover:bg-red-700 shadow-sm transition"
                >
                    {{ __('রিপোর্ট সাবমিট করুন') }}
                </button>
            </div>
        </div>
    </div>
</div>
