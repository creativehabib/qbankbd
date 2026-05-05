@php
    $panelTitle = $panelTitle ?? 'Dashboard Panel';
    $welcomeTitle = $welcomeTitle ?? 'অনলাইন ডিজিটাল স্কুল';
    $welcomeSubtitle = $welcomeSubtitle ?? 'রোল: ব্যবহারকারী';
    $description = $description ?? 'ড্যাশবোর্ড তথ্য';

    // রোল চেক
    $isTeacher = auth()->user()?->hasRole('teacher');

    // শিক্ষকদের ডামি ডাটা
    $teacherStats = $teacherStats ?? [
        'total_question_sets' => 0,
        'total_mcq_questions' => 0,
        'total_written_questions' => 0,
        'total_cost' => 0,
    ];
    $recentQuestionSet = $recentQuestionSet ?? null;
    $academicClasses = $academicClasses ?? collect();
    $teacherInstitutionName = auth()->user()?->institution_name ?: $welcomeTitle;
    $teacherInstitutionAddress = auth()->user()?->institution_address ?: 'প্রতিষ্ঠানের ঠিকানা যোগ করুন';

    // স্টুডেন্টদের ডামি ডাটা (আপনি পরে এটি লাইভওয়্যার থেকে ডায়নামিক করে নেবেন)
    $studentStats = $studentStats ?? [
        'streak_days' => 0,
        'rank' => 508,
        'study_time' => '1h 26m',
        'exam_taken' => 2,
        'accuracy' => [
            'percentage' => 32.5,
            'right' => 13,
            'wrong' => 27,
            'skipped' => 0,
        ],
    ];

    $attendedExams = $attendedExams ?? [
        [
            'name' => 'সাধারণ জ্ঞান এবং সাম্প্রতিক বিষয়ক মডেল টেস্ট ৪৮',
            'score' => 2.50,
            'total' => 20,
            'time' => '10 Mins',
            'right' => 6,
            'wrong' => 14,
            'skipped' => 0,
            'date' => '19 days ago'
        ],
        [
            'name' => 'বাংলাদেশ বিদ্যুৎ উন্নয়ন বোর্ড এর সহকারী',
            'score' => 7.00,
            'total' => 20,
            'time' => '12 Mins',
            'right' => 7,
            'wrong' => 13,
            'skipped' => 0,
            'date' => '1 month ago'
        ]
    ];
@endphp

