<x-layouts::app :title="$panelTitle ?? 'Dashboard'">
    <div class="space-y-4 sm:space-y-5">

        @if(auth()->user()?->hasRole('teacher'))
            {{-- ─── TEACHER DASHBOARD VIEW ────────────────────────────────────── --}}
            <section class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="space-y-1">
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 sm:text-xl">{{ auth()->user()?->institution_name ?: $welcomeTitle }}</h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ auth()->user()?->institution_address ?: 'প্রতিষ্ঠানের ঠিকানা যোগ করুন' }}</p>
                    </div>

                    <div class="grid w-full grid-cols-1 gap-2 sm:w-auto sm:grid-cols-2">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">তথ্য পরিবর্তন</a>
                        <a href="#" class="inline-flex items-center justify-center rounded-lg border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700">প্রতিষ্ঠান তথ্য</a>
                    </div>
                </div>
            </section>

            <section class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">
                <div class="space-y-2 text-center">
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">প্রশ্ন তৈরি করুন</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">E-Question Builder ব্যবহার করে একাডেমিক, ভর্তি ও চাকরির প্রস্তুতির জন্য নিজের প্রশ্নপত্র তৈরি করুন।</p>
                </div>

                <div
                    x-data="{ selectedClass: '', selectedSubject: '', classes: {{ Js::from(($academicClasses ?? collect())->map(fn ($class) => ['id' => (string) $class->id, 'name' => $class->name, 'subjects' => $class->subjects->map(fn ($subject) => ['id' => (string) $subject->id, 'name' => $subject->name])->values()])->values()) }}, get filteredSubjects() { if (!this.selectedClass) { return []; } const foundClass = this.classes.find((item) => item.id === this.selectedClass); return foundClass ? foundClass.subjects : []; } }"
                    class="mt-4 rounded-xl border border-dashed border-zinc-300 p-3 sm:p-4"
                >
                    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex flex-wrap gap-2">
                            <template x-for="academicClass in classes" :key="academicClass.id">
                                <button
                                    type="button"
                                    @click="selectedClass = academicClass.id; selectedSubject = '';"
                                    class="rounded-full border px-2 py-1.5 text-sm font-medium"
                                    :class="selectedClass === academicClass.id ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-zinc-300 text-zinc-700'"
                                    x-text="academicClass.name"
                                ></button>
                            </template>
                        </div>

                        <div class="flex w-full flex-col gap-2 sm:flex-row lg:w-auto">
                            <select x-model="selectedSubject" class="w-full rounded-lg border border-zinc-300 px-2 py-1.5 text-sm text-zinc-700 sm:min-w-80">
                                <option value="">Select Subject</option>
                                <template x-for="subject in filteredSubjects" :key="subject.id">
                                    <option :value="subject.id" x-text="subject.name"></option>
                                </template>
                            </select>

                            <a
                                :href="selectedSubject ? `{{ route('question.set-create') ?? '#' }}?subject_id=${selectedSubject}` : '#'"
                                class="inline-flex items-center justify-center rounded-lg px-2 py-1.5 text-sm font-semibold sm:min-w-32"
                                :class="selectedSubject ? 'bg-indigo-600 text-white' : 'cursor-not-allowed bg-indigo-200 text-white'"
                            >পরবর্তী ধাপ →</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">
                <div class="space-y-2 text-center">
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 sm:text-2xl">{{ __('ড্যাশবোর্ড ওভারভিউ') }}</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</p>
                </div>

                <div class="mt-4 grid grid-cols-1 gap-3 sm:mt-5 sm:grid-cols-2 lg:grid-cols-4 sm:gap-4">
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('মোট প্রশ্ন') }}</p>
                        <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $teacherStats['total_question_sets'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('মোট MCQ প্রশ্ন') }}</p>
                        <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $teacherStats['total_mcq_questions'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('মোট লিখিত প্রশ্ন') }}</p>
                        <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $teacherStats['total_written_questions'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('মোট খরচ') }}</p>
                        <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">৳ {{ number_format($teacherStats['total_cost'] ?? 0, 2) }}</p>
                    </div>
                </div>
            </section>

        @else
            {{-- ─── NON-TEACHER ROLES (STUDENT / ADMIN) ────────────────────────── --}}
            @if(auth()->user()?->hasRole('student'))
                {{-- ─── STUDENT DASHBOARD VIEW ────────────────────────────────── --}}
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex flex-wrap gap-2 sm:gap-4">
                        <a href="{{ route('students.practice.index') ?? '#' }}" class="flex flex-col items-center justify-center rounded-xl bg-white px-4 py-3 shadow-sm border border-zinc-100 hover:bg-zinc-50 dark:bg-zinc-900 dark:border-zinc-800">
                            <flux:icon.play-circle class="size-6 text-emerald-500 mb-1" />
                            <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Practice</span>
                        </a>
                        <a href="{{ route('student.mistakes') ?? '#' }}" class="flex flex-col items-center justify-center rounded-xl bg-white px-4 py-3 shadow-sm border border-zinc-100 hover:bg-zinc-50 dark:bg-zinc-900 dark:border-zinc-800">
                            <flux:icon.exclamation-circle class="size-6 text-emerald-500 mb-1" />
                            <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Mistakes</span>
                        </a>
                        <a href="{{ route('student.test-history') ?? '#' }}" class="flex flex-col items-center justify-center rounded-xl bg-white px-4 py-3 shadow-sm border border-zinc-100 hover:bg-zinc-50 dark:bg-zinc-900 dark:border-zinc-800">
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
                    <div class="flex items-center justify-between mb-4 mt-5">
                        <h2 class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Your Study Stats Last {{ $range ?? 7 }} Days</h2>

                        <div class="flex items-center gap-1 bg-zinc-100 p-1 rounded-lg dark:bg-zinc-800">
                            <a href="?range=7" wire:navigate class="rounded px-3 py-1 text-[10px] font-bold transition {{ ($range ?? 7) == 7 ? 'bg-emerald-500 text-white shadow-sm' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400' }}">7D</a>
                            <a href="?range=15" wire:navigate class="rounded px-3 py-1 text-[10px] font-bold transition {{ ($range ?? 7) == 15 ? 'bg-emerald-500 text-white shadow-sm' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400' }}">15D</a>
                            <a href="?range=30" wire:navigate class="rounded px-3 py-1 text-[10px] font-bold transition {{ ($range ?? 7) == 30 ? 'bg-emerald-500 text-white shadow-sm' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400' }}">30D</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-4">
                        <div class="flex flex-col gap-4">
                            <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 h-full flex flex-col justify-center relative overflow-hidden">
                                <flux:icon.clock class="absolute -right-2 -top-2 size-12 text-zinc-50 opacity-10 dark:text-white" />
                                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Study Time</p>
                                <p class="mt-2 text-2xl font-black text-zinc-900 dark:text-white">{{ $studentStats['study_time'] ?? '0m' }}</p>
                            </div>
                            <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 h-full flex flex-col justify-center relative overflow-hidden">
                                <flux:icon.pencil-square class="absolute -right-2 -top-2 size-12 text-zinc-50 opacity-10 dark:text-white" />
                                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Exam Taken</p>
                                <p class="mt-2 text-2xl font-black text-zinc-900 dark:text-white">{{ $studentStats['exam_taken'] ?? 0 }}</p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 flex flex-col items-center">
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
                        </div>

                        <div class="md:col-span-2 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                            <h3 class="text-xs font-bold text-zinc-800 uppercase tracking-tight mb-4 dark:text-zinc-200">Your Engagement</h3>
                            <div id="engagementChart" class="w-full h-32" wire:ignore></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 lg:grid-cols-3 mt-5">
                    <div class="col-span-1 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 lg:col-span-2">
                        <div class="flex justify-between items-center border-b border-zinc-100 pb-3 dark:border-zinc-800">
                            <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100">Attended Exams</h3>
                            <a href="{{ route('student.test-history') ?? '#' }}" class="text-xs text-indigo-600 hover:underline">View All →</a>
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
                                    এখনো কোনো মক টেস্ট দেওয়া হয়নি।
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="col-span-1 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="flex justify-between items-center border-b border-zinc-100 pb-3 dark:border-zinc-800">
                            <h3 class="flex items-center gap-2 text-base font-bold {{ auth()->user()->league_icon }}">
                                <flux:icon.trophy class="size-5" /> {{ auth()->user()->league_name }}
                            </h3>
                            <a href="{{ route('student.leaderboard') ?? '#' }}" class="text-xs text-zinc-500 hover:underline">Leaderboard →</a>
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
                                <div class="text-center text-xs text-zinc-500 py-4">এখনো কেউ পয়েন্ট পায়নি।</div>
                            @endforelse
                        </div>
                    </div>
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

                    {{-- ১. কুইক স্ট্যাটস কাউন্টার (Overview Counters) --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 relative overflow-hidden group">
                            <div class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800 opacity-20 transition-transform group-hover:scale-110">
                                <flux:icon.document-text class="size-12" />
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">{{ __('মোট প্রশ্ন সংখ্যা') }}</p>
                            <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-white">
                                {{ number_format($adminStats['total_questions'] ?? 0) }}
                                @if(($adminStats['today_questions'] ?? 0) > 0)
                                    <span class="text-xs font-bold text-emerald-500 ml-1 bg-emerald-50 dark:bg-emerald-950/30 px-1.5 py-0.5 rounded">+{{ $adminStats['today_questions'] }} আজ</span>
                                @endif
                            </p>
                        </div>

                        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 relative overflow-hidden group">
                            <div class="absolute -right-2 -top-2 size-12 text-amber-100 dark:text-amber-900 opacity-20 transition-transform group-hover:scale-110">
                                <flux:icon.clock class="size-12" />
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">{{ __('পেন্ডিং রিভিউ') }}</p>
                            <p class="mt-2 text-3xl font-black {{ ($adminStats['pending_reviews'] ?? 0) > 0 ? 'text-amber-500' : 'text-zinc-400' }}">
                                {{ $adminStats['pending_reviews'] ?? 0 }} <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">টি</span>
                            </p>
                        </div>

                        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 relative overflow-hidden group">
                            <div class="absolute -right-2 -top-2 size-12 text-rose-100 dark:text-rose-900 opacity-20 transition-transform group-hover:scale-110">
                                <flux:icon.banknotes class="size-12" />
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">{{ __('পেন্ডিং উইথড্রাল') }}</p>
                            <p class="mt-2 text-3xl font-black {{ ($pendingWithdrawSum ?? 0) > 0 ? 'text-rose-500' : 'text-zinc-400' }}">
                                ৳{{ number_format($pendingWithdrawSum ?? 0, 2) }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 relative overflow-hidden group">
                            <div class="absolute -right-2 -top-2 size-12 text-emerald-100 dark:text-emerald-900 opacity-20 transition-transform group-hover:scale-110">
                                <flux:icon.adjustments-horizontal class="size-12" />
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">{{ __('OMR এভালুয়েশন') }}</p>
                            <p class="mt-2 text-3xl font-black text-emerald-600 dark:text-emerald-400">
                                {{ number_format($adminStats['total_omr_evaluations'] ?? 0) }}
                                @if(isset($omrStats['started']) && $omrStats['started'] > 0)
                                    <span class="text-[10px] font-medium text-zinc-400 block mt-0.5">রানিং/চলতি ওএমআর পরীক্ষা: {{ $omrStats['started'] }} টি</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- ২. শ্রেণিভিত্তিক প্রশ্ন বন্টন এবং টপ কন্ট্রিবিউটর শিক্ষক --}}
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                        <div class="lg:col-span-2 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800">
                                    <flux:icon.chart-pie class="size-5 text-indigo-500" />
                                    <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-tight">{{ __('শ্রেণিভিত্তিক প্রশ্ন বন্টন') }}</h3>
                                </div>
                                <div class="mt-4 space-y-4 max-h-60 overflow-y-auto pr-1">
                                    @forelse($classWiseDistribution ?? [] as $class)
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-xs font-medium">
                                                <span class="text-zinc-700 dark:text-zinc-300 font-semibold">{{ $class->name }}</span>
                                                <span class="text-zinc-500">{{ $class->questions_count }} টি প্রশ্ন</span>
                                            </div>
                                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-2 rounded-full overflow-hidden">
                                                @php
                                                    $percentage = $adminStats['total_questions'] > 0 ? ($class->questions_count / $adminStats['total_questions']) * 100 : 0;
                                                @endphp
                                                <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-xs text-zinc-500 py-8">{{ __('কোনো ডেটা পাওয়া যায়নি।') }}</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-zinc-100 dark:border-zinc-800 flex justify-between text-[11px] font-semibold text-zinc-400 uppercase">
                                <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-blue-500"></span> {{ $adminStats['total_teachers'] ?? 0 }} জন শিক্ষক</span>
                                <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-emerald-500"></span> {{ $adminStats['total_students'] ?? 0 }} জন শিক্ষার্থী</span>
                                <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-zinc-400"></span> {{ $adminStats['total_users'] ?? 0 }} মোট অ্যাকাউন্ট</span>
                            </div>
                        </div>

                        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800">
                                    <flux:icon.trophy class="size-5 text-amber-500" />
                                    <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-tight">{{ __('সেরা কন্ট্রিবিউটর (শিক্ষক)') }}</h3>
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
                                            <span class="font-bold text-zinc-500 shrink-0 ml-2">{{ $teacher->total_added }} টি প্রশ্ন</span>
                                        </div>
                                    @empty
                                        <div class="text-center text-xs text-zinc-500 py-4">{{ __('এখনো কেউ প্রশ্ন যুক্ত করেনি।') }}</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="mt-6 space-y-2">
                                <h4 class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 mb-1">{{ __('দ্রুত অ্যাকশন লিংক') }}</h4>
                                <a href="{{ route('questions.index') }}" class="flex w-full items-center justify-center gap-1.5 rounded-lg bg-zinc-900 py-2 text-xs font-semibold text-white dark:bg-zinc-100 dark:text-zinc-900 hover:bg-zinc-800 dark:hover:bg-zinc-200 transition shadow-sm">
                                    <flux:icon.check-circle class="size-4" /> {{ __('নতুন প্রশ্ন মডারেট করুন') }}
                                </a>
                                <a href="{{ route('admin.wallet-approvals') }}" class="flex w-full items-center justify-center gap-1.5 rounded-lg border border-zinc-300 py-2 text-xs font-semibold text-zinc-700 dark:border-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                                    <flux:icon.wallet class="size-4" /> {{ __('ওয়ালেট ও টোকেন রিকোয়েস্ট') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- ৩. অ্যাডভান্সড কন্টেন্ট হেলথ এবং ভুল রিপোর্টেড প্রশ্ন অ্যালার্ট গ্রিড (স্টুডেন্ট ফিডব্যাক সহ) --}}
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                            <div class="flex items-center gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800 mb-3">
                                <flux:icon.exclamation-circle class="size-5 text-amber-500" />
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-tight">
                                    {{ __('প্রশ্ন বাড়াতে হবে (Low Content Chapters)') }}
                                </h3>
                            </div>
                            <ul class="divide-y divide-zinc-100 dark:divide-zinc-800 text-xs">
                                @forelse($weakChapters ?? [] as $chapter)
                                    <li class="py-2.5 flex justify-between items-center">
                                        <span class="text-zinc-700 dark:text-zinc-300 font-medium">{{ $chapter->name }}</span>
                                        <span class="rounded-full bg-amber-50 dark:bg-amber-950/40 px-2 py-0.5 font-bold text-amber-600 dark:text-amber-400">
                                            {{ $chapter->questions_count }} টি প্রশ্ন
                                        </span>
                                    </li>
                                @empty
                                    <div class="text-center text-xs text-zinc-400 py-6">সব চ্যাপ্টারে পর্যাপ্ত প্রশ্ন আছে! 👍</div>
                                @endforelse
                            </ul>
                        </div>

                        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                            <div class="flex items-center gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800 mb-3">
                                <flux:icon.flag class="size-5 text-red-500" />
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-tight">
                                    {{ __('জরুরি সংশোধন প্রয়োজন (Critical Question Errors)') }}
                                </h3>
                            </div>
                            <div class="mt-4 space-y-4 max-h-[350px] overflow-y-auto pr-1">
                                @forelse($criticalAlerts ?? [] as $alert)
                                    <div class="p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/20 space-y-2">
                                        <div class="flex justify-between items-start gap-2">
                                            <div class="min-w-0 flex-1">
                                                <p class="text-zinc-800 dark:text-zinc-200 font-bold text-xs truncate">
                                                    {{ Str::limit(strip_tags($alert->question->title ?? 'প্রশ্ন পাওয়া যায়নি'), 55) }}
                                                </p>
                                                <span class="text-[10px] text-zinc-400 block mt-0.5">
                                                    👨‍🏫 শিক্ষক: <span class="font-semibold text-zinc-500 dark:text-zinc-400">{{ $alert->question->user->name ?? 'Unknown' }}</span>
                                                </span>
                                            </div>
                                            <a href="{{ route('questions.edit', $alert->question_id) }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline shrink-0 text-[10px] bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 px-2 py-1 rounded shadow-sm">
                                                {{ __('ঠিক করুন') }} →
                                            </a>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-1.5 pt-1 text-[10px] font-medium">
                                            @php
                                                $reasonLabels = [
                                                    'wrong_answer' => 'ভুল উত্তর',
                                                    'typing_mistake' => 'বানান ভুল',
                                                    'wrong_explanation' => 'ভুল ব্যাখ্যা',
                                                    'blurry_image' => 'অস্পষ্ট ছবি',
                                                    'other' => 'অন্যান্য'
                                                ];
                                                $reasonClass = $alert->reason === 'wrong_answer' ? 'bg-red-50 text-red-600 dark:bg-red-950/30' : 'bg-amber-50 text-amber-600 dark:bg-amber-950/30';
                                            @endphp
                                            <span class="px-2 py-0.5 rounded font-bold uppercase tracking-wide {{ $reasonClass }}">
                                                ⚠️ {{ $reasonLabels[$alert->reason] ?? 'অন্যান্য' }}
                                            </span>
                                            <span class="text-zinc-400">by {{ $alert->user->name ?? 'Student' }}</span>
                                        </div>

                                        @if(filled($alert->description))
                                            <div class="bg-white dark:bg-zinc-900 border border-dashed border-zinc-200 dark:border-zinc-800 p-2 rounded text-[11px] text-zinc-600 dark:text-zinc-400 italic">
                                                "{{ $alert->description }}"
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center text-xs text-zinc-400 py-8">কোনো ভুল রিপোর্টেড প্রশ্ন নেই, ডাটাবেজ কন্টেন্ট হেলদি আছে! ✨</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            @endif
        @endif
    </div>
</x-layouts::app>
