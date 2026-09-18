@extends('layouts.frontend')

@section('title', 'চাকরির পরীক্ষার প্রশ্ন সমাধান')
@section('description', 'বিসিএস, ব্যাংক, শিক্ষক নিয়োগ ও বিভিন্ন প্রতিষ্ঠানের বিগত পরীক্ষার নির্ভুল সমাধান ও প্রতিষ্ঠান ভিত্তিক প্রশ্ন আর্কাইভ।')

@section('content')
    <div class="pb-12">

        <!-- ============================================== -->
        <!-- MASTHEAD — title + underline tab nav, one row   -->
        <!-- ============================================== -->
        <div class="border-b border-slate-200 dark:border-slate-800 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pb-5">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        চাকরির পরীক্ষার প্রশ্ন সমাধান
                    </h1>
                    <p class="mt-1.5 text-[13px] text-slate-500 dark:text-slate-400 max-w-xl leading-relaxed">
                        বিসিএস, ব্যাংক, শিক্ষক নিয়োগ ও বিভিন্ন প্রতিষ্ঠানের বিগত পরীক্ষার নির্ভুল সমাধান ও প্রতিষ্ঠান ভিত্তিক প্রশ্ন আর্কাইভ।
                    </p>
                </div>

                <nav class="flex items-center gap-6 shrink-0 overflow-x-auto">
                    <a href="?tab=exams" class="flex items-center gap-2 pb-1 text-sm font-bold whitespace-nowrap border-b-2 transition-colors {{ $tab === 'exams' ? 'text-emerald-600 dark:text-emerald-400 border-emerald-500' : 'text-slate-500 dark:text-slate-400 border-transparent hover:text-slate-800 dark:hover:text-slate-200' }}">
                        <flux:icon.document-check class="w-4 h-4" /> পরীক্ষা ও সমাধান
                    </a>
                    <a href="?tab=topics" class="flex items-center gap-2 pb-1 text-sm font-bold whitespace-nowrap border-b-2 transition-colors {{ $tab === 'topics' ? 'text-emerald-600 dark:text-emerald-400 border-emerald-500' : 'text-slate-500 dark:text-slate-400 border-transparent hover:text-slate-800 dark:hover:text-slate-200' }}">
                        <flux:icon.book-open class="w-4 h-4" /> বিষয় ও অধ্যায়ভিত্তিক
                    </a>
                    <a href="?tab=organizations" class="flex items-center gap-2 pb-1 text-sm font-bold whitespace-nowrap border-b-2 transition-colors {{ $tab === 'organizations' ? 'text-emerald-600 dark:text-emerald-400 border-emerald-500' : 'text-slate-500 dark:text-slate-400 border-transparent hover:text-slate-800 dark:hover:text-slate-200' }}">
                        <flux:icon.building-office-2 class="w-4 h-4" /> প্রতিষ্ঠান
                    </a>
                </nav>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- CONTENT -->
        <!-- ============================================== -->
        <div>
            @if($tab === 'exams')

                <!-- Filter disclosure — native <details>, no JS needed -->
                <details class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl mb-6 open:pb-4">
                    <summary class="list-none cursor-pointer p-4 flex items-center justify-between select-none">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-400 shrink-0">
                                <flux:icon.funnel class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="text-[13px] font-bold text-slate-700 dark:text-slate-300">ফিল্টার ও অনুসন্ধান অপশন</h3>
                                <p class="text-[11px] text-slate-400 mt-0.5">গ্রেড, সাল, প্রতিষ্ঠান ও ধরন অনুযায়ী ফিল্টার করতে ক্লিক করুন</p>
                            </div>
                        </div>
                        <flux:icon.chevron-down class="w-4 h-4 text-slate-400 shrink-0 transition-transform group-open:rotate-180" />
                    </summary>
                    <div class="px-4 pt-1 text-[12px] text-slate-400">
                        {{-- ফিল্টার ফর্ম এখানে বসবে --}}
                    </div>
                </details>

                <!-- Exam list — ledger rows, not repeated cards -->
                <div class="border-t border-slate-200 dark:border-slate-800">
                    @forelse($exams as $exam)
                        <div class="group flex flex-col md:flex-row md:items-center gap-4 md:gap-6 py-5 border-b border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/60 md:hover:pl-2 transition-all">

                            <div class="w-12 h-12 rounded-full border border-emerald-100 dark:border-emerald-900/40 flex items-center justify-center shrink-0 text-emerald-600 dark:text-emerald-400 font-bold text-[10px] bg-emerald-50/60 dark:bg-emerald-900/10 uppercase tracking-tighter">
                                @if($exam->institution && $exam->institution->slug)
                                    {{ Str::limit(strtoupper($exam->institution->slug), 4, '') }}
                                @else
                                    EXAM
                                @endif
                            </div>

                            <div class="flex-grow w-full min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1.5 text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                                    <span class="text-emerald-600 dark:text-emerald-400 font-bold">{{ $exam->institution?->name ?? 'জেনারেল' }}</span>
                                    <span class="text-slate-300 dark:text-slate-700">&bull;</span>
                                    <span>{{ $exam->exam_date ? $exam->exam_date->format('d M, Y') : '-' }}</span>
                                    <span class="text-slate-300 dark:text-slate-700">&bull;</span>
                                    <span class="text-indigo-600 dark:text-indigo-400 flex items-center gap-1"><flux:icon.tag class="w-3 h-3" /> {{ $exam->examCategory?->name ?? 'সাধারণ গ্রেড' }}</span>
                                </div>
                                <a href="{{ $exam->institution ? route('job-solutions.show', ['institutionSlug' => $exam->institution->slug, 'examSlug' => $exam->slug]) : '#' }}" class="block">
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white leading-snug group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                        {{ $exam->title }}
                                    </h3>
                                </a>
                                <div class="mt-1.5 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-[10px] font-bold uppercase text-slate-500 dark:text-slate-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $exam->type }}
                                    </span>
                                    <span class="text-slate-300 dark:text-slate-700">|</span>
                                    প্রশ্ন: {{ $exam->questions_count }} টি
                                    <span class="text-slate-300 dark:text-slate-700">|</span>
                                    পূর্ণমান: {{ $exam->total_marks ?? '-' }}
                                </div>
                            </div>

                            <div class="shrink-0 w-full md:w-auto">
                                <flux:button href="{{ $exam->institution ? route('job-solutions.show', ['institutionSlug' => $exam->institution->slug, 'examSlug' => $exam->slug]) : '#' }}" size="sm" variant="primary" class="bg-slate-900 dark:bg-emerald-600 hover:bg-emerald-600 dark:hover:bg-emerald-500 text-white border-0 rounded-lg px-5 w-full md:w-auto">
                                    সমাধান পড়ুন <flux:icon.chevron-right class="w-3 h-3 ml-1" />
                                </flux:button>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                            কোনো পরীক্ষা পাওয়া যায়নি।
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $exams->links() }}
                </div>

            @elseif($tab === 'topics')

                <!-- Filter panel -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 mb-6">
                    <div class="flex flex-col md:flex-row justify-between md:items-start gap-4 mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">
                        <div>
                            <h2 class="text-base font-bold text-slate-900 dark:text-white mb-1">
                                বিষয় ও অধ্যায় ভিত্তিক প্রশ্নব্যাংক
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">বিষয় ও নির্দিষ্ট অধ্যায় ভিত্তিক বিগত বিসিএস, ব্যাংক ও সরকারি নিয়োগ পরীক্ষার প্রশ্ন সমাধান পড়ুন</p>
                        </div>
                        <div class="w-full md:w-80">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <flux:icon.magnifying-glass class="w-4 h-4 text-slate-400" />
                                </div>
                                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500" placeholder="প্রশ্ন বা ব্যাখ্যার কিওয়ার্ড দিয়ে খুঁজুন..." disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Subjects -->
                    <div class="mb-6">
                        <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-3 flex items-center gap-1.5"><flux:icon.book-open class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" /> বিষয় নির্বাচন করুন:</p>
                        <div class="flex flex-wrap gap-2.5">
                            <a href="?tab=topics" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition-colors {{ is_null($subject) ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                                সকল বিষয় <span class="px-1.5 py-0.5 rounded text-[9px] {{ is_null($subject) ? 'bg-white/20 text-white' : 'bg-white text-slate-400 dark:bg-slate-700 dark:text-slate-300' }}">{{ $subjects->sum('questions_count') }}</span>
                            </a>
                            @foreach($subjects as $subj)
                                <a href="?tab=topics&subject={{ $subj->slug }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition-colors {{ $subject === $subj->slug ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                                    {{ $subj->name }} <span class="px-1.5 py-0.5 rounded text-[9px] {{ $subject === $subj->slug ? 'bg-white/20 text-white' : 'bg-white text-slate-400 dark:bg-slate-700 dark:text-slate-300' }}">{{ $subj->questions_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Chapters -->
                    @if($currentSubject)
                        <div class="mb-6">
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-3 flex items-center gap-1.5"><flux:icon.bars-3-bottom-left class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" /> '{{ $currentSubject->name }}' এর অধ্যায় বা পরিচ্ছেদ:</p>
                            <div class="flex flex-wrap gap-2.5">
                                <a href="?tab=topics&subject={{ $subject }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition-colors {{ is_null($topic) ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                                    সকল অধ্যায়
                                </a>
                                @foreach($chapters as $chap)
                                    <a href="?tab=topics&subject={{ $subject }}&topic={{ $chap->slug }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition-colors {{ $topic === $chap->slug ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                                        {{ $chap->name }} <span class="px-1.5 py-0.5 rounded text-[9px] {{ $topic === $chap->slug ? 'bg-white/20 text-white' : 'bg-white text-slate-400 dark:bg-slate-700 dark:text-slate-300' }}">{{ $chap->questions_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Topics -->
                    @if($currentChapter)
                        <div>
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-3 flex items-center gap-1.5"><flux:icon.tag class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" /> '{{ $currentChapter->name }}' এর সাব-টপিক / বিষয়বস্তু:</p>
                            <div class="flex flex-wrap gap-2.5">
                                <a href="?tab=topics&subject={{ $subject }}&topic={{ $topic }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition-colors {{ is_null($sub_topic) ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                                    সকল সাব-টপিক
                                </a>
                                @foreach($topics as $subTop)
                                    <a href="?tab=topics&subject={{ $subject }}&topic={{ $topic }}&sub_topic={{ $subTop->slug }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition-colors {{ $sub_topic === $subTop->slug ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                                        {{ $subTop->name }} <span class="px-1.5 py-0.5 rounded text-[9px] {{ $sub_topic === $subTop->slug ? 'bg-white/20 text-white' : 'bg-white text-slate-400 dark:bg-slate-700 dark:text-slate-300' }}">{{ $subTop->questions_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Current filter status -->
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                            @if($currentSubject) {{ $currentSubject->name }} @else সকল বিষয় @endif
                            @if($currentChapter) > {{ $currentChapter->name }} @endif
                            @if($currentTopic) > {{ $currentTopic->name }} @endif
                            এর প্রশ্নসমূহ
                        </h3>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 tabular-nums">মোট {{ $total_questions }} টি</span>
                    </div>
                    @if($currentSubject || $currentChapter || $currentTopic)
                        <a href="?tab=topics" class="text-[11px] font-bold text-rose-500 hover:text-rose-600 flex items-center gap-1">
                            <flux:icon.x-mark class="w-3 h-3" /> ফিল্টার রিসেট
                        </a>
                    @endif
                </div>

                <!-- Questions — exam-paper style, numbered -->
                <div class="space-y-5">
                    @forelse($questions as $index => $question)
                        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 hover:border-emerald-300 dark:hover:border-emerald-800 transition-colors">

                            <!-- Meta row -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-slate-900 dark:text-white font-extrabold text-sm tabular-nums w-6 shrink-0">
                                        {{ $questions->firstItem() + $index }}.
                                    </span>
                                    <div class="flex items-center gap-1.5 text-[10px] font-bold">
                                        <span class="bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 px-2 py-1 rounded">{{ $question->subject?->name ?? 'N/A' }}</span>
                                        @if($question->chapter)
                                            <span class="bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 px-2 py-1 rounded">{{ $question->chapter->name }}</span>
                                        @endif
                                        @if($question->topic)
                                            <span class="bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400 px-2 py-1 rounded flex items-center gap-1"><flux:icon.arrow-turn-down-right class="w-2.5 h-2.5" /> {{ $question->topic->name }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 text-slate-400 shrink-0">
                                    <button class="hover:text-rose-500 transition-colors"><flux:icon.heart class="w-4 h-4" /></button>
                                    <button class="hover:text-emerald-500 transition-colors"><flux:icon.share class="w-4 h-4" /></button>
                                    <button class="hover:text-amber-500 transition-colors"><flux:icon.exclamation-triangle class="w-4 h-4" /></button>
                                </div>
                            </div>

                            <!-- Question Title -->
                            <div class="text-base font-bold text-slate-900 dark:text-white leading-snug mb-5 pl-9 flex flex-wrap items-baseline gap-2">
                                @php
                                    $cleanTitle = html_entity_decode($question->title ?? '');
                                    $cleanTitle = preg_replace('/<p[^>]*>/is', '<span>', $cleanTitle);
                                    $cleanTitle = str_replace('</p>', '</span> ', $cleanTitle);
                                    $cleanTitle = preg_replace('/<div[^>]*>/is', '<span>', $cleanTitle);
                                    $cleanTitle = str_replace('</div>', '</span> ', $cleanTitle);
                                    $cleanTitle = preg_replace('/<a[^>]*>/is', '', $cleanTitle);
                                    $cleanTitle = str_replace('</a>', '', $cleanTitle);
                                @endphp
                                <a href="{{ route('question.show', $question->slug) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors cursor-pointer tex2jax_process" data-math-content>{!! $cleanTitle !!}</a>
                                @if($question->pastExams->count() > 0)
                                    <span class="text-[10px] font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-1.5 py-0.5 rounded">
                                    [{{ $question->pastExams->first()->title }}]
                                </span>
                                @endif
                            </div>

                            <!-- Options — OMR-style bubble markers -->
                            @if($question->question_type === 'mcq' && is_array($question->extra_content))
                                <div class="pl-9 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($question->extra_content as $key => $option)
                                        @php
                                            $isCorrect = isset($option['is_correct']) && $option['is_correct'];
                                        @endphp
                                        <div class="flex items-center gap-3 p-3 border rounded-xl transition-all {{ $isCorrect ? 'bg-emerald-50 border-emerald-300 dark:bg-emerald-900/20 dark:border-emerald-700' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600' }}">
                                            <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center shrink-0 text-[11px] font-bold {{ $isCorrect ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300 dark:border-slate-600 text-slate-500 dark:text-slate-400' }}">{{ ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ'][$loop->index] ?? chr(65 + $loop->index) }}</div><span class="text-[13px] font-medium flex-grow tex2jax_process {{ $isCorrect ? 'text-emerald-800 dark:text-emerald-200' : 'text-slate-700 dark:text-slate-300' }}" data-math-content>{!! $option['option_text'] !!}</span>@if($isCorrect)<flux:icon.check class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" />@endif
                                        </div>
                                    @endforeach
                                </div>
                            @elseif(in_array($question->question_type, ['written', 'short', 'cq']))
                                <div class="ml-9 mt-1 p-4 bg-emerald-50/50 dark:bg-emerald-900/10 border-l-2 border-emerald-400 dark:border-emerald-700 rounded-r-xl">
                                    <p class="text-xs font-bold text-emerald-800 dark:text-emerald-400 mb-2 flex items-center gap-1.5"><flux:icon.check-circle class="w-4 h-4" /> উত্তর / সমাধান:</p>
                                    <div class="text-sm text-slate-700 dark:text-slate-300 tex2jax_process" data-math-content>
                                        @if($question->description)
                                            {!! $question->description !!}
                                        @else
                                            (সমাধান দেওয়া হয়নি)
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Explanation -->
                            @if($question->description && $question->question_type === 'mcq')
                                <div class="ml-9 mt-4 p-4 bg-slate-50 dark:bg-slate-800/50 border-l-2 border-slate-300 dark:border-slate-700 rounded-r-xl">
                                    <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400 mb-2 flex items-center gap-1.5"><flux:icon.information-circle class="w-4 h-4" /> ব্যাখ্যা:</p>
                                    <div class="text-[13px] text-slate-700 dark:text-slate-300 leading-relaxed">
                                        {!! $question->description !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                            কোনো প্রশ্ন পাওয়া যায়নি।
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $questions->links() }}
                </div>

            @elseif($tab === 'organizations')

                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 mb-6">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white mb-1">
                        প্রতিষ্ঠান ভিত্তিক প্রশ্ন সমাধান ডাটাবেজ
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">নির্দিষ্ট প্রতিষ্ঠানের লোগো বা নামে ক্লিক করে ঐ প্রতিষ্ঠানের অনুষ্ঠিত সকল বিগত নিয়োগ পরীক্ষা একত্রে পড়ুন</p>

                    <flux:input placeholder="প্রতিষ্ঠান খুঁজুন (যেমন: BPSC, ব্যাংক)..." icon="magnifying-glass" class="max-w-md" />
                </div>

                <!-- Institutions — index rows, logo + name + count -->
                <div class="border-t border-slate-200 dark:border-slate-800">
                    @forelse($institutions as $inst)
                        <a href="{{ route('institution.show', $inst->slug) }}" class="group flex items-center gap-4 py-4 border-b border-slate-200 dark:border-slate-800 hover:pl-2 hover:bg-slate-50 dark:hover:bg-slate-900/60 transition-all">
                            @if($inst->logo_path)
                                <img src="{{ Storage::url($inst->logo_path) }}" alt="{{ $inst->name }}" class="w-11 h-11 object-contain shrink-0 rounded-lg border border-slate-100 dark:border-slate-800 bg-white p-1">
                            @else
                                <div class="w-11 h-11 rounded-full bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center shrink-0">
                                    <flux:icon.building-office-2 class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                                </div>
                            @endif

                            <div class="flex-grow min-w-0">
                                <div class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors truncate">{{ $inst->name }}</div>
                                @if($inst->slug)
                                    <div class="text-[11px] text-slate-400 uppercase">[{{ $inst->slug }}]</div>
                                @endif
                            </div>

                            <div class="shrink-0 text-right">
                                <div class="text-sm font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $inst->past_exams_count }}</div>
                                <div class="text-[10px] text-slate-400">নিয়োগ পরীক্ষা</div>
                            </div>
                        </a>
                    @empty
                        <div class="py-12 text-center text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                            কোনো প্রতিষ্ঠান পাওয়া যায়নি।
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $institutions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
