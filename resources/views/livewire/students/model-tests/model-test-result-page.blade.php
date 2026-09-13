<div>
    <div class="max-w-3xl mx-auto">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-zinc-100 tracking-tight">Exam Result</h1>
            <p class="mt-2 text-zinc-600 dark:text-zinc-400 text-lg">{{ $result->modelTest->title }}</p>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800 p-8 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-100 to-emerald-50 dark:from-emerald-900/30 dark:to-emerald-900/10 rounded-bl-[100px] -mr-4 -mt-4"></div>
            
            <div class="text-center mb-10 relative z-10">
                <div class="inline-flex items-center justify-center w-32 h-32 rounded-full bg-emerald-50 dark:bg-emerald-900/20 border-[6px] border-emerald-100 dark:border-emerald-900/40 mb-4">
                    <span class="text-4xl font-black text-emerald-600 dark:text-emerald-400">{{ $result->total_score }}</span>
                </div>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Your Score</h2>
                <p class="text-zinc-500 dark:text-zinc-400 mt-1">Out of {{ $result->modelTest->total_marks }} marks</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-2xl text-center border border-zinc-100 dark:border-zinc-800">
                    <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $result->correct_count }}</div>
                    <div class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mt-1">Correct</div>
                </div>
                <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-2xl text-center border border-zinc-100 dark:border-zinc-800">
                    <div class="text-2xl font-black text-rose-600 dark:text-rose-400">{{ $result->wrong_count }}</div>
                    <div class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mt-1">Wrong</div>
                </div>
                <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-2xl text-center border border-zinc-100 dark:border-zinc-800">
                    <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ $result->unanswered_count }}</div>
                    <div class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mt-1">Skipped</div>
                </div>
                <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-2xl text-center border border-zinc-100 dark:border-zinc-800">
                    <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ gmdate("H:i:s", $result->time_taken_seconds) }}</div>
                    <div class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mt-1">Time Taken</div>
                </div>
            </div>

            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center relative z-10">
                <a href="{{ route('student.model-tests.index') }}" wire:navigate class="px-6 py-3 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-800 dark:text-zinc-200 font-bold rounded-xl transition text-center">
                    Back to Model Tests
                </a>
                <a href="{{ route('dashboard') }}" wire:navigate class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-sm text-center">
                    Go to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
