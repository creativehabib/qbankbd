<x-layouts::app :title="$panelTitle ?? 'Dashboard'">
    <div class="space-y-4 sm:space-y-5">

        @if(auth()->user()?->hasRole('teacher'))
            {{-- ─── TEACHER DASHBOARD VIEW ────────────────────────────────────── --}}
            <flux:card>
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="space-y-1">
                        <flux:heading size="xl">{{ auth()->user()?->institution_name ?: $welcomeTitle }}</flux:heading>
                        <flux:subheading size="lg">{{ auth()->user()?->institution_address ?: 'Add Institution Address' }}</flux:subheading>
                    </div>

                    <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                        <flux:button href="{{ route('profile.edit') }}" variant="primary">Update Profile</flux:button>
                        <flux:button href="#" variant="outline">Institution Details</flux:button>
                    </div>
                </div>
            </flux:card>

            <flux:card>
                <div class="space-y-2 text-center">
                    <flux:heading size="xl">Create Questions</flux:heading>
                    <flux:subheading>Use the E-Question Builder to create custom question papers for academic, admission, and job preparations.</flux:subheading>
                </div>

                <div
                    x-data="{ selectedClass: '', selectedSubject: '', classes: {{ Js::from(($academicClasses ?? collect())->map(fn ($class) => ['id' => (string) $class->id, 'name' => $class->name, 'subjects' => $class->subjects->map(fn ($subject) => ['id' => (string) $subject->id, 'name' => $subject->name])->values()])->values()) }}, get filteredSubjects() { if (!this.selectedClass) { return []; } const foundClass = this.classes.find((item) => item.id === this.selectedClass); return foundClass ? foundClass.subjects : []; } }"
                    class="mt-6 rounded-xl border border-dashed border-zinc-300 p-4 dark:border-zinc-700"
                >
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex flex-wrap gap-2">
                            <template x-for="academicClass in classes" :key="academicClass.id">
                                <button
                                    type="button"
                                    @click="selectedClass = academicClass.id; selectedSubject = '';"
                                    class="rounded-full border px-4 py-2 text-sm font-semibold transition-all shadow-sm"
                                    :class="selectedClass === academicClass.id ? 'border-indigo-600 bg-indigo-600 text-white shadow-indigo-200 dark:shadow-none' : 'border-zinc-200 bg-white text-zinc-600 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700'"
                                    x-text="academicClass.name"
                                ></button>
                            </template>
                        </div>

                        <div class="flex w-full flex-col gap-2 sm:flex-row lg:w-auto">
                            <select x-model="selectedSubject" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 sm:min-w-80">
                                <option value="">Select Subject</option>
                                <template x-for="subject in filteredSubjects" :key="subject.id">
                                    <option :value="subject.id" x-text="subject.name"></option>
                                </template>
                            </select>

                            <a
                                :href="selectedSubject ? `{{ route('question.set-create') ?? '#' }}?subject_id=${selectedSubject}` : '#'"
                                class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-bold shadow-sm transition-all sm:min-w-32"
                                :class="selectedSubject ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'cursor-not-allowed bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-600'"
                            >Next Step &rarr;</a>
                        </div>
                    </div>
                </div>
            </flux:card>

            <flux:card>
                <div class="space-y-1 mb-6 text-center">
                    <flux:heading size="lg">Dashboard Overview</flux:heading>
                    <flux:subheading>{{ $description }}</flux:subheading>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-xl border border-zinc-100 bg-zinc-50/50 p-5 dark:border-zinc-700/50 dark:bg-zinc-800/50">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Questions</p>
                        <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-zinc-100">{{ $teacherStats['total_question_sets'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-zinc-100 bg-zinc-50/50 p-5 dark:border-zinc-700/50 dark:bg-zinc-800/50">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total MCQ</p>
                        <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-zinc-100">{{ $teacherStats['total_mcq_questions'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-zinc-100 bg-zinc-50/50 p-5 dark:border-zinc-700/50 dark:bg-zinc-800/50">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Written</p>
                        <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-zinc-100">{{ $teacherStats['total_written_questions'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-zinc-100 bg-zinc-50/50 p-5 dark:border-zinc-700/50 dark:bg-zinc-800/50">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Cost</p>
                        <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-zinc-100">৳ {{ number_format($teacherStats['total_cost'] ?? 0, 2) }}</p>
                    </div>
                </div>
            </flux:card>

        @else
            {{-- ─── NON-TEACHER ROLES (STUDENT / ADMIN) ────────────────────────── --}}
            @if(auth()->user()?->hasRole('student'))
                {{-- ─── STUDENT DASHBOARD VIEW ────────────────────────────────── --}}
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex flex-wrap gap-2 sm:gap-4">
                        <a href="{{ route('students.practice.index') ?? '#' }}" class="flex flex-col items-center justify-center rounded-xl bg-white px-4 py-3 shadow-sm border border-zinc-100 hover:bg-zinc-50 dark:bg-zinc-900 dark:border-zinc-800 transition">
                            <flux:icon.play-circle class="size-6 text-emerald-500 mb-1" />
                            <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Practice</span>
                        </a>
                        <a href="{{ route('student.mistakes') ?? '#' }}" class="flex flex-col items-center justify-center rounded-xl bg-white px-4 py-3 shadow-sm border border-zinc-100 hover:bg-zinc-50 dark:bg-zinc-900 dark:border-zinc-800 transition">
                            <flux:icon.exclamation-circle class="size-6 text-emerald-500 mb-1" />
                            <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Mistakes</span>
                        </a>
                        <a href="{{ route('student.test-history') ?? '#' }}" class="flex flex-col items-center justify-center rounded-xl bg-white px-4 py-3 shadow-sm border border-zinc-100 hover:bg-zinc-50 dark:bg-zinc-900 dark:border-zinc-800 transition">
                            <flux:icon.clock class="size-6 text-emerald-500 mb-1" />
                            <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">History</span>
                        </a>
                    </div>

                    <div class="flex items-center justify-between rounded-xl border border-orange-200 bg-orange-50 px-5 py-4 shadow-sm dark:bg-orange-900/20 dark:border-orange-900/30 min-w-72">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">🔥</div>
                            <div>
                                <h3 class="text-sm font-bold text-orange-900 dark:text-orange-400">Current Streak</h3>
                                <p class="text-xl font-black text-orange-600">{{ $studentStats['streak_days'] ?? 0 }} <span class="text-sm font-medium">Day</span></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-medium text-zinc-500">Rank: #{{ $studentStats['rank'] ?? 0 }}</span>
                            <p class="text-[10px] text-zinc-400 mt-1">Practice some MCQ to start!</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-4 mt-6">
                        <flux:heading size="lg">Your Study Stats Last {{ $range ?? 7 }} Days</flux:heading>

                        <div class="flex items-center gap-1 bg-zinc-100 p-1 rounded-lg dark:bg-zinc-800">
                            <a href="?range=7" wire:navigate class="rounded px-3 py-1 text-[10px] font-bold transition {{ ($range ?? 7) == 7 ? 'bg-emerald-500 text-white shadow-sm' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400' }}">7D</a>
                            <a href="?range=15" wire:navigate class="rounded px-3 py-1 text-[10px] font-bold transition {{ ($range ?? 7) == 15 ? 'bg-emerald-500 text-white shadow-sm' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400' }}">15D</a>
                            <a href="?range=30" wire:navigate class="rounded px-3 py-1 text-[10px] font-bold transition {{ ($range ?? 7) == 30 ? 'bg-emerald-500 text-white shadow-sm' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400' }}">30D</a>
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
                                                <a href="{{ route('student.mock-test.result', ['testId' => $exam['id']]) ?? '#' }}" class="hover:underline hover:text-emerald-600">
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
            @else
                {{-- ─── ADMIN DASHBOARD VIEW (ADVANCED CONTEXT) ────────────────── --}}
                <div class="space-y-6">

                    {{-- ১. Overview Counters --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <flux:card class="relative overflow-hidden group">
                            <div class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800 opacity-20 transition-transform group-hover:scale-110">
                                <flux:icon.document-text class="size-12" />
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Total Questions</p>
                            <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-white">
                                {{ number_format($adminStats['total_questions'] ?? 0) }}
                                @if(($adminStats['today_questions'] ?? 0) > 0)
                                    <flux:badge size="sm" color="emerald" class="ml-1">+{{ $adminStats['today_questions'] }} today</flux:badge>
                                @endif
                            </p>
                        </flux:card>

                        <flux:card class="relative overflow-hidden group">
                            <div class="absolute -right-2 -top-2 size-12 text-amber-100 dark:text-amber-900 opacity-20 transition-transform group-hover:scale-110">
                                <flux:icon.clock class="size-12" />
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Pending Reviews</p>
                            <p class="mt-2 text-3xl font-black {{ ($adminStats['pending_reviews'] ?? 0) > 0 ? 'text-amber-500' : 'text-zinc-400' }}">
                                {{ $adminStats['pending_reviews'] ?? 0 }}
                            </p>
                        </flux:card>

                        <flux:card class="relative overflow-hidden group">
                            <div class="absolute -right-2 -top-2 size-12 text-rose-100 dark:text-rose-900 opacity-20 transition-transform group-hover:scale-110">
                                <flux:icon.banknotes class="size-12" />
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Pending Withdrawals</p>
                            <p class="mt-2 text-3xl font-black {{ ($pendingWithdrawSum ?? 0) > 0 ? 'text-rose-500' : 'text-zinc-400' }}">
                                ৳{{ number_format($pendingWithdrawSum ?? 0, 2) }}
                            </p>
                        </flux:card>

                        <flux:card class="relative overflow-hidden group">
                            <div class="absolute -right-2 -top-2 size-12 text-emerald-100 dark:text-emerald-900 opacity-20 transition-transform group-hover:scale-110">
                                <flux:icon.adjustments-horizontal class="size-12" />
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">OMR Evaluations</p>
                            <p class="mt-2 text-3xl font-black text-emerald-600 dark:text-emerald-400">
                                {{ number_format($adminStats['total_omr_evaluations'] ?? 0) }}
                                @if(isset($omrStats['started']) && $omrStats['started'] > 0)
                                    <span class="text-[10px] font-medium text-zinc-400 block mt-0.5">Running OMR Exams: {{ $omrStats['started'] }}</span>
                                @endif
                            </p>
                        </flux:card>
                    </div>

                    {{-- 2. Class-wise Question Distribution & Top Contributors --}}
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                        <flux:card class="lg:col-span-2 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800">
                                    <flux:icon.chart-pie class="size-5 text-indigo-500" />
                                    <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-tight">Class-wise Question Distribution</h3>
                                </div>
                                <div class="mt-4 space-y-4 max-h-60 overflow-y-auto pr-1">
                                    @forelse($classWiseDistribution ?? [] as $class)
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-xs font-medium">
                                                <span class="text-zinc-700 dark:text-zinc-300 font-semibold">{{ $class->name }}</span>
                                                <span class="text-zinc-500">{{ $class->questions_count }} questions</span>
                                            </div>
                                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-2 rounded-full overflow-hidden">
                                                @php
                                                    $percentage = $adminStats['total_questions'] > 0 ? ($class->questions_count / $adminStats['total_questions']) * 100 : 0;
                                                @endphp
                                                <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-xs text-zinc-500 py-8">No data available.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-zinc-100 dark:border-zinc-800 flex justify-between text-[11px] font-semibold text-zinc-400 uppercase">
                                <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-blue-500"></span> {{ $adminStats['total_teachers'] ?? 0 }} Teachers</span>
                                <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-emerald-500"></span> {{ $adminStats['total_students'] ?? 0 }} Students</span>
                                <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-zinc-400"></span> {{ $adminStats['total_users'] ?? 0 }} Accounts</span>
                            </div>
                        </flux:card>

                        <flux:card class="flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800">
                                    <flux:icon.trophy class="size-5 text-amber-500" />
                                    <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-tight">Top Contributors (Teachers)</h3>
                                </div>
                                <div class="mt-4 space-y-3">
                                    @forelse($topTeachers ?? [] as $index => $teacher)
                                        <div class="flex items-center justify-between text-xs">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <span class="flex size-5 shrink-0 items-center justify-center rounded-md bg-amber-50 dark:bg-amber-950/30 text-amber-700 text-[10px] font-bold">
                                                    #{{ $index + 1 }}
                                                </span>
                                                <span class="font-medium text-zinc-700 dark:text-zinc-300 truncate" title="{{ $teacher->user?->name }}">
                                                    {{ $teacher->user?->name ?? 'Unknown Teacher' }}
                                                </span>
                                            </div>
                                            <span class="font-bold text-zinc-500 shrink-0 ml-2">{{ $teacher->total_added }} added</span>
                                        </div>
                                    @empty
                                        <div class="text-center text-xs text-zinc-500 py-4">No questions added yet.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="mt-6 space-y-2">
                                <h4 class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 mb-1">Quick Links</h4>
                                <flux:button href="{{ route('questions.index') }}" class="w-full justify-center">
                                    <flux:icon.check-circle class="size-4" /> Moderate New Questions
                                </flux:button>
                                <flux:button href="{{ route('admin.wallet-approvals') }}" variant="outline" class="w-full justify-center">
                                    <flux:icon.wallet class="size-4" /> Wallet & Token Requests
                                </flux:button>
                            </div>
                        </flux:card>
                    </div>

                    {{-- 3. Advanced Content Health and Error Alerts --}}
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <flux:card>
                            <div class="flex items-center gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800 mb-3">
                                <flux:icon.exclamation-circle class="size-5 text-amber-500" />
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-tight">
                                    Low Content Chapters
                                </h3>
                            </div>
                            <ul class="divide-y divide-zinc-100 dark:divide-zinc-800 text-xs">
                                @forelse($weakChapters ?? [] as $chapter)
                                    <li class="py-2.5 flex justify-between items-center">
                                        <span class="text-zinc-700 dark:text-zinc-300 font-medium">{{ $chapter->name }}</span>
                                        <flux:badge size="sm" color="amber">{{ $chapter->questions_count }} Questions</flux:badge>
                                    </li>
                                @empty
                                    <div class="text-center text-xs text-zinc-400 py-6">All chapters have enough questions! 👍</div>
                                @endforelse
                            </ul>
                        </flux:card>

                        <flux:card>
                            <div class="flex items-center gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800 mb-3">
                                <flux:icon.flag class="size-5 text-red-500" />
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-tight">
                                    Critical Question Errors
                                </h3>
                            </div>
                            <div class="mt-4 space-y-4 max-h-[350px] overflow-y-auto pr-1">
                                @forelse($criticalAlerts ?? [] as $alert)
                                    <div class="p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/20 space-y-2">
                                        <div class="flex justify-between items-start gap-2">
                                            <div class="min-w-0 flex-1">
                                                <p class="text-zinc-800 dark:text-zinc-200 font-bold text-xs truncate">
                                                    {{ Str::limit(strip_tags($alert->question->title ?? 'Question Not Found'), 55) }}
                                                </p>
                                                <span class="text-[10px] text-zinc-400 block mt-0.5">
                                                    👨‍🏫 Teacher: <span class="font-semibold text-zinc-500 dark:text-zinc-400">{{ $alert->question->user->name ?? 'Unknown' }}</span>
                                                </span>
                                            </div>
                                            <flux:button href="{{ route('questions.edit', $alert->question_id) }}" size="sm" variant="outline" class="shrink-0">
                                                Fix It &rarr;
                                            </flux:button>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-1.5 pt-1 text-[10px] font-medium">
                                            @php
                                                $reasonLabels = [
                                                    'wrong_answer' => 'Wrong Answer',
                                                    'typing_mistake' => 'Typing Mistake',
                                                    'wrong_explanation' => 'Wrong Explanation',
                                                    'blurry_image' => 'Blurry Image',
                                                    'other' => 'Other'
                                                ];
                                            @endphp
                                            <flux:badge size="sm" color="{{ $alert->reason === 'wrong_answer' ? 'red' : 'amber' }}">
                                                ⚠️ {{ $reasonLabels[$alert->reason] ?? 'Other' }}
                                            </flux:badge>
                                            <span class="text-zinc-400">by {{ $alert->user->name ?? 'Student' }}</span>
                                        </div>

                                        @if(filled($alert->description))
                                            <div class="bg-white dark:bg-zinc-900 border border-dashed border-zinc-200 dark:border-zinc-800 p-2 rounded text-[11px] text-zinc-600 dark:text-zinc-400 italic">
                                                "{{ $alert->description }}"
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center text-xs text-zinc-400 py-8">No reported question errors, database content is healthy! ✨</div>
                                @endforelse
                            </div>
                        </flux:card>
                    </div>

                </div>
            @endif
        @endif
    </div>
</x-layouts::app>
