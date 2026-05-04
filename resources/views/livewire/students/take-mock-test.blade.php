<div
    x-data="{
        timeRemaining: {{ $remainingSeconds }},
        timerInterval: null,
        formattedTime() {
            let m = Math.floor(this.timeRemaining / 60).toString().padStart(2, '0');
            let s = (this.timeRemaining % 60).toString().padStart(2, '0');
            return m + ':' + s;
        },
        startTimer() {
            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--;
                } else {
                    clearInterval(this.timerInterval);
                    $wire.submitExam(); // সময় শেষ হলে অটো সাবমিট
                }
            }, 1000);
        }
    }"
    x-init="startTimer()"
    class="min-h-screen bg-gray-50 pb-20 dark:bg-[var(--app-dark-bg)]"
>
    <!-- স্টিকি হেডার (টাইমার সহ) -->
    <header class="sticky top-0 z-50 border-b border-zinc-200 bg-white/90 px-6 py-4 shadow-sm backdrop-blur-md dark:border-zinc-700 dark:bg-zinc-900/90">
        <div class="mx-auto flex max-w-4xl items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ $subjectName }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $mockTest->total_questions }} টি প্রশ্ন</p>
            </div>

            <!-- টাইমার ডিসপ্লে -->
            <div class="flex items-center gap-3 rounded-full bg-red-50 px-4 py-2 text-red-600 dark:bg-red-500/10 dark:text-red-400">
                <x-heroicon-o-clock class="size-6 animate-pulse" />
                <span class="text-xl font-mono font-bold tracking-wider" x-text="formattedTime()"></span>
            </div>
        </div>
    </header>

    <!-- মূল প্রশ্নপত্র -->
    <main class="mx-auto mt-8 max-w-4xl px-4">
        @php($labels = ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ'])

        <div class="space-y-6">
            @foreach($testQuestions as $index => $tq)
                @php($options = collect($tq->question->extra_content ?? [])->take(4))
                @php($questionTitle = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', html_entity_decode($tq->question->title ?? '')) ?? html_entity_decode($tq->question->title ?? ''))

                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800/50">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100" data-math-content>
                        <span class="mr-2 text-zinc-500">{{ $index + 1 }}.</span>{!! $questionTitle !!}
                    </h3>

                    <div class="mt-5 grid grid-cols-1 gap-3 md:grid-cols-2">
                        @foreach($options as $optIndex => $option)
                            @php($optionText = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', html_entity_decode($option['option_text'] ?? '')) ?? html_entity_decode($option['option_text'] ?? ''))

                            <!-- রেডিও বাটন এবং অপশন কার্ড -->
                            <label class="group relative flex cursor-pointer items-start gap-4 rounded-xl border p-4 transition-all
                                {{ (isset($answers[$tq->id]) && $answers[$tq->id] == $optIndex) ? 'border-emerald-500 bg-emerald-50/50 ring-1 ring-emerald-500 dark:border-emerald-500 dark:bg-emerald-900/20' : 'border-zinc-200 hover:border-emerald-300 hover:bg-zinc-50 dark:border-zinc-700 dark:hover:border-emerald-600 dark:hover:bg-zinc-800' }}">

                                <div class="flex h-6 items-center">
                                    <input
                                        type="radio"
                                        wire:model="answers.{{ $tq->id }}"
                                        value="{{ $optIndex }}"
                                        name="question_{{ $tq->id }}"
                                        class="h-4 w-4 border-zinc-300 text-emerald-600 focus:ring-emerald-500 dark:border-zinc-600 dark:bg-zinc-700"
                                    >
                                </div>
                                <div class="flex-1 text-sm leading-6">
                                    <span class="mr-2 font-bold text-zinc-500">{{ $labels[$optIndex] ?? $optIndex + 1 }}.</span>
                                    <span class="text-zinc-800 dark:text-zinc-200" data-math-content>{!! $optionText !!}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- সাবমিট বাটন -->
        <div class="mt-10 mb-20 flex justify-center">
            <button
                type="button"
                wire:click="submitExam"
                wire:confirm="আপনি কি নিশ্চিত যে আপনি পরীক্ষাটি সাবমিট করতে চান?"
                class="flex w-full max-w-sm items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-4 text-lg font-bold text-white shadow-lg transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
            >
                <x-heroicon-s-check-circle class="size-6" />
                {{ __('পরীক্ষা জমা দিন') }}
            </button>
        </div>
    </main>
</div>
