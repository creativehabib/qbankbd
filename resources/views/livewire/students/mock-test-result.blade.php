<div class="w-full max-w-5xl mx-auto relative pb-10" x-data="{ filter: 'all' }">

    <div class="bg-white dark:bg-slate-800 rounded-t-xl shadow-xs border border-zinc-200 border-b-0 dark:border-slate-700 overflow-hidden">

        <div class="p-2 md:p-3 text-center border-b border-zinc-100 dark:border-zinc-700/50">
            <h1 class="text-xl md:text-2xl font-bold text-zinc-800 dark:text-zinc-100 tracking-tight">
                {{ $mockTest->subject?->name ?? 'Mixed Practice' }} - এ সমস্যার সমাধান
            </h1>
            <p class="text-zinc-500 dark:text-slate-400 text-sm">
                Exam Date: <span class="font-medium">{{ $mockTest->completed_at->format('d M Y, H:i') }}</span>
            </p>
        </div>

        <div class="flex flex-wrap md:flex-nowrap gap-2 px-4 py-4">

            <div class="flex-grow flex-shrink-0 basis-[calc(50%-0.5rem)] md:basis-0 rounded-lg border border-emerald-500 overflow-hidden bg-white dark:bg-slate-800 flex flex-col items-center">
                <div class="w-full bg-emerald-500 text-white text-center py-1 font-semibold text-[10px] uppercase tracking-wider">Marks</div>
                <div class="py-2.5 flex items-center space-x-1.5">
                    <span class="text-emerald-500">
                        <flux:icon.check-circle class="size-4" variant="solid" />
                    </span>
                    <span class="text-sm font-bold text-zinc-700 dark:text-zinc-200">{{ $mockTest->total_score + 0 }}/{{ $mockTest->total_questions }}</span>
                </div>
            </div>

            <div class="flex-grow flex-shrink-0 basis-[calc(50%-0.5rem)] md:basis-0 rounded-lg border border-sky-500 overflow-hidden bg-white dark:bg-slate-800 flex flex-col items-center">
                <div class="w-full bg-sky-500 text-white text-center py-1 font-semibold text-[10px] uppercase tracking-wider">Accuracy</div>
                <div class="py-2.5 flex items-center space-x-1.5">
                    <span class="text-sky-500">
                        <flux:icon.check-badge class="size-4" />
                    </span>
                    <span class="text-sm font-bold text-zinc-700 dark:text-zinc-200">{{ round($percentage ?? 0) }}%</span>
                </div>
            </div>

            <div class="flex-grow flex-shrink-0 basis-[calc(50%-0.5rem)] md:basis-0 rounded-lg border border-sky-500 overflow-hidden bg-white dark:bg-slate-800 max-sm:dark:border-zinc-700 flex flex-col items-center">
                <div class="w-full bg-sky-500 max-sm:dark:bg-zinc-600 text-white text-center py-1 font-semibold text-[10px] uppercase tracking-wider">Time</div>
                <div class="py-2.5 flex items-center space-x-1.5">
                    <span class="text-sky-500">
                        <flux:icon.clock class="size-4" />
                    </span>
                    <span class="text-sm font-bold text-zinc-700 dark:text-zinc-200">{{ $mockTest->duration_minutes ?? '0' }}m</span>
                </div>
            </div>

            <div class="flex-grow flex-shrink-0 basis-[calc(50%-0.5rem)] md:basis-0 rounded-lg border border-red-500 overflow-hidden bg-white dark:bg-slate-800 max-sm:dark:border-zinc-700 flex flex-col items-center">
                <div class="w-full bg-red-500 max-sm:dark:bg-zinc-600 text-white text-center py-1 font-semibold text-[10px] uppercase tracking-wider">Negative</div>
                <div class="py-2.5 flex items-center space-x-1.5">
                    <span class="text-red-500">
                        <flux:icon.minus-circle class="size-4" />
                    </span>
                    <span class="text-sm font-bold text-zinc-700 dark:text-zinc-200">{{ $mockTest->negative_score + 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-b-xl flex items-center md:justify-center border border-zinc-200 dark:border-zinc-700 border-t-0 gap-3 py-3 px-4 pb-4 mb-6 overflow-x-auto whitespace-nowrap scrollbar-hide sticky z-20 top-16 shadow-sm">

        <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-blue-600 border-blue-600 text-white shadow-md' : 'bg-zinc-100 dark:bg-slate-800 border-zinc-200 dark:border-slate-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'" class="flex items-center space-x-2 px-5 py-2.5 rounded-full border transition-all duration-200">
            <span class="w-3 h-3 rounded-full" :class="filter === 'all' ? 'bg-white' : 'bg-blue-500'"></span>
            <span class="text-sm font-bold leading-none">All {{ $mockTest->total_questions }}</span>
        </button>

        <button @click="filter = 'right'" :class="filter === 'right' ? 'bg-emerald-500 border-emerald-500 text-white shadow-md' : 'bg-zinc-100 dark:bg-slate-800 border-zinc-200 dark:border-slate-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'" class="flex items-center space-x-2 px-5 py-2.5 rounded-full border transition-all duration-200">
            <span class="w-3 h-3 rounded-full" :class="filter === 'right' ? 'bg-white' : 'bg-emerald-500'"></span>
            <span class="text-sm font-bold leading-none">Right {{ $mockTest->correct_answers }}</span>
        </button>

        <button @click="filter = 'skipped'" :class="filter === 'skipped' ? 'bg-amber-500 border-amber-500 text-white shadow-md' : 'bg-zinc-100 dark:bg-slate-800 border-zinc-200 dark:border-slate-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'" class="flex items-center space-x-2 px-5 py-2.5 rounded-full border transition-all duration-200">
            <span class="w-3 h-3 rounded-full" :class="filter === 'skipped' ? 'bg-white' : 'bg-amber-400'"></span>
            <span class="text-sm font-bold leading-none">Skipped {{ $skipped }}</span>
        </button>

        <button @click="filter = 'wrong'" :class="filter === 'wrong' ? 'bg-rose-500 border-rose-500 text-white shadow-md' : 'bg-zinc-100 dark:bg-slate-800 border-zinc-200 dark:border-slate-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'" class="flex items-center space-x-2 px-5 py-2.5 rounded-full border transition-all duration-200">
            <span class="w-3 h-3 rounded-full" :class="filter === 'wrong' ? 'bg-white' : 'bg-rose-500'"></span>
            <span class="text-sm font-bold leading-none">Wrong {{ $mockTest->wrong_answers }}</span>
        </button>
    </div>

    <div class="flex justify-center mb-6 mt-8">
        <h2 class="text-lg md:text-xl font-bold px-6 py-1 border-l-[3px] border-r-[3px] transition-colors duration-200 border-blue-600 text-zinc-800 dark:text-zinc-100 dark:border-blue-500">
            {{ $mockTest->subject?->name ?? 'তথ্য ও যোগাযোগ প্রযুক্তি' }} ({{ $mockTest->total_questions }})
        </h2>
    </div>

    <div class="space-y-4 px-2 md:px-4">

        @php
            $labels = ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ'];
        @endphp

        @foreach($mockTest->testQuestions as $index => $tq)
            @php
                $options = collect($tq->question->extra_content ?? [])->take(4);

                $rawTitle = html_entity_decode($tq->question->title ?? '');
                $questionTitle = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', $rawTitle) ?? $rawTitle;

                // Alpine.js ফিল্টারিং এর জন্য স্ট্যাটাস
                $questionStatus = 'skipped';
                if ($tq->user_answer !== null) {
                    $questionStatus = $tq->is_correct ? 'right' : 'wrong';
                }
            @endphp

            <div x-show="filter === 'all' || filter === '{{ $questionStatus }}'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-data="{ openDesc: false }"
                 class="bg-white dark:bg-zinc-800 rounded-xl p-4 md:p-5 transition-all duration-200 shadow-sm hover:shadow-md border border-zinc-200 dark:border-zinc-700">

                <div class="mb-3">
                    <div class="flex flex-wrap items-start justify-between gap-y-2 gap-x-4 mb-1">
                        <p class="text-zinc-800 dark:text-zinc-100 font-medium leading-relaxed flex items-start gap-2 flex-1 text-base md:text-lg">
                            <span class="font-bold text-zinc-500">{{ $index + 1 }}.</span>
                            <span data-math-content>{!! $questionTitle !!}</span>
                        </p>
                    </div>

                    <div class="flex items-center gap-1 overflow-x-auto scrollbar-hide w-full">
                        <span class="px-2 py-0.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 text-[10px] font-medium tracking-tight border border-zinc-200 dark:border-zinc-700 max-w-[140px] overflow-x-auto scrollbar-hide whitespace-nowrap">{{ $mockTest->subject?->name ?? 'Subject' }}</span>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-1">
                    @foreach($options as $optIndex => $option)
                        @php
                            $rawOption = html_entity_decode($option['option_text'] ?? '');
                            $optionText = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', $rawOption) ?? $rawOption;

                            $isUserAnswer = ($tq->user_answer !== null && $tq->user_answer == $optIndex);
                            $isCorrectOption = !empty($option['is_correct']);

                            $circleClass = 'border-zinc-300 dark:border-zinc-600 text-zinc-600 dark:text-zinc-300';

                            if ($isCorrectOption) {
                                $circleClass = 'bg-green-600 text-white border-green-700 shadow-sm';
                            } elseif ($isUserAnswer && !$isCorrectOption) {
                                $circleClass = 'bg-red-500 text-white border-red-600 shadow-sm';
                            }
                        @endphp

                        <button disabled class="p-1.5 pl-3 rounded-xl border transition-all relative bg-zinc-50 dark:bg-zinc-700/50 border-zinc-100 dark:border-zinc-700 cursor-default text-left">
                            <div class="flex items-center gap-3 w-full">
                                <span class="flex shrink-0 items-center justify-center w-6 h-6 rounded-full border text-sm font-bold pt-0.5 {{ $circleClass }}">
                                    {{ $labels[$optIndex] ?? $optIndex + 1 }}
                                </span>
                                <div class="flex items-center gap-2 w-full relative">
                                    <span class="text-zinc-800 dark:text-zinc-200 text-sm flex-1 font-medium" data-math-content>{!! $optionText !!}</span>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>

                <div class="flex items-center justify-between mt-3 gap-4 overflow-x-auto scrollbar-hide">

                    <button @click="openDesc = !openDesc" class="flex items-center gap-1.5 group px-2 py-1 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 rounded-lg transition">
                        <span class="text-xs font-bold uppercase tracking-wider text-zinc-400 group-hover:text-blue-600">Des</span>
                        <flux:icon.chevron-down class="size-4 text-zinc-400 transition-transform duration-200 group-hover:text-blue-500" x-bind:class="openDesc ? 'rotate-180 text-blue-500' : ''" />
                    </button>

                    <div class="flex items-center gap-1 md:gap-2 shrink-0 cursor-default">

                        <div class="flex items-center gap-1.5 text-zinc-400 dark:text-zinc-500" title="Views">
                            <flux:icon.eye class="size-[18px]" />
                            <span class="text-sm font-semibold pt-0.5">{{ $tq->question->views_count ?? 0 }}</span>
                        </div>

                        <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full cursor-pointer transition text-zinc-400 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/20" title="Statistics">
                            <flux:icon.chart-pie class="size-[18px]" />
                        </button>

                        <button type="button" wire:click="toggleBookmark({{ $tq->question_id }})" class="w-8 h-8 flex items-center justify-center rounded-full cursor-pointer transition {{ $tq->question->is_bookmarked ? 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20' : 'text-zinc-400 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20' }}" title="{{ $tq->question->is_bookmarked ? 'Remove Bookmark' : 'Save Bookmark' }}">
                            <flux:icon.bookmark class="size-[18px]" variant="{{ $tq->question->is_bookmarked ? 'solid' : 'outline' }}" />
                        </button>

                        <button type="button" wire:click="toggleLike({{ $tq->question_id }})" class="px-2 w-auto h-8 flex items-center justify-center gap-1.5 rounded-full cursor-pointer transition {{ $tq->question->is_liked ? 'text-pink-500 bg-pink-50 dark:bg-pink-900/20' : 'text-zinc-400 hover:text-pink-500 hover:bg-pink-50 dark:hover:bg-pink-900/20' }}" title="{{ $tq->question->is_liked ? 'Unlike' : 'Like' }}">
                            <flux:icon.heart class="size-[18px]" variant="{{ $tq->question->is_liked ? 'solid' : 'outline' }}" />
                            @if($tq->question->likes_count > 0)
                                <span class="text-xs font-bold pt-0.5">{{ $tq->question->likes_count }}</span>
                            @endif
                        </button>
                        <button type="button" wire:click="$dispatch('openModal', { component: 'report-modal', arguments: { questionId: {{ $tq->question_id }} } })" class="w-8 h-8 flex items-center justify-center rounded-full cursor-pointer transition text-zinc-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20" title="Report Error">
                            <flux:icon.flag class="size-[18px]" />
                        </button>
                        <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full cursor-pointer transition text-zinc-400 hover:text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20" title="Share">
                            <flux:icon.share class="size-[18px]" />
                        </button>
                    </div>
                </div>

                <div x-show="openDesc" x-collapse>
                    @if(filled($tq->question->description))
                        <div class="mt-4 rounded-xl border border-dashed border-blue-200 bg-blue-50 p-4 dark:border-blue-900/30 dark:bg-blue-900/10">
                            <p class="mb-2 text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 flex items-center gap-1">
                                <flux:icon.light-bulb class="size-4" /> ব্যাখ্যা
                            </p>
                            <div class="prose prose-sm tex2jax_process max-w-none text-zinc-700 dark:prose-invert dark:text-zinc-300" data-math-content>
                                {!! $tq->question->description !!}
                            </div>
                        </div>
                    @else
                        <div class="mt-4 space-y-3">
                            <div class="text-center border-2 border-dashed rounded-xl p-6 border-zinc-200 dark:border-zinc-700">
                                <div class="space-y-3 text-center">
                                    <div wire:loading.remove wire:target="generateAiExplanation({{ $tq->question_id }})">
                                        <flux:icon.sparkles class="mx-auto size-6 text-violet-500" />
                                        <p class="font-semibold text-zinc-600 dark:text-zinc-300">{{ __('No explanation yet') }}</p>

                                        <button
                                            type="button"
                                            wire:click.prevent="generateAiExplanation({{ $tq->question_id }})"
                                            class="mt-2 inline-flex items-center gap-2 rounded-full bg-violet-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-violet-700 transition shadow-sm"
                                        >
                                            <span>✨ AI Generate</span>
                                        </button>
                                    </div>

                                    <div wire:loading wire:target="generateAiExplanation({{ $tq->question_id }})">
                                        <div class="flex flex-col items-center gap-2">
                                            <flux:icon.arrow-path class="size-6 animate-spin text-violet-600" />
                                            <p class="text-xs font-medium text-violet-600 animate-pulse">AI ব্যাখ্যা তৈরি করছে...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        @if($aiError)
                            <div class="mt-2 text-sm font-semibold text-red-500 px-2 text-center">{{ $aiError }}</div>
                        @endif
                    @endif
                </div>

            </div>
        @endforeach
    </div>
</div>
