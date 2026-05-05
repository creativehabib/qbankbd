<div class="space-y-6" x-data="{ openDescription: null }">

    <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-12">

        <div class="space-y-6 lg:col-span-8 xl:col-span-9">

            <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="relative flex size-[110px] shrink-0 items-center justify-center">
                        <svg class="size-full -rotate-90" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-red-500" stroke-width="2.5"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-emerald-500" stroke-width="2.5" stroke-dasharray="{{ $stats['accuracy'] ?? 0 }}, 100"></circle>
                        </svg>
                        <div class="absolute flex flex-col items-center justify-center text-center">
                            <span class="text-xl font-black text-zinc-900 dark:text-white">{{ $stats['accuracy'] ?? 0 }}%</span>
                            <span class="text-[9px] font-bold tracking-wider text-zinc-500 uppercase">Acc.</span>
                        </div>
                    </div>

                    <div class="flex w-full flex-1 flex-col gap-4">
                        <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2 sm:gap-4">
                            <div class="flex flex-1 items-center gap-2 rounded-lg border border-zinc-100 bg-zinc-50/80 px-3 py-2 text-[10px] font-bold text-zinc-500 uppercase tracking-widest dark:border-zinc-800 dark:bg-zinc-800/50">
                                <span class="size-2 shrink-0 rounded-full bg-emerald-500"></span> <span class="text-zinc-700 dark:text-zinc-300">{{ $stats['right'] ?? 0 }}</span> Right
                            </div>
                            <div class="flex flex-1 items-center gap-2 rounded-lg border border-zinc-100 bg-zinc-50/80 px-3 py-2 text-[10px] font-bold text-zinc-500 uppercase tracking-widest dark:border-zinc-800 dark:bg-zinc-800/50">
                                <span class="size-2 shrink-0 rounded-full bg-red-500"></span> <span class="text-zinc-700 dark:text-zinc-300">{{ $stats['wrong'] ?? 0 }}</span> Wrong
                            </div>
                            <div class="flex flex-1 items-center gap-2 rounded-lg border border-zinc-100 bg-zinc-50/80 px-3 py-2 text-[10px] font-bold text-zinc-500 uppercase tracking-widest dark:border-zinc-800 dark:bg-zinc-800/50">
                                <span class="size-2 shrink-0 rounded-full bg-amber-400"></span> <span class="text-zinc-700 dark:text-zinc-300">{{ $stats['skipped'] ?? 0 }}</span> Skip
                            </div>
                            <div class="flex flex-1 items-center gap-2 rounded-lg border border-zinc-100 bg-zinc-50/80 px-3 py-2 text-[10px] font-bold text-zinc-500 uppercase tracking-widest dark:border-zinc-800 dark:bg-zinc-800/50">
                                <span class="size-2 shrink-0 rounded-full bg-zinc-400"></span> <span class="text-zinc-700 dark:text-zinc-300">{{ $stats['total'] ?? 0 }}</span> Total
                            </div>
                        </div>

                        <div class="flex items-center justify-between rounded-lg bg-[#f8fdfa] p-4 border border-emerald-50 dark:bg-emerald-900/10 dark:border-emerald-900/20">
                            <div>
                                <h4 class="text-xs font-bold text-emerald-800 dark:text-emerald-500">Practice Wrong</h4>
                                <p class="mt-0.5 text-[11px] font-medium text-emerald-600/80 dark:text-emerald-600/70 italic">Learn from mistakes — review, retry, and improve.<br/>🔥 Get +5 XP for every wrong question you correct.</p>
                            </div>
                            <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30">
                                <flux:icon.arrow-right class="size-4" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-3 border-b border-zinc-200 border-dashed pb-6 dark:border-zinc-800">

                <button wire:click="setFilter('wrong')"
                        class="rounded-md border px-5 py-2 text-xs font-bold tracking-wide transition
                    {{ $filter === 'wrong'
                        ? 'border-red-600 bg-red-600 text-white shadow-sm'
                        : 'border-zinc-200 bg-white text-zinc-700 hover:border-red-300 hover:bg-red-50 hover:text-red-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-red-900/20 dark:hover:text-red-400' }}">
                    Wrong ({{ $stats['wrong'] ?? 0 }})
                </button>

                <button wire:click="setFilter('right')"
                        class="rounded-md border px-5 py-2 text-xs font-bold tracking-wide transition
                    {{ $filter === 'right'
                        ? 'border-emerald-600 bg-emerald-600 text-white shadow-sm'
                        : 'border-zinc-200 bg-white text-zinc-700 hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400' }}">
                    Right ({{ $stats['right'] ?? 0 }})
                </button>

                <button wire:click="setFilter('skipped')"
                        class="rounded-md border px-5 py-2 text-xs font-bold tracking-wide transition
                    {{ $filter === 'skipped'
                        ? 'border-amber-500 bg-amber-500 text-white shadow-sm'
                        : 'border-zinc-200 bg-white text-zinc-700 hover:border-amber-300 hover:bg-amber-50 hover:text-amber-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-amber-900/20 dark:hover:text-amber-400' }}">
                    Skipped ({{ $stats['skipped'] ?? 0 }})
                </button>

            </div>

            <div wire:loading.class="opacity-50 pointer-events-none" class="transition-opacity duration-200">
                @if($questions->isEmpty())
                    <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-zinc-300 bg-white py-16 dark:border-zinc-700 dark:bg-zinc-900">
                        <flux:icon.document-magnifying-glass class="mb-4 size-12 text-zinc-300" />
                        <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">কোনো প্রশ্ন নেই</h3>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($questions as $question)
                            @php
                                $options = collect($question->extra_content ?? [])->take(4);
                                $labels = ['ক', 'খ', 'গ', 'ঘ'];
                                $questionTitle = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', html_entity_decode($question->title ?? ''));
                            @endphp

                            <article class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900" wire:key="mistake-{{ $question->id }}">

                                <h3 class="text-[15px] font-bold text-zinc-900 dark:text-zinc-100 tex2jax_process" data-math-content>
                                    {{ $questions->firstItem() + $loop->index }}. {!! $questionTitle !!}
                                </h3>

                                <div class="mt-2.5 flex flex-wrap items-center gap-2">
                                    @if($question->subject)
                                        <span class="rounded-full border border-zinc-200 bg-zinc-50 px-2.5 py-0.5 text-[10px] font-semibold text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                                            {{ $question->subject->name }}
                                        </span>
                                    @endif
                                    @if($question->chapter)
                                        <span class="rounded-full border border-zinc-200 bg-zinc-50 px-2.5 py-0.5 text-[10px] font-semibold text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                                            {{ $question->chapter->name }}
                                        </span>
                                    @endif
                                    <span class="rounded-full border border-zinc-200 bg-zinc-50 px-2.5 py-0.5 text-[10px] font-semibold text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                                        {{ $question->difficulty_level ?? 'সাধারণ প্রশ্ন' }}
                                    </span>
                                </div>

                                <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-3 tex2jax_process" data-math-content>
                                    @foreach($options as $idx => $opt)
                                        @php
                                            $isCorrect = !empty($opt['is_correct']);
                                            $cleanOptText = strip_tags(html_entity_decode($opt['option_text'] ?? ''));
                                        @endphp
                                        <div class="flex items-center gap-3 rounded-lg border border-zinc-100 bg-[#fbfcfd] p-2.5 transition dark:border-zinc-800 dark:bg-zinc-800/50">
                                            @if($isCorrect)
                                                <div class="flex size-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-[11px] font-bold text-white shadow-sm">{{ $labels[$idx] ?? '•' }}</div>
                                            @else
                                                <div class="flex size-6 shrink-0 items-center justify-center rounded-full border border-zinc-200 bg-white text-[11px] font-bold text-zinc-600 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-300">{{ $labels[$idx] ?? '•' }}</div>
                                            @endif
                                            <span class="text-sm font-medium {{ $isCorrect ? 'text-zinc-900 dark:text-zinc-100' : 'text-zinc-600 dark:text-zinc-400' }}">{!! $cleanOptText !!}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-5 flex items-center justify-between border-t border-zinc-100 pt-4 dark:border-zinc-800">

                                    <button type="button" @click="openDescription === {{ $question->id }} ? openDescription = null : openDescription = {{ $question->id }}" class="flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                        DES
                                        <flux:icon.chevron-down class="size-3.5 transition-transform" x-bind:class="openDescription === {{ $question->id }} ? 'rotate-180' : ''" />
                                    </button>

                                    <div class="flex items-center gap-4 text-zinc-400">
                                        <div class="flex items-center gap-1 text-xs"><flux:icon.eye class="size-4" /> {{ $question->views_count ?? rand(100, 999) }}</div>
                                        <flux:icon.chart-pie class="size-4 cursor-pointer hover:text-zinc-600" />
                                        <flux:icon.bookmark class="size-4 cursor-pointer hover:text-zinc-600" />
                                        <flux:icon.heart class="size-4 cursor-pointer hover:text-red-500" />
                                        <flux:icon.flag class="size-4 cursor-pointer hover:text-zinc-600" />
                                        <flux:icon.share class="size-4 cursor-pointer hover:text-zinc-600" />
                                    </div>
                                </div>

                                <div x-show="openDescription === {{ $question->id }}" x-collapse x-cloak class="mt-4 rounded-xl border border-dashed border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800/50">
                                    @if(filled($question->description))
                                        <div class="prose prose-sm max-w-none text-zinc-700 dark:prose-invert dark:text-zinc-300 tex2jax_process" data-math-content>
                                            {!! $question->description !!}
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <div wire:loading.remove wire:target="generateAiExplanation({{ $question->id }})">
                                                <button type="button" wire:click.prevent="generateAiExplanation({{ $question->id }})" class="inline-flex items-center gap-2 rounded-full bg-violet-600 px-4 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-violet-700">
                                                    ✨ AI Generate Explanation
                                                </button>
                                            </div>
                                            <div wire:loading wire:target="generateAiExplanation({{ $question->id }})" class="text-xs font-medium text-violet-600 animate-pulse">
                                                Generating AI explanation...
                                            </div>
                                        </div>
                                        @if($aiError && session('last_question_id') == $question->id)
                                            <div class="mt-3 rounded bg-red-50 p-2 text-center text-xs font-medium text-red-600 dark:bg-red-900/20 dark:text-red-400">
                                                {{ $aiError }}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <div class="mt-6">{{ $questions->links() }}</div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-4 xl:col-span-3">
            <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">

                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Subjects Report</h3>
                    <flux:icon.arrow-right class="size-4 text-zinc-400" />
                </div>

                <div class="space-y-3" x-data="{ activeTab: 0 }">

                    @if(isset($subjectReports) && count($subjectReports) > 0)
                        @foreach($subjectReports as $index => $report)
                            <div class="rounded-xl border border-zinc-200 transition-all dark:border-zinc-700" :class="activeTab === {{ $index }} ? 'border-zinc-300 shadow-sm' : ''">
                                <button @click="activeTab = activeTab === {{ $index }} ? null : {{ $index }}" class="flex w-full items-center justify-between p-3.5">
                                    <span class="text-xs font-bold text-zinc-800 dark:text-zinc-200">{{ $report['name'] }}</span>
                                    <div class="flex items-center gap-3">
                                        <span class="text-[11px] font-black text-emerald-600">{{ number_format($report['accuracy'], 2) }}%</span>
                                        <div class="flex size-5 items-center justify-center rounded-full bg-zinc-100 text-zinc-500 transition-transform dark:bg-zinc-800" :class="activeTab === {{ $index }} ? 'rotate-180' : ''">
                                            <flux:icon.chevron-down class="size-3" />
                                        </div>
                                    </div>
                                </button>

                                <div x-show="activeTab === {{ $index }}" x-collapse x-cloak>
                                    <div class="border-t border-zinc-100 p-4 pt-3 dark:border-zinc-700/50">
                                        <div class="flex items-center justify-between text-[9px] font-bold text-zinc-500">
                                            <div class="flex items-center gap-1.5">
                                                <span class="size-2 rounded-full bg-emerald-500"></span>
                                                <span class="text-zinc-900 dark:text-white">{{ $report['right_mcq'] }}</span>/{{ $report['total_mcq'] }} <span class="font-medium">MCQ</span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="size-2 rounded-full bg-blue-500"></span>
                                                <span class="text-zinc-900 dark:text-white">{{ $report['total_cq'] }}</span>/0 <span class="font-medium">CQ</span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="size-2 rounded-full bg-purple-500"></span>
                                                <span class="text-zinc-900 dark:text-white">{{ $report['total_content'] }}</span>/0 <span class="font-medium">CONTENT</span>
                                            </div>
                                        </div>
                                        <div class="mt-4 text-right">
                                            <a href="#" class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-600 hover:text-blue-700 hover:underline dark:text-blue-400">
                                                View Report <flux:icon.arrow-right class="size-3" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="py-4 text-center text-sm text-zinc-500 dark:text-zinc-400">কোনো বিষয়ের রিপোর্ট পাওয়া যায়নি।</div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>
