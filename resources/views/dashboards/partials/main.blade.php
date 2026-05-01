@php
    $panelTitle = $panelTitle ?? 'Dashboard Panel';
    $welcomeTitle = $welcomeTitle ?? 'অনলাইন ডিজিটাল স্কুল';
    $welcomeSubtitle = $welcomeSubtitle ?? 'রোল: ব্যবহারকারী';
    $description = $description ?? 'ড্যাশবোর্ড তথ্য';
    $isTeacher = auth()->user()?->hasRole('teacher');
    $teacherStats = $teacherStats ?? [
        'total_question_sets' => 0,
        'total_mcq_questions' => 0,
        'total_written_questions' => 0,
        'total_cost' => 0,
    ];
    $recentQuestionSet = $recentQuestionSet ?? null;
    $teacherInstitutionName = auth()->user()?->institution_name ?: $welcomeTitle;
    $teacherInstitutionAddress = auth()->user()?->institution_address ?: 'প্রতিষ্ঠানের ঠিকানা যোগ করুন';
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
        @endif

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

            @if($isTeacher)
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
                            <p class="mt-3 text-sm text-zinc-500 dark:text-zinc-400">এখনো কোনো প্রশ্ন সেট তৈরি করা হয়নি।</p>
                        @endif
                    </div>

                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <h4 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">সাপোর্ট</h4>
                        <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-300">E-Question Builder নিয়ে সহায়তা প্রয়োজন? টেমপ্লেট, OMR, এবং পেপার এক্সপোর্ট নিয়ে সহায়তা নিন।</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="rounded-md bg-emerald-500 px-3 py-1 text-sm font-medium text-white">WhatsApp</span>
                            <span class="rounded-md bg-indigo-600 px-3 py-1 text-sm font-medium text-white">Messenger</span>
                            <span class="rounded-md border border-zinc-300 px-3 py-1 text-sm font-medium text-zinc-700 dark:border-zinc-600 dark:text-zinc-200">Email</span>
                        </div>
                    </div>
                </div>
            @endif

        </section>
    </div>
</x-layouts::app>