<x-layouts::app :title="$panelTitle">
    <div class="space-y-4 sm:space-y-5">

        @if($isTeacher)
            <section class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="space-y-1">
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 sm:text-xl">{{ $teacherInstitutionName }}</h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $teacherInstitutionAddress }}</p>
                    </div>

                    <div class="grid w-full grid-cols-1 gap-2 sm:w-auto sm:grid-cols-2">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">তথ্য পরিবর্তন</a>
                        <a href="{{ route('teacher.institution-info') }}" class="inline-flex items-center justify-center rounded-lg border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700">প্রতিষ্ঠান তথ্য</a>
                    </div>
                </div>
            </section>

            <section class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">
                <div class="space-y-2 text-center">
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">প্রশ্ন তৈরি করুন</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">E-Question Builder ব্যবহার করে একাডেমিক, ভর্তি ও চাকরির প্রস্তুতির জন্য নিজের প্রশ্নপত্র তৈরি করুন।</p>
                </div>

                <div
                    x-data="{ selectedClass: '', selectedSubject: '', classes: {{ Js::from($academicClasses->map(fn ($class) => ['id' => (string) $class->id, 'name' => $class->name, 'subjects' => $class->subjects->map(fn ($subject) => ['id' => (string) $subject->id, 'name' => $subject->name])->values()])->values()) }}, get filteredSubjects() { if (!this.selectedClass) { return []; } const foundClass = this.classes.find((item) => item.id === this.selectedClass); return foundClass ? foundClass.subjects : []; } }"
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
                                :href="selectedSubject ? `{{ route('question.set-create') }}?subject_id=${selectedSubject}` : '#'"
                                class="inline-flex items-center justify-center rounded-lg px-2 py-1.5 text-sm font-semibold sm:min-w-32"
                                :class="selectedSubject ? 'bg-indigo-600 text-white' : 'cursor-not-allowed bg-indigo-200 text-white'"
                                :aria-disabled="selectedSubject ? 'false' : 'true'"
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
                        <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $teacherStats['total_question_sets'] }}</p>
                    </div>
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('মোট MCQ প্রশ্ন') }}</p>
                        <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $teacherStats['total_mcq_questions'] }}</p>
                    </div>
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('মোট লিখিত প্রশ্ন') }}</p>
                        <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $teacherStats['total_written_questions'] }}</p>
                    </div>
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('মোট খরচ') }}</p>
                        <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">৳ {{ number_format($teacherStats['total_cost'], 2) }}</p>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 gap-3 lg:grid-cols-2">
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <div class="flex items-center justify-between">
                            <h4 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">সাম্প্রতিক তৈরি প্রশ্ন</h4>
                        </div>
                        @if($recentQuestionSet)
                            <p class="mt-3 text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $recentQuestionSet->name }}</p>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $recentQuestionSet->updated_at?->format('M d, Y h:i A') }}
                            </p>
                        @else
                            <p class="mt-3 text-sm text-zinc-500 dark:text-zinc-400">এখনো কোনো প্রশ্ন সেট তৈরি করা হয়নি।</p>
                        @endif
                    </div>

                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <h4 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">সাপোর্ট</h4>
                        <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-300">E-Question Builder নিয়ে সহায়তা প্রয়োজন? টেমপ্লেট, OMR, এবং পেপার এক্সপোর্ট নিয়ে সহায়তা নিন।</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="rounded-md bg-emerald-500 px-3 py-1 text-sm font-medium text-white">WhatsApp</span>
                            <span class="rounded-md bg-indigo-600 px-3 py-1 text-sm font-medium text-white">Messenger</span>
                            <span class="rounded-md border border-zinc-300 px-3 py-1 text-sm font-medium text-zinc-700 dark:border-zinc-600 dark:text-zinc-200">Email</span>
                        </div>
                    </div>
                </div>
            </section>

        @else
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
                            <p class="text-xl font-black text-orange-600">{{ $studentStats['streak_days'] }} <span class="text-sm font-medium">Day</span></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-medium text-zinc-500">Rank: #{{ $studentStats['rank'] }}</span>
                        <p class="text-[10px] text-zinc-400 mt-1">Practice some MCQ to start!</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="mb-3 text-sm font-bold text-zinc-700 dark:text-zinc-300">Your Study Stats Last 7 Days</h2>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-4">
                    <div class="flex flex-col gap-4">
                        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                            <p class="text-xs font-semibold uppercase text-zinc-500">Study Time</p>
                            <p class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white">{{ $studentStats['study_time'] }}</p>
                        </div>
                        <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                            <p class="text-xs font-semibold uppercase text-zinc-500">Exam Taken</p>
                            <p class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white">{{ $studentStats['exam_taken'] }}</p>
                        </div>
                    </div>

                    <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 flex flex-col items-center justify-center">
                        <p class="w-full text-left text-xs font-semibold uppercase text-zinc-500">Accuracy</p>
                        <div id="accuracyChart" class="mt-2 h-32 w-full"></div>
                        <div class="mt-4 flex w-full justify-between text-[10px] font-medium text-zinc-500">
                            <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-red-500"></span> {{ $studentStats['accuracy']['wrong'] }} Wrong</span>
                            <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-emerald-500"></span> {{ $studentStats['accuracy']['right'] }} Right</span>
                            <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-zinc-300"></span> {{ $studentStats['accuracy']['skipped'] }} Skipped</span>
                        </div>
                    </div>

                    <div class="col-span-1 lg:col-span-2 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-xs font-semibold uppercase text-zinc-500">Your Engagement</p>
                            <div class="flex gap-2">
                                <button class="rounded bg-emerald-100 px-2 py-0.5 text-xs font-bold text-emerald-700">7D</button>
                                <button class="rounded px-2 py-0.5 text-xs text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800">15D</button>
                            </div>
                        </div>
                        <div id="engagementChart" class="h-32 w-full"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
                <div class="col-span-1 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 lg:col-span-2">
                    <div class="flex justify-between items-center border-b border-zinc-100 pb-3 dark:border-zinc-800">
                        <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100">Attended Exams</h3>
                        <a href="{{ route('student.test-history') ?? '#' }}" class="text-xs text-indigo-600 hover:underline">View All →</a>
                    </div>
                    <div class="mt-4 space-y-4">
                        @foreach($attendedExams as $exam)
                            <div class="rounded-lg border border-zinc-100 p-4 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/20">
                                <div class="flex justify-between">
                                    <div class="space-y-1">
                                        <h4 class="text-sm font-bold text-zinc-800 dark:text-zinc-200">{{ $exam['name'] }}</h4>
                                        <p class="text-[10px] text-zinc-500">{{ $exam['date'] }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-black text-emerald-600">{{ number_format($exam['score'], 2) }}/{{ $exam['total'] }}</p>
                                        <p class="text-[10px] text-zinc-500">{{ $exam['time'] }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 flex justify-start gap-6 border-t border-zinc-100 pt-3 text-xs font-medium text-zinc-600 dark:border-zinc-800 dark:text-zinc-400">
                                    <span class="flex items-center gap-1.5"><span class="size-2 rounded-full bg-emerald-500"></span> {{ $exam['right'] }} Right</span>
                                    <span class="flex items-center gap-1.5"><span class="size-2 rounded-full bg-red-500"></span> {{ $exam['wrong'] }} Wrong</span>
                                    <span class="flex items-center gap-1.5"><span class="size-2 rounded-full bg-zinc-300"></span> {{ $exam['skipped'] }} Skipped</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-span-1 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="flex justify-between items-center border-b border-zinc-100 pb-3 dark:border-zinc-800">
                        <h3 class="flex items-center gap-2 text-base font-bold text-amber-600">
                            <flux:icon.trophy class="size-5" /> Bronze League
                        </h3>
                        <a href="#" class="text-xs text-zinc-500 hover:underline">Leaderboard →</a>
                    </div>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-3">
                                <span class="flex size-6 items-center justify-center rounded bg-amber-100 text-[10px] font-bold text-amber-700">#1</span>
                                <span class="font-medium text-zinc-700 dark:text-zinc-300">Emperor Gaming</span>
                            </div>
                            <span class="font-bold text-zinc-500">568 XP</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-3">
                                <span class="flex size-6 items-center justify-center rounded bg-zinc-100 text-[10px] font-bold text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">#2</span>
                                <span class="font-medium text-zinc-700 dark:text-zinc-300">Muhammad Noor</span>
                            </div>
                            <span class="font-bold text-zinc-500">386 XP</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if(!$isTeacher)
        @push('scripts')
            <script>
                function renderDashboardCharts() {
                    // পেজে চার্টের ডিভ না থাকলে ফাংশন থামিয়ে দেবে (এরর এড়াতে)
                    if (!document.querySelector("#accuracyChart") || !document.querySelector("#engagementChart")) {
                        return;
                    }

                    // লাইভওয়্যার যখন বারবার লোড হয়, তখন যেন চার্ট ডাবল না হয়ে যায় তাই আগের চার্ট ক্লিয়ার করা হচ্ছে
                    document.querySelector("#accuracyChart").innerHTML = '';
                    document.querySelector("#engagementChart").innerHTML = '';

                    // ১. Accuracy Donut Chart
                    var accuracyOptions = {
                        series: [{{ $studentStats['accuracy']['right'] }}, {{ $studentStats['accuracy']['wrong'] }}, {{ $studentStats['accuracy']['skipped'] }}],
                        labels: ['Right', 'Wrong', 'Skipped'],
                        chart: { type: 'donut', height: 160, sparkline: { enabled: true } },
                        colors: ['#10b981', '#ef4444', '#d4d4d8'],
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '75%',
                                    labels: {
                                        show: true,
                                        name: { show: false },
                                        value: { show: true, fontSize: '20px', fontWeight: 700, formatter: function (val) { return "{{ $studentStats['accuracy']['percentage'] }}%" } }
                                    }
                                }
                            }
                        },
                        dataLabels: { enabled: false },
                        tooltip: { enabled: false },
                    };
                    var accuracyChart = new ApexCharts(document.querySelector("#accuracyChart"), accuracyOptions);
                    accuracyChart.render();

                    // ২. Engagement Area Chart
                    var engagementOptions = {
                        series: [{ name: 'Engagement', data: [5, 15, 10, 18, 12, 5, 0] }],
                        chart: { type: 'area', height: 160, toolbar: { show: false }, sparkline: { enabled: true } },
                        colors: ['#10b981'],
                        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 100] } },
                        stroke: { curve: 'smooth', width: 2 },
                        xaxis: { categories: ['29 Apr', '30 Apr', '01 May', '02 May', '03 May', '04 May', '05 May'] }
                    };
                    var engagementChart = new ApexCharts(document.querySelector("#engagementChart"), engagementOptions);
                    engagementChart.render();
                }

                // যখন পেজ প্রথমবার লোড হবে
                document.addEventListener('DOMContentLoaded', renderDashboardCharts);

                // লাইভওয়্যার যখন নেভিগেট করবে বা পেজ রেন্ডার করবে
                document.addEventListener('livewire:navigated', renderDashboardCharts);
            </script>
        @endpush
    @endif
</x-layouts::app>
