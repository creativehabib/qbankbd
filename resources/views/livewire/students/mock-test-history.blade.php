<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">আমার পরীক্ষার ইতিহাস</h1>
            <p class="text-sm text-zinc-500">আপনার দেওয়া সকল মক টেস্টের ফলাফল এবং বিস্তারিত এখানে পাবেন।</p>
        </div>
        <flux:button href="{{ route('students.practice.index') }}" variant="primary" icon="plus">
            নতুন পরীক্ষা দিন
        </flux:button>
    </div>

    @if($histories->isEmpty())
        <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-zinc-300 bg-white py-20 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:icon.document-magnifying-glass class="mb-4 size-16 text-zinc-300" />
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">এখনো কোনো পরীক্ষা দেননি</h3>
            <p class="mt-1 text-sm text-zinc-500">আপনার প্রথম মক টেস্ট শুরু করুন এবং নিজেকে যাচাই করুন।</p>
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($histories as $history)
                <div class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm transition-all hover:border-violet-300 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-violet-900/50">
                    <div class="flex flex-col h-full">
                        <div class="mb-4 flex items-start justify-between">
                            <div>
                                <span class="inline-block rounded-md bg-zinc-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                                    {{ $history->academicClass?->name ?? 'শ্রেণিহীন' }}
                                </span>
                                <h3 class="mt-1 font-bold text-zinc-900 dark:text-zinc-100 line-clamp-1">
                                    {{ $history->subject?->name ?? 'সাধারণ বিষয়' }}
                                </h3>
                            </div>
                            <div class="text-right">
                                @if($history->status === 'completed')
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                        <flux:icon.check-circle class="size-3" />
                                        COMPLETED
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-500">
                                        <flux:icon.clock class="size-3" />
                                        IN PROGRESS
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-6 grid grid-cols-2 gap-4 rounded-xl bg-zinc-50 p-3 dark:bg-zinc-800/50">
                            <div class="text-center">
                                <p class="text-[10px] text-zinc-500 uppercase font-bold">স্কোর</p>
                                <p class="text-lg font-black text-violet-600 dark:text-violet-400">
                                    {{ $history->correct_answers }}/{{ $history->total_questions }}
                                </p>
                            </div>
                            <div class="text-center border-l border-zinc-200 dark:border-zinc-700">
                                <p class="text-[10px] text-zinc-500 uppercase font-bold">তারিখ</p>
                                <p class="text-sm font-bold text-zinc-700 dark:text-zinc-300 mt-1">
                                    {{ $history->completed_at ? $history->completed_at->format('d M, y') : $history->created_at->format('d M, y') }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-auto">
                            @if($history->status === 'completed')
                                <flux:button href="{{ route('student.mock-test.result', ['testId' => $history->id]) }}" variant="filled" class="w-full !bg-zinc-900 dark:!bg-zinc-100 !text-white dark:!text-black" size="sm">
                                    রেজাল্ট দেখুন
                                </flux:button>
                            @else
                                <flux:button href="{{ route('student.mock-test.take', ['testId' => $history->id]) }}" variant="outline" class="w-full" size="sm">
                                    আবার শুরু করুন
                                </flux:button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $histories->links() }}
        </div>
    @endif
</div>
