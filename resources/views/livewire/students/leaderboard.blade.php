<div class="mx-auto max-w-4xl px-4 py-8">

    <!-- হেডার -->
    <div class="mb-8 text-center">
        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-amber-100 text-amber-500 shadow-sm dark:bg-amber-900/30">
            <x-heroicon-s-trophy class="size-10" />
        </div>
        <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-zinc-100">{{ __('টপ স্টুডেন্টস লিডারবোর্ড') }}</h1>
        <p class="mt-2 text-zinc-500 dark:text-zinc-400">{{ __('মক টেস্টে অংশগ্রহণ করে পয়েন্ট অর্জন করুন এবং নিজেকে শীর্ষে নিয়ে যান!') }}</p>
    </div>

    @if($topStudents->isEmpty())
        <div class="rounded-2xl border border-dashed border-zinc-300 bg-white p-10 text-center dark:border-zinc-700 dark:bg-zinc-800/50">
            <x-heroicon-o-face-frown class="mx-auto mb-3 size-12 text-zinc-400" />
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">এখনো কোনো ডাটা নেই</h3>
            <p class="text-sm text-zinc-500">মক টেস্ট দিয়ে প্রথম স্থান অধিকার করার সুযোগ আপনারই!</p>
            <a href="{{ route('students.practice.index') }}" wire:navigate class="mt-4 inline-block rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">মক টেস্ট শুরু করুন</a>
        </div>
    @else
        <!-- লিডারবোর্ড লিস্ট -->
        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="bg-zinc-50 px-6 py-4 border-b border-zinc-200 dark:bg-zinc-800/50 dark:border-zinc-700">
                <div class="grid grid-cols-12 gap-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                    <div class="col-span-2 md:col-span-1 text-center">র‍্যাংক</div>
                    <div class="col-span-7 md:col-span-7">স্টুডেন্ট</div>
                    <div class="col-span-3 md:col-span-2 text-center">মক টেস্ট</div>
                    <div class="hidden md:block md:col-span-2 text-right">মোট পয়েন্ট</div>
                </div>
            </div>

            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                @foreach($topStudents as $index => $student)
                    @php
                        $rank = $index + 1;
                        $rankStyle = 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300';
                        $rowStyle = 'hover:bg-zinc-50 dark:hover:bg-zinc-800/50';
                        $medal = null;

                        if ($rank === 1) {
                            $rankStyle = 'bg-amber-400 text-white shadow-md shadow-amber-400/30';
                            $rowStyle = 'bg-amber-50/30 hover:bg-amber-50/50 dark:bg-amber-900/10 dark:hover:bg-amber-900/20';
                            $medal = '🥇';
                        } elseif ($rank === 2) {
                            $rankStyle = 'bg-slate-300 text-slate-700 shadow-md shadow-slate-300/30 dark:bg-slate-600 dark:text-white';
                            $rowStyle = 'bg-slate-50/30 hover:bg-slate-50/50 dark:bg-slate-900/10 dark:hover:bg-slate-900/20';
                            $medal = '🥈';
                        } elseif ($rank === 3) {
                            $rankStyle = 'bg-orange-400 text-white shadow-md shadow-orange-400/30 dark:bg-orange-600';
                            $rowStyle = 'bg-orange-50/30 hover:bg-orange-50/50 dark:bg-orange-900/10 dark:hover:bg-orange-900/20';
                            $medal = '🥉';
                        }
                    @endphp

                    <div class="grid grid-cols-12 items-center gap-4 px-6 py-4 transition-colors {{ $rowStyle }}">
                        <!-- Rank -->
                        <div class="col-span-2 md:col-span-1 flex justify-center">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full text-sm font-bold {{ $rankStyle }}">
                                {{ $rank }}
                            </span>
                        </div>

                        <!-- User Info -->
                        <div class="col-span-7 md:col-span-7 flex items-center gap-3">
                            <div class="relative">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-zinc-200 text-sm font-bold text-zinc-600 dark:bg-zinc-700 dark:text-zinc-200">
                                    {{ mb_substr($student->name, 0, 1) }}
                                </span>
                                @if($medal)
                                    <span class="absolute -bottom-1 -right-1 text-base leading-none drop-shadow-sm">{{ $medal }}</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate font-bold text-zinc-900 dark:text-zinc-100 {{ auth()->id() === $student->id ? 'text-emerald-600 dark:text-emerald-400' : '' }}">
                                    {{ $student->name }}
                                    @if(auth()->id() === $student->id) <span class="ml-1 text-xs font-normal text-emerald-500">(আপনি)</span> @endif
                                </p>
                            </div>
                        </div>

                        <!-- Total Tests -->
                        <div class="col-span-3 md:col-span-2 text-center">
                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                <x-heroicon-o-academic-cap class="size-3.5" /> {{ $student->mock_tests_count }}
                            </span>
                        </div>

                        <!-- Total Points -->
                        <div class="hidden md:flex md:col-span-2 items-center justify-end font-mono text-lg font-extrabold text-emerald-600 dark:text-emerald-400">
                            {{ number_format($student->total_points, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
