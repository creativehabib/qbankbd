<x-layouts.frontend :title="$exam->title . ' - প্রশ্ন ও সমাধান'" :description="$exam->title . ' এর পূর্ণাঙ্গ প্রশ্ন ও নির্ভুল সমাধান।'">
<div x-data="examPageData()" class="space-y-6 pb-12">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-1.5 md:gap-2 text-[11px] md:text-[13px] text-zinc-500 font-medium w-full">
        <a href="/" class="shrink-0 hover:text-emerald-600 transition-colors flex items-center gap-1"><flux:icon.home class="w-3 h-3 md:w-3.5 md:h-3.5" /> হোম</a>
        <flux:icon.chevron-right class="shrink-0 w-2.5 h-2.5 md:w-3 md:h-3" />
        <a href="{{ route('job-solutions.index') }}" class="shrink-0 hover:text-emerald-600 transition-colors whitespace-nowrap">জব সল্যুশন</a>
        <flux:icon.chevron-right class="shrink-0 w-2.5 h-2.5 md:w-3 md:h-3" />
        <a href="{{ route('institution.show', $institution->slug) }}" class="truncate hover:text-emerald-600 transition-colors min-w-[50px] md:min-w-0 max-w-[90px] sm:max-w-[150px] md:max-w-none">{{ $institution->name }}</a>
        <flux:icon.chevron-right class="shrink-0 w-2.5 h-2.5 md:w-3 md:h-3" />
        <span class="truncate text-zinc-900 dark:text-zinc-100 min-w-[50px] md:min-w-0 max-w-[90px] sm:max-w-[150px] md:max-w-none">{{ $exam->title }}</span>
    </div>

    <!-- Top Header Card -->
            <div class="bg-white dark:bg-zinc-900 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 border-t-4 border-t-emerald-500 dark:border-t-emerald-400 rounded-2xl p-5 md:p-8 relative overflow-hidden">

                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div class="flex-grow">
                        <!-- Top Pills -->
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            <span class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-full text-xs font-bold border border-emerald-100 dark:border-emerald-800">
                                @if($institution->logo_path)
                                    <img src="{{ Storage::url($institution->logo_path) }}" alt="Logo" class="w-3 h-3 object-contain">
                                @else
                                    <flux:icon.building-office-2 class="w-3 h-3" />
                                @endif
                                {{ $institution->name }}
                            </span>
                            <span class="px-3 py-1 bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 rounded-full text-[11px] font-bold uppercase tracking-wider">
                                {{ $exam->type }}
                            </span>
                            @if($exam->exam_date)
                                <span class="px-3 py-1 text-zinc-500 text-xs font-medium">
                                    {{ $exam->exam_date->format('d F, Y') }}
                                </span>
                            @endif
                        </div>

                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-zinc-900 dark:text-zinc-100 mb-4 leading-tight">
                            {{ $exam->title }}
                        </h1>

                        <div x-data="{ expanded: false}">
                            <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed mb-4 transition-all duration-300 ease-in-out overflow-hidden" :class="expanded ? 'max-h-[1000px]' : 'max-h-[46px] line-clamp-2'">
                                @if($exam->description)
                                    {!! $exam->description !!}
                                @else
                                    {{ $institution->name }} এর {{ $exam->title }} পদের নিয়োগ পরীক্ষাটি সরকারি চাকরিপ্রার্থীদের জন্য একটি গুরুত্বপূর্ণ পরীক্ষা। এই পরীক্ষায় সাধারণত {{ $exam->type }} পদ্ধতিতে প্রশ্ন এসে থাকে। নিচে সম্পূর্ণ সমাধান দেওয়া হলো।
                                @endif
                            </div>

                            <button @click="expanded = !expanded" class="text-emerald-600 text-sm font-bold flex items-center gap-1 hover:text-emerald-700 transition-colors">
                                <span x-text="expanded ? 'সংক্ষিপ্ত করুন' : 'আরও দেখুন'"></span>
                                <flux:icon.chevron-down class="w-3 h-3 transition-transform" x-bind:class="expanded ? 'rotate-180' : ''" />
                            </button>
                        </div>
                    </div>

                    <!-- Stats Pills (Desktop - Square Boxes) -->
                    <div class="hidden md:flex items-center gap-3 shrink-0 mt-0 justify-end">

                        <!-- Total Marks -->
                        <div class="flex flex-col items-center justify-center w-[88px] h-[88px] rounded-2xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                            <span class="text-2xl font-bold text-emerald-600 dark:text-emerald-500 leading-none">{{ $exam->total_marks ?? '-' }}</span>
                            <span class="text-[11px] font-medium text-zinc-500 dark:text-zinc-400 mt-2">পূর্ণমান</span>
                        </div>

                        <!-- Total Questions -->
                        <div class="flex flex-col items-center justify-center w-[88px] h-[88px] rounded-2xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                            <span class="text-2xl font-bold text-emerald-600 dark:text-emerald-500 leading-none">{{ $totalQuestions }}</span>
                            <span class="text-[11px] font-medium text-zinc-500 dark:text-zinc-400 mt-2">মোট প্রশ্ন</span>
                        </div>

                        <!-- Duration (Quiz Mode Only) -->
                        <div x-show="isQuizMode" style="display: none;" class="flex flex-col items-center justify-center w-[88px] h-[88px] rounded-2xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-sm transition-all">
                            <div class="flex items-center gap-1 text-sky-600 dark:text-sky-500 leading-none">
                                <span class="text-2xl font-bold">{{ $exam->duration ?? '-' }}</span>
                            </div>
                            <span class="flex items-center gap-1 text-[11px] font-medium text-zinc-500 dark:text-zinc-400 mt-2">
                                <flux:icon.clock class="w-3 h-3" /> সময় (মি.)
                            </span>
                        </div>
                    </div>

                    <!-- Stats Pills (Mobile - Horizontal) -->
                    <div class="flex md:hidden flex-wrap items-center justify-center gap-2 w-full mt-6">
                        <div class="flex shrink-0 whitespace-nowrap items-center gap-1.5 px-3 py-1.5 rounded-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                            <flux:icon.document-text class="w-3.5 h-3.5 text-orange-500" />
                            <span class="text-[11px] font-medium text-zinc-500 dark:text-zinc-400">পূর্ণমান:</span>
                            <span class="text-[11px] font-bold text-zinc-900 dark:text-zinc-100">{{ $exam->total_marks ?? '-' }}</span>
                        </div>

                        <div class="flex shrink-0 whitespace-nowrap items-center gap-1.5 px-3 py-1.5 rounded-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                            <flux:icon.question-mark-circle class="w-3.5 h-3.5 text-emerald-500" />
                            <span class="text-[11px] font-medium text-zinc-500 dark:text-zinc-400">প্রশ্ন:</span>
                            <span class="text-[11px] font-bold text-zinc-900 dark:text-zinc-100">{{ $totalQuestions }}</span>
                        </div>

                        <div x-show="isQuizMode" style="display: none;" class="flex shrink-0 whitespace-nowrap items-center gap-1.5 px-3 py-1.5 rounded-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-sm transition-all">
                            <flux:icon.clock class="w-3.5 h-3.5 text-sky-500" />
                            <span class="text-[11px] font-medium text-zinc-500 dark:text-zinc-400">সময়:</span>
                            <span class="text-[11px] font-bold text-zinc-900 dark:text-zinc-100">{{ $exam->duration ?? '-' }}মি.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Main Content (Cols: 8/12) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Toolbar Row -->
            <div class="flex items-center justify-between gap-3 sticky top-[64px] md:top-[72px] z-40 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-2.5 shadow-sm transition-all overflow-x-auto no-scrollbar [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">

                <!-- Modes -->
                <div class="flex shrink-0 bg-slate-50 dark:bg-zinc-800/50 p-1 rounded-full border border-slate-200 dark:border-zinc-700">
                    <button @click="isQuizMode = false; showAnswers = true; showExplanations = false"
                            :class="!isQuizMode ? 'bg-white dark:bg-zinc-900 text-emerald-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                            class="px-4 py-1.5 text-[13px] font-bold rounded-full transition-all text-center">
                        <span class="md:hidden">পড়া</span>
                        <span class="hidden md:inline">পড়ার মোড</span>
                    </button>
                    <button @click="isQuizMode = true; showAnswers = false; showExplanations = false"
                            :class="isQuizMode ? 'bg-white dark:bg-zinc-900 text-emerald-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                            class="px-4 py-1.5 text-[13px] font-bold rounded-full transition-all text-center">
                        <span class="md:hidden">কুইজ</span>
                        <span class="hidden md:inline">কুইজ মোড</span>
                    </button>
                </div>

                <!-- Actions & Share -->
                <div class="flex items-center gap-2 shrink-0 ml-auto">
                    <!-- Action Buttons -->
                    <button @click="showAnswers = !showAnswers"
                            :class="showAnswers ? 'border-emerald-300 text-emerald-600 bg-emerald-50 dark:border-emerald-700 dark:bg-emerald-900/30' : 'border-zinc-200 text-zinc-500 dark:border-zinc-700 dark:text-zinc-400'"
                            class="flex items-center gap-1.5 px-4 py-1.5 bg-white dark:bg-zinc-900 border rounded-full text-[13px] font-bold transition-colors shadow-sm">
                        <div x-show="showAnswers" class="flex items-center gap-1.5"><flux:icon.eye class="w-4 h-4" /> <span class="md:hidden">উত্তর: চালু</span><span class="hidden md:inline">উত্তর লুকান</span></div>
                        <div x-show="!showAnswers" style="display: none;" class="flex items-center gap-1.5"><flux:icon.eye-slash class="w-4 h-4" /> <span class="md:hidden">উত্তর: বন্ধ</span><span class="hidden md:inline">উত্তর দেখান</span></div>
                    </button>
                    <button @click="showExplanations = !showExplanations"
                            :class="showExplanations ? 'border-indigo-300 text-indigo-600 bg-indigo-50 dark:border-indigo-700 dark:bg-indigo-900/30' : 'border-zinc-200 text-zinc-500 dark:border-zinc-700 dark:text-zinc-400'"
                            class="flex items-center gap-1.5 px-4 py-1.5 bg-white dark:bg-zinc-900 border rounded-full text-[13px] font-bold transition-colors shadow-sm">
                        <div x-show="showExplanations" style="display: none;" class="flex items-center gap-1.5"><flux:icon.light-bulb class="w-4 h-4" /> <span class="md:hidden">ব্যাখ্যা: চালু</span><span class="hidden md:inline">ব্যাখ্যা লুকান</span></div>
                        <div x-show="!showExplanations" class="flex items-center gap-1.5"><flux:icon.light-bulb class="w-4 h-4 opacity-50" /> <span class="md:hidden">ব্যাখ্যা: বন্ধ</span><span class="hidden md:inline">ব্যাখ্যা দেখান</span></div>
                    </button>

                    <!-- Share Button -->
                    <button class="w-9 h-9 shrink-0 flex items-center justify-center bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-full text-zinc-500 hover:text-zinc-900 transition-colors shadow-sm">
                        <flux:icon.share class="w-4 h-4" />
                    </button>
                </div>
            </div>

            <!-- Subject Pills -->
            <div class="flex overflow-x-auto md:flex-wrap gap-2 py-2 w-full snap-x [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                <button @click="activeSubjectId = null"
                        class="shrink-0 snap-start whitespace-nowrap px-3.5 md:px-5 py-1.5 md:py-2 rounded-full text-[11px] md:text-xs font-bold transition-all border " :class="activeSubjectId === null ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800'">
                    সকল বিষয় ({{ $totalQuestions }})
                </button>
                @foreach($subjectsData as $subject)
                    <button @click="activeSubjectId = {{ $subject['id'] }}"
                            class="shrink-0 snap-start whitespace-nowrap px-3.5 md:px-5 py-1.5 md:py-2 rounded-full text-[11px] md:text-xs font-bold transition-all border " :class="activeSubjectId === {{ $subject['id'] }} ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800'">
                        {{ $subject['name'] }} ({{ $subject['count'] }})
                    </button>
                @endforeach
            </div>

            <!-- Topic Weightage Accordion -->
            <div class="bg-emerald-50/50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/50 rounded-xl overflow-hidden transition-all">
                <button @click="showTopicWeightage = !showTopicWeightage" class="w-full flex items-center justify-between p-4 text-left focus:outline-none">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                            <flux:icon.chart-bar class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">এই পরীক্ষার বিষয় ও টপিকভিত্তিক প্রশ্ন বিন্যাস (Topic Weightage)</h3>
                            <p class="text-xs text-zinc-500 mt-0.5">কোন বিষয় ও টপিক থেকে কত শতাংশ প্রশ্ন এসেছে দেখতে ক্লিক করুন</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-emerald-600 text-xs font-bold px-4">
                        বিস্তারিত দেখুন
                        <flux:icon.chevron-down class="w-4 h-4 transition-transform " x-bind:class="showTopicWeightage ? 'rotate-180' : ''" />
                    </div>
                </button>

                <div x-show="showTopicWeightage" x-collapse style="display: none;">
                <div class="p-6 border-t border-emerald-100 dark:border-emerald-900/50 bg-white dark:bg-zinc-900/50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($topicWeightage as $subject)
                            <div class="border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 bg-white dark:bg-zinc-900 shadow-sm">
                                <!-- Subject Header -->
                                <div class="flex justify-between items-center mb-4 pb-3 border-b border-zinc-100 dark:border-zinc-800 border-dashed">
                                    <div class="flex items-center gap-2 font-bold text-zinc-800 dark:text-zinc-200 text-sm">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span> {{ $subject['name'] }}
                                    </div>
                                    <div class="text-emerald-600 dark:text-emerald-400 font-bold text-xs">
                                        {{ $subject['count'] }} টি ({{ $subject['percentage'] }}%)
                                    </div>
                                </div>

                                <!-- Chapters List -->
                                <div class="space-y-4">
                                    @foreach($subject['chapters'] as $chapter)
                                        <div>
                                            <div class="flex justify-between items-end mb-1.5 text-xs">
                                                <span class="text-zinc-600 dark:text-zinc-400 font-medium">{{ $chapter['name'] }}</span>
                                                <span>
                                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $chapter['count'] }} টি</span>
                                                    <span class="text-zinc-400 text-[11px]">({{ $chapter['percentage'] }}%)</span>
                                                </span>
                                            </div>
                                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-emerald-400 dark:bg-emerald-500 h-1.5 rounded-full" style="width: {{ $chapter['percentage'] }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-zinc-500 text-center col-span-2 py-4">কোনো তথ্য নেই</p>
                        @endforelse
                    </div>
                </div>
                </div>
            </div>

            <!-- Questions Area -->
            <div class="space-y-6" x-ref="questionsContainer">
                @php
                    $groupedQuestions = $activeQuestions->groupBy('subject_id');
                    $globalQuestionIndex = 1;
                @endphp

                @forelse($groupedQuestions as $subId => $groupQs)
                <div class="subject-group" data-subject-id="{{ $subId }}" x-show="activeSubjectId === null || activeSubjectId === {{ $subId }}">
                    @php
                        $subName = $subjectsData->firstWhere('id', $subId)['name'] ?? 'অনির্ধারিত অংশ';
                        // Add ' অংশ' if it doesn't end with it, just to match screenshot
                        if (!str_ends_with($subName, ' অংশ')) {
                            $subName .= ' অংশ';
                        }
                    @endphp

                    <div class="subject-header flex items-center justify-between border-b-2 border-zinc-100 dark:border-zinc-800 pb-2 mt-8 mb-6 relative">
                        <div class="absolute -left-0 top-0 bottom-0 w-1.5 bg-emerald-600 rounded-r-md"></div>
                        <h2 class="text-xl font-extrabold text-zinc-900 dark:text-zinc-100 pl-4">{{ $subName }}</h2>
                        @php
                            $subjectObj = $groupQs->first()->subject ?? null;
                        @endphp
                        @if($subjectObj && $subjectObj->slug)
                            <a href="{{ route('job-solutions.index', ['tab' => 'topics', 'subject' => $subjectObj->slug]) }}" class="text-xs font-bold text-emerald-600 flex items-center gap-1 hover:underline">
                                বিষয়ভিত্তিক সমাধান <flux:icon.arrow-right class="w-3 h-3" />
                            </a>
                        @endif
                    </div>

                    <div class="space-y-4">
                        @foreach($groupQs as $question)
                            <div class="question-card relative z-10 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 md:p-5 hover:border-emerald-300 dark:hover:border-emerald-800 transition-colors shadow-sm">

                                <!-- Meta row -->
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex gap-2">
                                        <span class="bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 font-bold px-2.5 py-1 rounded-md text-xs">
                                            {{ $globalQuestionIndex++ }}
                                        </span>
                                        <div class="flex items-center gap-1.5 flex flex-wrap items-center gap-1.5 text-[10px] font-medium">
                                            <span class="bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 px-2 py-1 rounded">{{ $question->subject?->name ?? 'N/A' }}</span>
                                            @if($question->chapter)
                                                <span class="bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 px-2 py-1 rounded">{{ $question->chapter->name }}</span>
                                            @endif
                                            @if($question->topic)
                                                <span class="bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400 px-2 py-1 rounded flex items-center gap-1"><flux:icon.arrow-turn-down-right class="w-2.5 h-2.5" /> {{ $question->topic->name }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <!-- Question Title -->
                                <div class="text-[15px] md:text-lg font-bold text-zinc-900 dark:text-zinc-100 leading-snug mb-4">
                                    @php
                                        $qTitle = html_entity_decode($question->title ?? '');
                                        // Convert block elements to inline spans to prevent link hit-box collapse
                                        $qTitle = preg_replace('/<p[^>]*>/is', '<span>', $qTitle);
                                        $qTitle = str_replace('</p>', '</span> ', $qTitle);
                                        $qTitle = preg_replace('/<div[^>]*>/is', '<span>', $qTitle);
                                        $qTitle = str_replace('</div>', '</span> ', $qTitle);
                                        // CRITICAL FIX: Remove nested <a> tags from database content to prevent browser auto-closing the outer link
                                        $qTitle = preg_replace('/<a[^>]*>/is', '', $qTitle);
                                        $qTitle = str_replace('</a>', '', $qTitle);
                                    @endphp
                                    <a href="{{ route('question.show', $question->slug) }}" class="relative z-20 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors cursor-pointer tex2jax_process" data-math-content>
                                        {!! $qTitle !!}
                                    </a>
                                    <span class="text-[10px] md:text-xs font-normal text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-1.5 py-0.5 rounded ml-1 align-middle inline-block">[{{ $institution->name }}]</span>
                                </div>

                                <!-- Options -->
                                @if($question->question_type === 'mcq' && is_array($question->extra_content))
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @foreach($question->extra_content as $key => $option)
                                            @php
                                                $isCorrect = (isset($option['is_correct']) && $option['is_correct']) ? 'true' : 'false';
                                            @endphp
                                            <div class="group flex items-center gap-3 p-3 md:p-3.5 border rounded-xl transition-all cursor-pointer"
                                                 :class="(showAnswers && !isQuizMode && {{ $isCorrect }}) ? 'bg-emerald-50 border-emerald-500 dark:bg-emerald-900/30 dark:border-emerald-500 shadow-sm' : 'bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800/50'">
                                                <div class="w-6 h-6 md:w-7 md:h-7 rounded-full border flex items-center justify-center shrink-0 text-xs md:text-[13px] font-bold transition-all"
                                                     :class="(showAnswers && !isQuizMode && {{ $isCorrect }}) ? 'bg-emerald-500 border-emerald-500 text-white dark:bg-emerald-600 dark:border-emerald-600' : 'bg-white border-zinc-200 text-zinc-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-zinc-400 group-hover:border-zinc-300 dark:group-hover:border-zinc-500'">
                                                    {{ ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ'][$loop->index] ?? chr(65 + $loop->index) }}
                                                </div>
                                                @php
                                                    $optText = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', html_entity_decode($option['option_text'] ?? '')) ?? html_entity_decode($option['option_text'] ?? '');
                                                @endphp
                                                <div class="text-[13px] md:text-[15px] font-medium flex-grow tex2jax_process" data-math-content
                                                     :class="(showAnswers && !isQuizMode && {{ $isCorrect }}) ? 'text-emerald-800 dark:text-emerald-200' : 'text-zinc-700 dark:text-zinc-300'">
                                                    {!! $optText !!}
                                                </div>
                                                <template x-if="showAnswers && !isQuizMode && {{ $isCorrect }}">
                                                    <flux:icon.check class="w-4 h-4 text-emerald-500 shrink-0" />
                                                </template>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif(in_array($question->question_type, ['written', 'short', 'cq']))
                                    <div x-show="showAnswers && !isQuizMode" style="display: none;" class="mt-4 p-4 bg-emerald-50/50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/30 rounded-xl">
                                            <p class="text-xs font-bold text-emerald-800 dark:text-emerald-400 mb-2 flex items-center gap-1.5"><flux:icon.check-circle class="w-4 h-4" /> উত্তর / সমাধান:</p>
                                            <div class="text-sm md:text-[15px] text-zinc-700 dark:text-zinc-300 tex2jax_process" data-math-content>
                                                @if($question->description)
                                                    {!! $question->description !!}
                                                @else
                                                    (সমাধান দেওয়া হয়নি)
                                                @endif
                                            </div>
                                        </div>
                                @endif

                                <!-- Interactive Explanation Block (Like Practice) -->
                                @if($question->question_type === 'mcq')
                                    <div x-data="{ localOpen: false}"
                                     x-effect="localOpen = (!isQuizMode && showExplanations && {{ filled($question->description) ? 'true' : 'false' }})"
                                     class="mt-4 border-t border-zinc-200/60 pt-3 dark:border-zinc-700/60 space-y-3">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                            <template x-if="!isQuizMode">
                                                <button type="button" x-on:click="localOpen = !localOpen" class="inline-flex w-fit items-center gap-1 text-sm font-semibold text-zinc-500 hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400 transition-colors">
                                                    <flux:icon.light-bulb class="w-4 h-4" />
                                                    <span x-text="localOpen ? 'ব্যাখ্যা লুকান' : 'ব্যাখ্যা দেখুন'"></span>
                                                    <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="localOpen ? 'rotate-180' : ''" />
                                                </button>
                                            </template>
                                            <template x-if="isQuizMode">
                                                <div></div> <!-- Empty div to keep flex-between layout for right icons -->
                                            </template>

                                            <div class="flex items-center gap-4 text-zinc-400 dark:text-zinc-500">
                                                <div class="flex items-center gap-1.5" title="Views">
                                                    <flux:icon.eye class="size-[18px]" />
                                                    <span class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">{{ $question->views_count ?? 0 }}</span>
                                                </div>
                                                <button type="button" class="cursor-pointer hover:text-emerald-600 dark:hover:text-emerald-400" title="Statistics">
                                                    <flux:icon.chart-pie class="size-[18px]" />
                                                </button>
                                                <button type="button" @click="toggleBookmark({{ $question->id }}, $event)" class="cursor-pointer {{ $question->is_bookmarked ? 'text-emerald-600 dark:text-emerald-400' : 'hover:text-emerald-600 dark:hover:text-emerald-400' }}" title="{{ $question->is_bookmarked ? 'Remove Bookmark' : 'Save Bookmark' }}">
                                                    <flux:icon.bookmark class="size-[18px]" variant="{{ $question->is_bookmarked ? 'solid' : 'outline' }}" />
                                                </button>
                                                <button type="button" @click="toggleLike({{ $question->id }}, $event)" class="flex items-center gap-1 cursor-pointer {{ $question->is_liked ? 'text-pink-500' : 'hover:text-pink-500' }}" title="{{ $question->is_liked ? 'Unlike' : 'Like' }}">
                                                    <flux:icon.heart class="size-[18px]" variant="{{ $question->is_liked ? 'solid' : 'outline' }}" />
                                                    @if($question->likes_count > 0)
                                                        <span class="text-xs font-medium">{{ $question->likes_count }}</span>
                                                    @endif
                                                </button>
                                                <button type="button" @click="$dispatch('open-report-modal', { id: {{ $question->id }} })" class="cursor-pointer hover:text-red-500 dark:hover:text-red-400" title="Report Error">
                                                    <flux:icon.flag class="size-[18px]" />
                                                </button>
                                                <button type="button" class="cursor-pointer hover:text-blue-500 dark:hover:text-blue-400" title="Share">
                                                    <flux:icon.share class="size-[18px]" />
                                                </button>
                                            </div>
                                        </div>

                                        <div id="explanation-wrapper-{{ $question->id }}" x-show="!isQuizMode && localOpen" x-collapse x-cloak class="rounded-xl border border-dashed border-zinc-300 p-5 dark:border-zinc-600 mt-3">
                                            @if(filled($question->description))
                                                <div class="prose prose-sm md:prose-base tex2jax_process max-w-none text-zinc-700 dark:prose-invert dark:text-zinc-200" data-math-content>
                                                    {!! $question->description !!}
                                                </div>
                                            @else
                                                <div class="space-y-3 text-center">
                                                    <div>
                                                        <flux:icon.sparkles class="mx-auto size-6 text-violet-500" />
                                                        <p class="font-semibold text-zinc-600 dark:text-zinc-300">{{ __('No explanation yet') }}</p>

                                                        <button
                                                            type="button"
                                                            id="ai-btn-{{ $question->id }}"
                                                            @click="generateAiExplanation({{ $question->id }})"
                                                            class="mt-2 inline-flex items-center gap-2 rounded-full bg-violet-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-violet-700 shadow-sm"
                                                        >
                                                            <flux:icon.sparkles class="size-3.5" />
                                                            AI দিয়ে ব্যাখ্যা তৈরি করুন
                                                        </button>

                                                        @if (session('last_question_id') == $question->id && $aiError)
                                                            <p class="mt-2 text-xs text-red-500">{{ $aiError }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @empty
                    <div class="text-center py-12 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl">
                        <p class="text-zinc-500">কোন প্রশ্ন পাওয়া যায়নি।</p>
                    </div>
                @endforelse

                @if($activeQuestions->count() > 0)
                <!-- Loading Indicator -->
                <div class="py-6 text-center" x-cloak>
                    <div x-show="isLoadingMore" class="flex justify-center items-center gap-2 text-zinc-500">
                        <svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span class="text-sm font-medium">লোড হচ্ছে...</span>
                    </div>
                    <div x-show="!hasMore && !isLoadingMore" class="text-sm font-medium text-zinc-400">
                        আর কোন প্রশ্ন নেই
                    </div>
                </div>
                @endif
            </div>

            
            

        </div>

        <!-- Right Sidebar (Cols: 4/12) -->
        <div class="lg:col-span-4 space-y-6 sticky top-[92px] h-max">

            <!-- Box 1: Hiring Institution -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
                <div class="p-5 flex items-center gap-4">
                    @if($institution->logo_path)
                        <div class="w-12 h-12 rounded-full border border-zinc-100 flex items-center justify-center p-1 shadow-sm shrink-0">
                            <img src="{{ Storage::url($institution->logo_path) }}" alt="Logo" class="w-full h-full object-contain rounded-full">
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center shrink-0">
                            <flux:icon.building-office-2 class="w-6 h-6 text-emerald-600" />
                        </div>
                    @endif
                    <div>
                        <p class="text-[11px] font-bold text-emerald-600 mb-0.5">নিয়োগকারী প্রতিষ্ঠান</p>
                        <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100">{{ $institution->name }}</h3>
                    </div>
                </div>

                <div class="grid grid-cols-2 divide-x divide-zinc-100 dark:divide-zinc-800 border-t border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/20">
                    <div class="p-4">
                        <p class="text-[10px] text-zinc-400 font-medium mb-1">পরীক্ষার ধরণ</p>
                        <p class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase">{{ $exam->type }}</p>
                    </div>
                    <div class="p-4">
                        <p class="text-[10px] text-zinc-400 font-medium mb-1">প্রশ্ন সংখ্যা</p>
                        <p class="text-sm font-bold text-emerald-600">{{ $totalQuestions }} টি</p>
                    </div>
                </div>

                <div class="p-4 bg-white dark:bg-zinc-900">
                    <a href="{{ route('institution.show', $institution->slug) }}" class="block w-full py-2.5 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 text-center text-xs font-bold rounded-lg transition-colors border border-emerald-100 dark:border-emerald-800/50">
                        {{ $institution->short_name ?? 'Ministry' }} এর সকল পরীক্ষা &rarr;
                    </a>
                </div>
            </div>

            <!-- Box 2: Other Top Institutions -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
                <div class="flex justify-between items-center p-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/20">
                    <h3 class="text-[13px] font-bold text-zinc-800 dark:text-zinc-200 flex items-center gap-2">
                        <flux:icon.building-office class="w-4 h-4 text-zinc-400" /> অন্যান্য শীর্ষ প্রতিষ্ঠান
                    </h3>
                    <a href="{{ route('job-solutions.index', ['tab' => 'organizations']) }}" class="text-[10px] font-bold text-emerald-600 hover:underline">সকল প্রতিষ্ঠান</a>
                </div>

                <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($otherInstitutions as $otherInst)
                        <a href="{{ route('institution.show', $otherInst->slug) }}" class="flex items-center justify-between p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors group">
                            <div class="flex items-center gap-3">
                                @if($otherInst->logo_path)
                                    <div class="w-8 h-8 rounded-full border border-zinc-100 flex items-center justify-center p-0.5 shrink-0 bg-white">
                                        <img src="{{ Storage::url($otherInst->logo_path) }}" alt="Logo" class="w-full h-full object-contain rounded-full">
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0">
                                        <flux:icon.building-office-2 class="w-4 h-4 text-zinc-400" />
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-xs font-bold text-zinc-800 dark:text-zinc-200 group-hover:text-emerald-600 transition-colors">{{ $otherInst->name }}</h4>
                                    <p class="text-[10px] text-zinc-400 mt-0.5">নিয়োগ পরীক্ষা</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-zinc-500 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded-md">
                                {{ $otherInst->past_exams_count }} টি পরীক্ষা
                            </span>
                        </a>
                    @empty
                        <div class="p-4 text-center text-xs text-zinc-500">অন্য কোনো প্রতিষ্ঠান নেই</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>


<script>
function examPageData() {
    return {
        isQuizMode: false, 
        showAnswers: true, 
        showExplanations: false, 
        showTopicWeightage: false, 
        activeSubjectId: null,
        limit: 10,
        isLoadingMore: false,
        hasMore: true,
        isSwitchingTab: false,
        
        init() {
            this.$watch('activeSubjectId', () => {
                this.limit = 10;
                this.hasMore = true;
                this.isSwitchingTab = true;
                this.$nextTick(() => {
                    this.updateVisibility();
                    // Block infinite scroll trigger during DOM resize
                    setTimeout(() => { this.isSwitchingTab = false; }, 100);
                });
            });
            
            window.addEventListener('scroll', () => {
                if (this.isLoadingMore || !this.hasMore || this.isSwitchingTab) return;
                
                if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 300) {
                    this.loadMore();
                }
            });
            
            this.$nextTick(() => {
                this.updateVisibility();
                if (window.renderMath) window.renderMath();
            });
        },
        
        loadMore() {
            if (!this.hasMore) return;
            this.isLoadingMore = true;
            
            setTimeout(() => {
                this.limit += 10;
                this.updateVisibility();
                this.isLoadingMore = false;
            }, 300);
        },
        
        updateVisibility() {
            let container = this.$refs.questionsContainer;
            if (!container) return;
            
            let selector = this.activeSubjectId === null 
                ? '.subject-group .question-card' 
                : '.subject-group[data-subject-id="' + this.activeSubjectId + '"] .question-card';
                
            let cards = container.querySelectorAll(selector);
            
            cards.forEach((card, index) => {
                if (index < this.limit) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
            
            this.hasMore = cards.length > this.limit;
            
            // Hide subject headers if they have no visible questions
            let groups = container.querySelectorAll('.subject-group');
            groups.forEach(group => {
                let groupCards = group.querySelectorAll('.question-card');
                let hasVisible = false;
                groupCards.forEach(c => {
                    if (c.style.display !== 'none') hasVisible = true;
                });
                
                let header = group.querySelector('.subject-header');
                if (header) {
                    header.style.display = hasVisible ? 'flex' : 'none';
                }
                
                if (!hasVisible) {
                    group.classList.add('hidden');
                } else {
                    group.classList.remove('hidden');
                }
            });
        },
        
        toggleBookmark(questionId, event) {
            let btn = event.currentTarget;
            let icon = btn.querySelector('svg');
            let countSpan = btn.querySelector('.b-count') || btn;
            
            fetch('/interaction/bookmark/' + questionId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    if(data.status === 'attached') {
                        btn.classList.add('text-emerald-600');
                        btn.classList.remove('text-zinc-400', 'hover:text-emerald-600');
                        icon.setAttribute('fill', 'currentColor');
                    } else {
                        btn.classList.remove('text-emerald-600');
                        btn.classList.add('text-zinc-400', 'hover:text-emerald-600');
                        icon.setAttribute('fill', 'none');
                    }
                    if(btn.querySelector('.b-count')) {
                        let t = countSpan.innerText.replace(/[0-9]+/, data.count);
                        countSpan.innerText = t;
                    }
                }
            });
        },
        
        toggleLike(questionId, event) {
            let btn = event.currentTarget;
            let icon = btn.querySelector('svg');
            let countSpan = btn.querySelector('.l-count') || btn;

            fetch('/interaction/like/' + questionId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    if(data.status === 'attached') {
                        btn.classList.add('text-blue-600');
                        btn.classList.remove('text-zinc-400', 'hover:text-blue-600');
                        icon.setAttribute('fill', 'currentColor');
                    } else {
                        btn.classList.remove('text-blue-600');
                        btn.classList.add('text-zinc-400', 'hover:text-blue-600');
                        icon.setAttribute('fill', 'none');
                    }
                    if(btn.querySelector('.l-count')) {
                        let t = countSpan.innerText.replace(/[0-9]+/, data.count);
                        countSpan.innerText = t;
                    }
                }
            });
        },

        generateAiExplanation(questionId) {
            let btn = document.getElementById('ai-btn-' + questionId);
            if(!btn) return;
            let origText = btn.innerHTML;
            btn.innerHTML = '<svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Generating...';
            
            fetch('/interaction/ai-explanation/' + questionId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    let wrapper = document.getElementById('explanation-wrapper-' + questionId);
                    if (wrapper) {
                        wrapper.innerHTML = `
                            <div class="prose prose-sm md:prose-base tex2jax_process max-w-none text-zinc-700 dark:prose-invert dark:text-zinc-200" data-math-content>
                                ${data.description}
                            </div>
                        `;
                        if (typeof window.renderKatex === 'function') { window.renderKatex(); } else if (typeof window.renderMath === 'function') {
                            window.renderMath();
                        }
                    }
                } else {
                    alert(data.message);
                    btn.innerHTML = origText;
                }
            }).catch(() => {
                alert('Error generating explanation');
                btn.innerHTML = origText;
            });
        }
    };
}
</script>
</x-layouts.frontend>