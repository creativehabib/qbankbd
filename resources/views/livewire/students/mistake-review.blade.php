<div class="space-y-6">
    <div class="flex items-center gap-4 rounded-xl border border-red-200 bg-red-50 p-6 dark:border-red-900/30 dark:bg-red-900/10">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400">
            <flux:icon.exclamation-triangle class="size-6" />
        </div>
        <div>
            <h1 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">আমার ভুলসমূহ (Mistake Review)</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">মক টেস্টে আপনার ভুল করা প্রশ্নগুলো এখানে সংগ্রহ করা হয়েছে। পরীক্ষার আগে এগুলো বারবার রিভিশন দিন।</p>
        </div>
    </div>

    @if($questions->isEmpty())
        <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-zinc-300 bg-white py-16 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:icon.check-badge class="mb-4 size-16 text-emerald-500" />
            <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">দুর্দান্ত কাজ!</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">আপনার কোনো ভুল করা প্রশ্ন নেই। এভাবেই চালিয়ে যান।</p>
        </div>
    @else
        <div class="space-y-5">
            @foreach($questions as $question)
                @php
                    // সঠিক উত্তর খুঁজে বের করার লজিক
                    $options = collect($question->extra_content ?? [])->take(4);
                    $labels = ['ক', 'খ', 'গ', 'ঘ'];
                    $correctOptionText = '';
                    foreach($options as $idx => $opt) {
                        if(!empty($opt['is_correct'])) {
                            $correctOptionText = $labels[$idx] . ') ' . strip_tags(html_entity_decode($opt['option_text'] ?? ''));
                        }
                    }
                    $questionTitle = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', html_entity_decode($question->title ?? ''));
                @endphp

                <article class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm transition hover:border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900" wire:key="mistake-{{ $question->id }}">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="mb-2 flex items-center gap-2 text-xs font-semibold">
                                <span class="rounded bg-zinc-100 px-2 py-1 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">{{ $question->academicClass?->name }}</span>
                                <span class="rounded bg-zinc-100 px-2 py-1 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">{{ $question->subject?->name }}</span>
                            </div>
                            <h3 class="text-base font-medium text-zinc-900 dark:text-zinc-100 tex2jax_process" data-math-content>
                                {!! ($questions->firstItem() + $loop->index) . '. ' . $questionTitle !!}
                            </h3>

                            <div class="mt-4 inline-flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-800 dark:border-emerald-900/50 dark:bg-emerald-900/20 dark:text-emerald-400 tex2jax_process" data-math-content>
                                <flux:icon.check-circle class="size-5" />
                                <span>সঠিক উত্তর: {!! $correctOptionText !!}</span>
                            </div>
                        </div>
                    </div>

                    <div x-data="{ openDescription: false }" class="mt-5 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                        <button type="button" x-on:click="openDescription = !openDescription" class="inline-flex items-center gap-1.5 text-sm font-semibold text-zinc-500 hover:text-emerald-600 dark:text-zinc-400 transition">
                            <flux:icon.sparkles class="size-4" />
                            <span>ব্যাখ্যা দেখুন</span>
                            <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="openDescription ? 'rotate-180' : ''" />
                        </button>

                        <div x-show="openDescription" x-collapse x-cloak class="mt-4 rounded-xl border border-dashed border-zinc-300 p-5 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                            @if(filled($question->description))
                                <div class="prose prose-sm max-w-none text-zinc-700 dark:prose-invert dark:text-zinc-300 tex2jax_process" data-math-content>
                                    {!! $question->description !!}
                                </div>
                            @else
                                <div class="space-y-3 text-center">
                                    <div wire:loading.remove wire:target="generateAiExplanation({{ $question->id }})">
                                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">এই প্রশ্নের কোনো ব্যাখ্যা দেওয়া নেই।</p>
                                        <button type="button" wire:click.prevent="generateAiExplanation({{ $question->id }})" class="mt-2 inline-flex items-center gap-2 rounded-full bg-violet-600 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-violet-700">
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

                            @if($aiError && session('last_question_id') == $question->id)
                                <div class="mt-3 rounded bg-red-50 p-2 text-center text-xs font-medium text-red-600 dark:bg-red-900/20 dark:text-red-400">
                                    {{ $aiError }}
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6">{{ $questions->links() }}</div>
    @endif
</div>
