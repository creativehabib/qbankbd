<div class="mx-auto max-w-4xl px-4 py-8">

    <!-- হেডার এবং স্কোরকার্ড -->
    <div class="mb-8 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">মক টেস্ট রেজাল্ট</h1>
                <p class="text-zinc-500 dark:text-zinc-400 mt-1">
                    বিষয়: <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ $mockTest->subject?->name ?? 'Mixed' }}</span>
                </p>
                <p class="text-xs text-zinc-400 mt-1">জমা দেওয়ার সময়: {{ $mockTest->completed_at->format('d M, Y h:i A') }}</p>
            </div>

            <!-- স্কোর সার্কেল -->
            <div class="flex flex-col items-center justify-center shrink-0 h-28 w-28 rounded-full border-4 {{ $percentage >= 40 ? 'border-emerald-500' : 'border-red-500' }} bg-zinc-50 dark:bg-zinc-800">
                <span class="text-2xl font-bold {{ $percentage >= 40 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">{{ $mockTest->total_score }}</span>
                <span class="text-xs text-zinc-500">আউট অফ {{ $mockTest->total_questions }}</span>
            </div>
        </div>

        <!-- স্ট্যাটিস্টিক্স -->
        <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="rounded-xl bg-blue-50 p-4 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30">
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">মোট প্রশ্ন</p>
                <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $mockTest->total_questions }}</p>
            </div>
            <div class="rounded-xl bg-emerald-50 p-4 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/30">
                <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">সঠিক উত্তর</p>
                <p class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ $mockTest->correct_answers }}</p>
            </div>
            <div class="rounded-xl bg-red-50 p-4 dark:bg-red-900/20 border border-red-100 dark:border-red-800/30">
                <p class="text-sm font-medium text-red-600 dark:text-red-400">ভুল উত্তর</p>
                <p class="text-2xl font-bold text-red-700 dark:text-red-300">{{ $mockTest->wrong_answers }}</p>
            </div>
            <div class="rounded-xl bg-zinc-100 p-4 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">উত্তর দেয়নি</p>
                <p class="text-2xl font-bold text-zinc-700 dark:text-zinc-300">{{ $skipped }}</p>
            </div>
        </div>
    </div>

    <!-- প্রশ্নের সমাধান -->
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 border-b border-zinc-200 dark:border-zinc-700 pb-2">প্রশ্নের সমাধান</h2>

        @php
            $labels = ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ'];
        @endphp

        @foreach($mockTest->testQuestions as $index => $tq)
            @php
                $options = collect($tq->question->extra_content ?? [])->take(4);

                // টাইটেল থেকে p ট্যাগ রিমুভ করা
                $rawTitle = html_entity_decode($tq->question->title ?? '');
                $questionTitle = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', $rawTitle) ?? $rawTitle;
            @endphp

            <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800/50">
                <div class="flex items-start justify-between gap-4">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100" data-math-content>
                        <span class="mr-2 text-zinc-500">{{ $index + 1 }}.</span>{!! $questionTitle !!}
                    </h3>

                    <!-- স্ট্যাটাস ব্যাজ -->
                    @if($tq->user_answer === null)
                        <span class="shrink-0 rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300">Skipped</span>
                    @elseif($tq->is_correct)
                        <span class="shrink-0 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Correct</span>
                    @else
                        <span class="shrink-0 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-900/30 dark:text-red-400">Wrong</span>
                    @endif
                </div>

                <div class="mt-5 grid grid-cols-1 gap-3 md:grid-cols-2">
                    @foreach($options as $optIndex => $option)
                        @php
                            // অপশন থেকে p ট্যাগ রিমুভ করা
                            $rawOption = html_entity_decode($option['option_text'] ?? '');
                            $optionText = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', $rawOption) ?? $rawOption;

                            $isUserAnswer = ($tq->user_answer !== null && $tq->user_answer == $optIndex);
                            $isCorrectOption = !empty($option['is_correct']);

                            // ডিফল্ট স্টাইল
                            $bgClass = 'border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200';
                            $icon = null;

                            // যদি এই অপশনটি সঠিক হয় (সবসময় সবুজ দেখাবে)
                            if ($isCorrectOption) {
                                $bgClass = 'border-emerald-500 bg-emerald-50 dark:border-emerald-500/50 dark:bg-emerald-900/20 text-emerald-800 dark:text-emerald-200 ring-1 ring-emerald-500';
                                $icon = '<x-heroicon-s-check-circle class="size-5 text-emerald-500" />';
                            }
                            // যদি ইউজার ভুল অপশন সিলেক্ট করে থাকে (লাল দেখাবে)
                            elseif ($isUserAnswer && !$isCorrectOption) {
                                $bgClass = 'border-red-500 bg-red-50 dark:border-red-500/50 dark:bg-red-900/20 text-red-800 dark:text-red-200 ring-1 ring-red-500';
                                $icon = '<x-heroicon-s-x-circle class="size-5 text-red-500" />';
                            }
                        @endphp

                        <div class="relative flex items-start gap-3 rounded-xl border p-4 transition-all {{ $bgClass }}">
                            <div class="flex-1 text-sm leading-6">
                                <span class="mr-2 font-bold opacity-70">{{ $labels[$optIndex] ?? $optIndex + 1 }}.</span>
                                <span data-math-content>{!! $optionText !!}</span>
                            </div>
                            @if($icon)
                                <div class="shrink-0">
                                    {!! $icon !!}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Explanation (যদি থাকে) -->
                <!-- Explanation Area -->
                <div class="mt-5">
                    @if(filled($tq->question->description))
                        <!-- যদি ব্যাখ্যা থাকে -->
                        <div class="rounded-xl border border-dashed border-blue-200 bg-blue-50 p-4 dark:border-blue-900/30 dark:bg-blue-900/10">
                            <p class="mb-2 text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 flex items-center gap-1">
                                <x-heroicon-o-light-bulb class="size-4" /> ব্যাখ্যা
                            </p>
                            <div class="prose prose-sm tex2jax_process max-w-none text-zinc-700 dark:prose-invert dark:text-zinc-300" data-math-content>
                                {!! $tq->question->description !!}
                            </div>
                        </div>
                    @else
                        <!-- যদি ব্যাখ্যা না থাকে, তাহলে AI বাটন দেখাবে -->
                        <div class="flex items-center justify-between rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800/50">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-violet-100 text-violet-600 dark:bg-violet-900/30 dark:text-violet-400">
                                    <x-heroicon-o-sparkles class="size-5" />
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">এই প্রশ্নের কোনো ব্যাখ্যা নেই</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">AI ব্যবহার করে এই প্রশ্নের একটি সহজ সমাধান তৈরি করুন।</p>
                                </div>
                            </div>

                            <!-- AI Generate Button -->
                            <button
                                type="button"
                                wire:click="generateAiExplanation({{ $tq->question_id }})"
                                wire:loading.attr="disabled"
                                class="shrink-0 rounded-full bg-violet-600 px-4 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-violet-700 disabled:cursor-wait disabled:opacity-70 dark:bg-violet-500 dark:hover:bg-violet-600"
                            >
                                <span wire:loading.remove wire:target="generateAiExplanation({{ $tq->question_id }})">
                                    ✨ AI Generate
                                </span>
                                <span wire:loading wire:target="generateAiExplanation({{ $tq->question_id }})" class="flex items-center gap-2">
                                    <x-heroicon-o-arrow-path class="size-3.5 animate-spin" /> জেনারেট হচ্ছে...
                                </span>
                            </button>
                        </div>
                        <!-- এরর দেখানোর জায়গা -->
                        @if($aiError)
                            <div class="mt-2 text-sm text-red-500 font-semibold px-2">
                                {{ $aiError }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- ব্যাক বাটন -->
    <div class="mt-8 text-center">
        <a href="{{ route('students.practice.index') }}" wire:navigate class="inline-flex items-center gap-2 rounded-lg bg-zinc-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white">
            <x-heroicon-o-arrow-left class="size-4" /> আরও অনুশীলন করুন
        </a>
    </div>
</div>
