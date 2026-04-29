<div class="mx-auto w-full max-w-6xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">আমার তৈরি প্রশ্ন</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">আপনার তৈরি করা সব Question Set এখান থেকে দেখতে পারবেন।</p>
        </div>

        <a href="{{ route('question.set-create') }}" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700" wire:navigate>
            + নতুন তৈরি করুন
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 text-sm dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800/60">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">SL</th>
                        <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">Paper Details</th>
                        <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">Type Count</th>
                        <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">Created At</th>
                        <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($questionSets as $questionSet)
                        <tr>
                            <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $questionSet->name }}</p>
                                <p class="text-xs text-zinc-500">ID: {{ $questionSet->id }}</p>
                            </td>
                            <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                @php
                                    $typeCounts = $questionSet->questions
                                        ->groupBy('question_type')
                                        ->map(fn ($questionsByType) => $questionsByType->count());
                                @endphp

                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($typeCounts as $type => $count)
                                        <span class="inline-flex items-center rounded-md bg-zinc-100 px-2 py-1 text-xs font-semibold uppercase text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">
                                            {{ $type }}: {{ $count }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-zinc-500">No questions</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">{{ $questionSet->created_at?->format('d M, Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('questions.view', ['qset' => $questionSet->id]) }}" class="inline-flex items-center rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-100 dark:border-zinc-600 dark:text-zinc-200 dark:hover:bg-zinc-800" wire:navigate>
                                        দেখুন
                                    </a>
                                    <a href="{{ route('questions.paper', ['qset' => $questionSet->id]) }}" class="inline-flex items-center rounded-md bg-zinc-900 px-3 py-1.5 text-xs font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300" wire:navigate>
                                        Paper
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-zinc-500 dark:text-zinc-400">এখনো কোনো প্রশ্নসেট তৈরি করা হয়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
