<div>
    
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                        <flux:icon.chart-bar class="size-6 text-indigo-500" />
                        Performance Analytics
                    </h2>
                    <p class="text-sm text-zinc-500 mt-1">Detailed subject-wise breakdown of your test history.</p>
                </div>
            </div>

            @if($subjectStats->isEmpty())
                <div class="py-12 text-center text-zinc-500 border border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl">
                    <flux:icon.document-text class="size-12 mx-auto mb-3 opacity-20" />
                    <p class="font-medium">No analytics data available yet.</p>
                    <p class="text-xs mt-1">Take some Model Tests to see your performance breakdown!</p>
                    <div class="mt-4">
                        <flux:button href="{{ route('student.model-tests.index') }}" variant="primary">Take a Model Test</flux:button>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Strong Subjects -->
                    <flux:card>
                        <h3 class="font-bold text-emerald-600 flex items-center gap-2 mb-4 border-b pb-2 border-emerald-100 dark:border-emerald-900/30">
                            <flux:icon.arrow-trending-up class="size-5" /> Strongest Subjects
                        </h3>
                        <div class="space-y-4">
                            @foreach($strongSubjects as $subject)
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium dark:text-zinc-300">{{ $subject->name }}</span>
                                        <span class="font-bold text-emerald-600">{{ $subject->accuracy }}%</span>
                                    </div>
                                    <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-2">
                                        <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $subject->accuracy }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </flux:card>

                    <!-- Weak Subjects -->
                    <flux:card>
                        <h3 class="font-bold text-rose-600 flex items-center gap-2 mb-4 border-b pb-2 border-rose-100 dark:border-rose-900/30">
                            <flux:icon.arrow-trending-down class="size-5" /> Needs Improvement
                        </h3>
                        <div class="space-y-4">
                            @foreach($weakSubjects as $subject)
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium dark:text-zinc-300">{{ $subject->name }}</span>
                                        <span class="font-bold text-rose-600">{{ $subject->accuracy }}%</span>
                                    </div>
                                    <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-2">
                                        <div class="bg-rose-500 h-2 rounded-full" style="width: {{ $subject->accuracy }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </flux:card>
                </div>

                <flux:card class="mt-6">
                    <h3 class="font-bold mb-4 border-b pb-2 dark:text-zinc-300 dark:border-zinc-800">Subject-wise Breakdown</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400">
                                <tr>
                                    <th class="px-4 py-3 font-semibold rounded-l-lg">Subject</th>
                                    <th class="px-4 py-3 font-semibold text-center">Attempted</th>
                                    <th class="px-4 py-3 font-semibold text-center text-emerald-600">Correct</th>
                                    <th class="px-4 py-3 font-semibold text-center text-rose-600">Wrong</th>
                                    <th class="px-4 py-3 font-semibold text-right rounded-r-lg">Accuracy</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                @foreach($subjectStats as $stat)
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/20 transition-colors">
                                        <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-300">{{ $stat->name }}</td>
                                        <td class="px-4 py-3 text-center">{{ $stat->total_attempted }}</td>
                                        <td class="px-4 py-3 text-center text-emerald-600 font-medium">{{ $stat->correct_answers }}</td>
                                        <td class="px-4 py-3 text-center text-rose-600 font-medium">{{ $stat->total_attempted - $stat->correct_answers }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold {{ $stat->accuracy >= 60 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : ($stat->accuracy >= 40 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400') }}">
                                                {{ $stat->accuracy }}%
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </flux:card>
            @endif
        </div>
    
</div>
