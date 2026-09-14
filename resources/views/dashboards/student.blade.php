<x-layouts::app title="Student Dashboard">
    <div class="space-y-4 sm:space-y-5">
        {{-- Student Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="space-y-1">
                <flux:heading size="xl" class="flex items-center gap-2">
                    Welcome, {{ auth()->user()->name }}!
                    @if(auth()->user()->current_streak > 0)
                        <span class="inline-flex items-center gap-1 bg-orange-100 text-orange-600 text-sm font-bold px-2 py-0.5 rounded-full dark:bg-orange-900/30 dark:text-orange-400">
                            🔥 {{ auth()->user()->current_streak }} Day Streak
                        </span>
                    @endif
                </flux:heading>
                <flux:subheading size="lg">Ready for your next challenge?</flux:subheading>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-4">
                <a href="{{ route('students.practice.index') ?? '#' }}" class="flex flex-col items-center justify-center rounded-xl bg-white px-4 py-3 shadow-sm border border-zinc-100 hover:bg-zinc-50 dark:bg-zinc-900 dark:border-zinc-800 transition">
                    <flux:icon.play-circle class="size-6 text-emerald-500 mb-1" />
                    <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Practice</span>
                </a>
                <a href="{{ route('student.mistakes') ?? '#' }}" class="flex flex-col items-center justify-center rounded-xl bg-white px-4 py-3 shadow-sm border border-zinc-100 hover:bg-zinc-50 dark:bg-zinc-900 dark:border-zinc-800 transition">
                    <flux:icon.exclamation-circle class="size-6 text-emerald-500 mb-1" />
                    <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Mistakes</span>
                </a>
            </div>
        </div>
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-4">
                        <div class="flex flex-col gap-4">
                            <flux:card class="h-full flex flex-col justify-center relative overflow-hidden">
                                <flux:icon.clock class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800" />
                                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Study Time</p>
                                <p class="mt-2 text-2xl font-black text-zinc-900 dark:text-white">{{ $studentStats['study_time'] ?? '0m' }}</p>
                            </flux:card>
                            <flux:card class="h-full flex flex-col justify-center relative overflow-hidden">
                                <flux:icon.pencil-square class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800" />
                                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Exam Taken</p>
                                <p class="mt-2 text-2xl font-black text-zinc-900 dark:text-white">{{ $studentStats['exam_taken'] ?? 0 }}</p>
                            </flux:card>
                        </div>

                        <flux:card class="flex flex-col items-center">
                            <div class="w-full flex justify-between mb-2">
                                <h3 class="text-xs font-bold text-zinc-800 uppercase tracking-tight dark:text-zinc-200">Accuracy</h3>
                                <flux:icon.arrow-right class="size-4 text-zinc-300" />
                            </div>
                            <div id="accuracyChart" class="w-full h-32" wire:ignore></div>
                            <div class="w-full mt-4 flex justify-between text-[9px] font-bold uppercase text-zinc-400">
                                <span class="flex items-center gap-1"><span class="size-1.5 rounded-full bg-red-500"></span> {{ $studentStats['accuracy']['wrong'] ?? 0 }} Wrong</span>
                                <span class="flex items-center gap-1"><span class="size-1.5 rounded-full bg-emerald-500"></span> {{ $studentStats['accuracy']['right'] ?? 0 }} Right</span>
                                <span class="flex items-center gap-1"><span class="size-1.5 rounded-full bg-zinc-300"></span> {{ $studentStats['accuracy']['skipped'] ?? 0 }} Skipped</span>
                            </div>
                        </flux:card>

                        <flux:card class="md:col-span-2">
                            <h3 class="text-xs font-bold text-zinc-800 uppercase tracking-tight mb-4 dark:text-zinc-200">Your Engagement</h3>
                            <div id="engagementChart" class="w-full h-32" wire:ignore></div>
                        </flux:card>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 lg:grid-cols-3 mt-6">
                    <flux:card class="lg:col-span-2">
                        <div class="flex justify-between items-center border-b border-zinc-100 pb-3 dark:border-zinc-800">
                            <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100">Attended Exams</h3>
                            <a href="{{ route('student.test-history') ?? '#' }}" class="text-xs text-indigo-600 hover:underline font-medium">View All &rarr;</a>
                        </div>
                        <div class="mt-4 space-y-4">
                            @forelse($attendedExams ?? [] as $exam)
                                <div class="rounded-lg border border-zinc-100 p-4 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/20">
                                    <div class="flex justify-between">
                                        <div class="space-y-1">
                                            <h4 class="text-sm font-bold text-zinc-800 dark:text-zinc-200">
                                                <a href="{{ $exam['url'] ?? '#' }}" class="hover:underline hover:text-emerald-600">
                                                    {{ $exam['name'] }}
                                                </a>
                                            </h4>
                                            <p class="text-[10px] text-zinc-500">{{ $exam['date'] }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-black text-emerald-600">{{ $exam['score'] + 0 }}/{{ $exam['total'] }}</p>
                                            <p class="text-[10px] text-zinc-500">{{ $exam['time'] }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex justify-start gap-6 border-t border-zinc-100 pt-3 text-xs font-medium text-zinc-600 dark:border-zinc-800 dark:text-zinc-400">
                                        <span class="flex items-center gap-1.5"><span class="size-2 rounded-full bg-emerald-500"></span> {{ $exam['right'] }} Right</span>
                                        <span class="flex items-center gap-1.5"><span class="size-2 rounded-full bg-red-500"></span> {{ $exam['wrong'] }} Wrong</span>
                                        <span class="flex items-center gap-1.5"><span class="size-2 rounded-full bg-zinc-300"></span> {{ $exam['skipped'] }} Skipped</span>
                                    </div>
                                </div>
                            @empty
                                <div class="py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    No mock test attended yet.
                                </div>
                            @endforelse
                        </div>
                    </flux:card>

                    <flux:card>
                        <div class="flex justify-between items-center border-b border-zinc-100 pb-3 dark:border-zinc-800">
                            <h3 class="flex items-center gap-2 text-base font-bold {{ auth()->user()->league_icon }}">
                                <flux:icon.trophy class="size-5" /> {{ auth()->user()->league_name }}
                            </h3>
                            <a href="{{ route('student.leaderboard') ?? '#' }}" class="text-xs text-zinc-500 hover:underline font-medium">Leaderboard &rarr;</a>
                        </div>

                        <div class="mt-4 space-y-3">
                            @forelse($leaderboard as $index => $player)
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $bgClass = $index === 0 ? 'bg-amber-100 text-amber-700' : ($index === 1 ? 'bg-zinc-200 text-zinc-700' : 'bg-orange-50 text-orange-700');
                                        @endphp
                                        <span class="flex size-6 items-center justify-center rounded {{ $bgClass }} text-[10px] font-bold dark:bg-zinc-800 dark:text-zinc-400">
                                            #{{ $index + 1 }}
                                        </span>
                                        <span class="font-medium text-zinc-700 dark:text-zinc-300">
                                            {{ $player->id === auth()->id() ? 'You' : $player->name }}
                                        </span>
                                    </div>
                                    <span class="font-bold text-zinc-500">{{ $player->xp }} XP</span>
                                </div>
                            @empty
                                <div class="text-center text-xs text-zinc-500 py-4">No points earned yet.</div>
                            @endforelse
                        </div>
                    </flux:card>
                    
                    <flux:card>
                        <h3 class="font-bold text-base border-b border-zinc-100 pb-3 mb-4 dark:border-zinc-800 flex items-center gap-2">
                            <flux:icon.check-badge class="size-5 text-indigo-500" /> My Badges
                        </h3>
                        @php
                            $myBadges = auth()->user()->badges;
                        @endphp
                        @if($myBadges->isEmpty())
                            <div class="text-center text-xs text-zinc-500 py-4">
                                No badges unlocked yet. Keep practicing!
                            </div>
                        @else
                            <div class="grid grid-cols-3 gap-3">
                                @foreach($myBadges as $badge)
                                    <div class="flex flex-col items-center justify-center bg-zinc-50 dark:bg-zinc-800/50 p-2 rounded-xl text-center border border-zinc-100 dark:border-zinc-800" title="{{ $badge->description }}">
                                        <flux:icon name="{{ $badge->icon }}" class="size-8 text-{{ $badge->color }}-500 mb-1" />
                                        <span class="text-[10px] font-bold leading-tight">{{ $badge->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </flux:card>
                </div>

                @push('scripts')
                    <script>
                        var accChart = null;
                        var engChart = null;

                        function renderDashboardCharts() {
                            if (!document.querySelector("#accuracyChart") || !document.querySelector("#engagementChart")) {
                                return;
                            }

                            if(accChart) accChart.destroy();
                            if(engChart) engChart.destroy();

                            // 1. Accuracy Donut Chart
                            var accuracyOptions = {
                                series: [{{ $studentStats['accuracy']['right'] ?? 0 }}, {{ $studentStats['accuracy']['wrong'] ?? 0 }}, {{ $studentStats['accuracy']['skipped'] ?? 0 }}],
                                labels: ['Right', 'Wrong', 'Skipped'],
                                chart: { type: 'donut', height: 160, fontFamily: 'inherit' },
                                colors: ['#10b981', '#ef4444', '#d4d4d8'],
                                stroke: { show: false },
                                legend: { show: false },
                                dataLabels: { enabled: false },
                                plotOptions: {
                                    pie: {
                                        donut: {
                                            size: '75%',
                                            labels: {
                                                show: true,
                                                name: { show: true, offsetY: 20, fontSize: '10px', fontWeight: 700, color: '#9ca3af' },
                                                value: { show: true, fontSize: '22px', fontWeight: 800, offsetY: -5, color: '#18181b', formatter: function (val) { return val + " টি" } },
                                                total: {
                                                    show: true, showAlways: true, label: 'ACC.', fontSize: '10px', fontWeight: 700, color: '#9ca3af',
                                                    formatter: function (w) { return "{{ $studentStats['accuracy']['percentage'] ?? 0 }}%"; }
                                                }
                                            }
                                        }
                                    }
                                },
                                tooltip: { enabled: true, y: { formatter: function(val) { return val + " Questions" } } }
                            };
                            accChart = new ApexCharts(document.querySelector("#accuracyChart"), accuracyOptions);
                            accChart.render();

                            // 2. Engagement Area Chart
                            var engagementOptions = {
                                series: [{
                                    name: 'Exams Taken',
                                    data: {!! json_encode($studentStats['engagement']['data'] ?? []) !!}
                                }],
                                chart: { type: 'area', height: 160, toolbar: { show: false }, fontFamily: 'inherit' },
                                colors: ['#10b981'],
                                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 100] } },
                                stroke: { curve: 'smooth', width: 2 },
                                markers: { size: 4, colors: ['#fff'], strokeColors: '#10b981', strokeWidth: 2, hover: { size: 6 } },
                                xaxis: {
                                    categories: {!! json_encode($studentStats['engagement']['categories'] ?? []) !!},
                                    labels: { style: { colors: '#9ca3af', fontSize: '10px', fontWeight: 500 }, hideOverlappingLabels: true },
                                    axisBorder: { show: false },
                                    axisTicks: { show: false }
                                },
                                yaxis: { show: false },
                                grid: { borderColor: '#f4f4f5', strokeDashArray: 4, yaxis: { lines: { show: true } } },
                                dataLabels: { enabled: false },
                                tooltip: { theme: 'light', x: { show: true } }
                            };
                            engChart = new ApexCharts(document.querySelector("#engagementChart"), engagementOptions);
                            engChart.render();
                        }

                        document.addEventListener('DOMContentLoaded', renderDashboardCharts);
                        document.addEventListener('livewire:navigated', renderDashboardCharts);
                    </script>
                @endpush
    </div>
</x-layouts::app>
