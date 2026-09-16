<div class="space-y-6 pb-12">
    <!-- Header & Tabs (Single Row) -->
    <div class="bg-emerald-50/50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/50 rounded-2xl p-6 mb-6 flex flex-col lg:flex-row items-center justify-between gap-6">
        <div class="flex flex-col gap-1.5 w-full lg:w-auto">
            <h1 class="text-2xl font-extrabold text-slate-800 dark:text-slate-200 flex items-center gap-2.5">
                <span class="w-3 h-3 rounded-full bg-emerald-500"></span> 
                চাকরির পরীক্ষার প্রশ্ন সমাধান
            </h1>
            <p class="text-[13px] text-slate-500 font-medium ml-5">বিসিএস, ব্যাংক, শিক্ষক নিয়োগ ও বিভিন্ন প্রতিষ্ঠানের বিগত পরীক্ষার নির্ভুল সমাধান ও প্রতিষ্ঠান ভিত্তিক প্রশ্ন আর্কাইভ।</p>
        </div>
        
        <div class="flex gap-1 p-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full w-full sm:w-auto overflow-x-auto shadow-sm shrink-0">
            <button wire:click="setTab('exams')" class="flex items-center gap-2 px-5 py-2 rounded-full font-bold text-xs transition-all whitespace-nowrap {{ $tab === 'exams' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 border border-transparent' }}">
                <flux:icon.document-check class="w-3.5 h-3.5" /> পরীক্ষা ও সমাধান
            </button>
            <button wire:click="setTab('topics')" class="flex items-center gap-2 px-5 py-2 rounded-full font-bold text-xs transition-all whitespace-nowrap {{ $tab === 'topics' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 border border-transparent' }}">
                <flux:icon.book-open class="w-3.5 h-3.5" /> বিষয় ও অধ্যায়ভিত্তিক
            </button>
            <button wire:click="setTab('organizations')" class="flex items-center gap-2 px-5 py-2 rounded-full font-bold text-xs transition-all whitespace-nowrap {{ $tab === 'organizations' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 border border-transparent' }}">
                <flux:icon.building-office-2 class="w-3.5 h-3.5" /> প্রতিষ্ঠান
            </button>
        </div>
    </div>

    <!-- Content -->
    <div class="mt-6">
        @if($tab === 'exams')
            <!-- Filter Accordion -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 mb-6 flex justify-between items-center cursor-pointer hover:border-emerald-300 transition-colors shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                        <flux:icon.funnel class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 class="text-[13px] font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1">ফিল্টার ও অনুসন্ধান অপশন <flux:icon.chevron-down class="w-3 h-3 text-slate-400" /></h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">গ্রেড, সাল, প্রতিষ্ঠান ও ধরন অনুযায়ী ফিল্টার করতে ক্লিক করুন</p>
                    </div>
                </div>
                <div class="text-[11px] font-bold text-emerald-600 mr-2">
                    ফিল্টার খুলুন
                </div>
            </div>

            <!-- List View -->
            <div class="space-y-4">
                @forelse($exams as $exam)
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 hover:border-emerald-300 dark:hover:border-emerald-800 transition-colors shadow-sm flex flex-col md:flex-row gap-5 items-center">
                        <div class="w-14 h-14 rounded-full border border-emerald-100 dark:border-emerald-900/30 flex items-center justify-center shrink-0 text-emerald-600 font-bold text-[11px] bg-emerald-50/50 dark:bg-slate-900 uppercase tracking-tighter">
                            @if($exam->institution && $exam->institution->slug)
                                {{ Str::limit(strtoupper($exam->institution->slug), 4, '') }}
                            @else
                                EXAM
                            @endif
                        </div>
                        
                        <div class="flex-grow w-full">
                            <div class="flex flex-wrap items-center gap-2 mb-1.5 text-[11px] text-slate-500 font-medium">
                                <span class="text-emerald-600 font-bold">{{ $exam->institution?->name ?? 'জেনারেল' }}</span>
                                <span>&bull;</span>
                                <span>{{ $exam->exam_date ? $exam->exam_date->format('d M, Y') : '-' }}</span>
                                <span>&bull;</span>
                                <span class="bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400 px-2 py-0.5 rounded-full flex items-center gap-1"><flux:icon.tag class="w-3 h-3" /> {{ $exam->examCategory?->name ?? 'সাধারণ গ্রেড' }}</span>
                            </div>
                            <a href="{{ $exam->institution ? route('job-solutions.show', ['institutionSlug' => $exam->institution->slug, 'examSlug' => $exam->slug]) : '#' }}" class="block">
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 leading-snug mb-3 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                                    {{ $exam->title }}
                                </h3>
                            </a>
                            <div class="flex items-center text-xs text-slate-500 font-medium">
                                প্রশ্ন: {{ $exam->questions_count }} টি <span class="mx-2 text-slate-300">|</span> পূর্ণমান: {{ $exam->total_marks ?? '-' }}
                            </div>
                        </div>
                        
                        <div class="flex flex-row md:flex-col items-center justify-between md:justify-center gap-3 w-full md:w-auto shrink-0 mt-2 md:mt-0 border-t md:border-t-0 pt-3 md:pt-0 border-slate-100 dark:border-slate-800">
                            <span class="bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $exam->type }}</span>
                            <flux:button href="{{ $exam->institution ? route('job-solutions.show', ['institutionSlug' => $exam->institution->slug, 'examSlug' => $exam->slug]) : '#' }}" size="sm" variant="primary" class="bg-emerald-600 hover:bg-emerald-700 text-white border-0 rounded-full px-5 w-full md:w-auto">
                                সমাধান পড়ুন <flux:icon.chevron-right class="w-3 h-3 ml-1" />
                            </flux:button>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-500 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                        কোনো পরীক্ষা পাওয়া যায়নি।
                    </div>
                @endforelse
            </div>
            
            <div class="mt-6">
                {{ $exams->links() }}
            </div>

        @elseif($tab === 'topics')
            <!-- Filter Box -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 mb-6 shadow-sm">
                <div class="flex flex-col md:flex-row justify-between md:items-start gap-4 mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200 flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> বিষয় ও অধ্যায় ভিত্তিক প্রশ্নব্যাংক
                        </h2>
                        <p class="text-xs text-slate-500">বিষয় ও নির্দিষ্ট অধ্যায় ভিত্তিক বিগত বিসিএস, ব্যাংক ও সরকারি নিয়োগ পরীক্ষার প্রশ্ন সমাধান পড়ুন</p>
                    </div>
                    <div class="w-full md:w-80">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <flux:icon.magnifying-glass class="w-4 h-4 text-slate-400" />
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500" placeholder="প্রশ্ন বা ব্যাখ্যার কিওয়ার্ড দিয়ে খুঁজুন..." disabled>
                        </div>
                    </div>
                </div>

                <!-- Subjects -->
                <div class="mb-6">
                    <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-3 flex items-center gap-1.5"><flux:icon.book-open class="w-3.5 h-3.5 text-emerald-600" /> বিষয় নির্বাচন করুন:</p>
                    <div class="flex flex-wrap gap-2.5">
                        <button wire:click="selectSubject(null)" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition-colors {{ is_null($subject) ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                            সকল বিষয় <span class="px-1.5 py-0.5 rounded text-[9px] {{ is_null($subject) ? 'bg-white/20 text-white' : 'bg-white text-slate-400 dark:bg-slate-700 dark:text-slate-300' }}">{{ $subjects->sum('questions_count') }}</span>
                        </button>
                        @foreach($subjects as $subj)
                            <button wire:click="selectSubject('{{ $subj->slug }}')" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition-colors {{ $subject === $subj->slug ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                                {{ $subj->name }} <span class="px-1.5 py-0.5 rounded text-[9px] {{ $subject === $subj->slug ? 'bg-white/20 text-white' : 'bg-white text-slate-400 dark:bg-slate-700 dark:text-slate-300' }}">{{ $subj->questions_count }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Chapters -->
                @if($currentSubject)
                <div class="mb-6">
                    <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-3 flex items-center gap-1.5"><flux:icon.bars-3-bottom-left class="w-3.5 h-3.5 text-emerald-600" /> '{{ $currentSubject->name }}' এর অধ্যায় বা পরিচ্ছেদ:</p>
                    <div class="flex flex-wrap gap-2.5">
                        <button wire:click="selectChapter(null)" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition-colors {{ is_null($topic) ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                            সকল অধ্যায়
                        </button>
                        @foreach($chapters as $chap)
                            <button wire:click="selectChapter('{{ $chap->slug }}')" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition-colors {{ $topic === $chap->slug ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                                {{ $chap->name }} <span class="px-1.5 py-0.5 rounded text-[9px] {{ $topic === $chap->slug ? 'bg-white/20 text-white' : 'bg-white text-slate-400 dark:bg-slate-700 dark:text-slate-300' }}">{{ $chap->questions_count }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Topics -->
                @if($currentChapter)
                <div>
                    <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-3 flex items-center gap-1.5"><flux:icon.tag class="w-3.5 h-3.5 text-indigo-600" /> '{{ $currentChapter->name }}' এর সাব-টপিক / বিষয়বস্তু:</p>
                    <div class="flex flex-wrap gap-2.5">
                        <button wire:click="selectTopic(null)" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition-colors {{ is_null($sub_topic) ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                            সকল সাব-টপিক
                        </button>
                        @foreach($topics as $subTop)
                            <button wire:click="selectTopic('{{ $subTop->slug }}')" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition-colors {{ $sub_topic === $subTop->slug ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                                {{ $subTop->name }} <span class="px-1.5 py-0.5 rounded text-[9px] {{ $sub_topic === $subTop->slug ? 'bg-white/20 text-white' : 'bg-white text-slate-400 dark:bg-slate-700 dark:text-slate-300' }}">{{ $subTop->questions_count }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Current Filter Status Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200">
                        @if($currentSubject) {{ $currentSubject->name }} @else সকল বিষয় @endif
                        @if($currentChapter) > {{ $currentChapter->name }} @endif
                        @if($currentTopic) > {{ $currentTopic->name }} @endif
                        এর প্রশ্নসমূহ
                    </h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">মোট {{ $total_questions }} টি</span>
                </div>
                @if($currentSubject || $currentChapter || $currentTopic)
                    <button wire:click="resetFilters" class="text-[11px] font-bold text-red-500 hover:text-red-600 flex items-center gap-1">
                        <flux:icon.x-mark class="w-3 h-3" /> ফিল্টার রিসেট
                    </button>
                @endif
            </div>

            <!-- Questions List -->
            <div class="space-y-4">
                @forelse($questions as $index => $question)
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 hover:border-emerald-300 dark:hover:border-emerald-800 transition-colors shadow-sm">
                        
                        <!-- Meta row -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex gap-2">
                                <span class="bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 font-bold px-2.5 py-1 rounded-md text-[11px]">
                                    {{ $questions->firstItem() + $index }}
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
                            <div class="flex items-center gap-3 text-slate-400">
                                <button class="hover:text-red-500 transition-colors"><flux:icon.heart class="w-4 h-4" /></button>
                                <button class="hover:text-emerald-500 transition-colors"><flux:icon.share class="w-4 h-4" /></button>
                                <button class="hover:text-amber-500 transition-colors"><flux:icon.exclamation-triangle class="w-4 h-4" /></button>
                            </div>
                        </div>

                        <!-- Question Title -->
                        <div class="text-base font-bold text-slate-900 dark:text-slate-100 leading-snug mb-5 flex flex-wrap items-baseline gap-2">
                            <a href="{{ route('question.show', $question->slug) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors cursor-pointer">{!! $question->title !!}</a> 
                            @if($question->pastExams->count() > 0)
                                <span class="text-[10px] font-medium text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-1.5 py-0.5 rounded">
                                    [{{ $question->pastExams->first()->title }}]
                                </span>
                            @endif
                        </div>
                        
                        <!-- Options -->
                        @if($question->question_type === 'mcq' && is_array($question->extra_content))
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($question->extra_content as $key => $option)
                                    @php
                                        $isCorrect = isset($option['is_correct']) && $option['is_correct'];
                                    @endphp
                                    <div class="flex items-center gap-3 p-3 border rounded-xl transition-all {{ $isCorrect ? 'bg-emerald-50 border-emerald-500 dark:bg-emerald-900/20 dark:border-emerald-600 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 hover:border-slate-300 hover:bg-slate-50' }}">
                                        <div class="w-6 h-6 rounded-full border flex items-center justify-center shrink-0 text-xs font-bold {{ $isCorrect ? 'bg-emerald-100 border-emerald-200 text-emerald-700 dark:bg-emerald-900/40 dark:border-emerald-700 dark:text-emerald-400' : 'bg-white border-slate-200 text-slate-500 dark:bg-slate-800 dark:border-slate-600' }}">{{ ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ'][$key] ?? chr(65 + $key) }}</div><span class="text-[13px] font-medium flex-grow {{ $isCorrect ? 'text-emerald-800 dark:text-emerald-200' : 'text-slate-700 dark:text-slate-300' }}">{!! $option['option_text'] !!}</span>@if($isCorrect)<flux:icon.check class="w-4 h-4 text-emerald-500 shrink-0" />@endif
                                    </div>
                                @endforeach
                            </div>
                        @elseif(in_array($question->question_type, ['written', 'short', 'cq']))
                            <div class="mt-4 p-4 bg-emerald-50/50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/30 rounded-xl">
                                <p class="text-xs font-bold text-emerald-800 dark:text-emerald-400 mb-2 flex items-center gap-1.5"><flux:icon.check-circle class="w-4 h-4" /> উত্তর / সমাধান:</p>
                                <div class="text-sm text-slate-700 dark:text-slate-300">
                                    @if($question->description)
                                        {!! $question->description !!}
                                    @else
                                        (সমাধান দেওয়া হয়নি)
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        <!-- Explanation -->
                        @if($question->description && $question->question_type === 'mcq')
                            <div class="mt-5 p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 rounded-xl">
                                <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400 mb-2 flex items-center gap-1.5"><flux:icon.information-circle class="w-4 h-4" /> ব্যাখ্যা:</p>
                                <div class="text-[13px] text-slate-700 dark:text-slate-300 leading-relaxed">
                                    {!! $question->description !!}
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-500 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                        কোনো প্রশ্ন পাওয়া যায়নি।
                    </div>
                @endforelse
            </div>
            
            <div class="mt-6">
                {{ $questions->links() }}
            </div>

        @elseif($tab === 'organizations')
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-6 mb-6">
                <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2 mb-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> 
                    প্রতিষ্ঠান ভিত্তিক প্রশ্ন সমাধান ডাটাবেজ
                </h2>
                <p class="text-sm text-slate-500 mb-4">নির্দিষ্ট প্রতিষ্ঠানের লোগো বা নামে ক্লিক করে ঐ প্রতিষ্ঠানের অনুষ্ঠিত সকল বিগত নিয়োগ পরীক্ষা একত্রে পড়ুন</p>
                
                <flux:input placeholder="প্রতিষ্ঠান খুঁজুন (যেমন: BPSC, ব্যাংক)..." icon="magnifying-glass" class="max-w-md" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($institutions as $inst)
                    <a href="{{ route('institution.show', $inst->slug) }}" class="block h-full group">
                        <div class="border border-slate-200 dark:border-slate-800 rounded-xl group-hover:border-emerald-500 group-hover:shadow-md transition-all flex flex-col items-center text-center p-6 bg-white dark:bg-slate-900 h-full cursor-pointer">
                        @if($inst->logo_path)
                            <img src="{{ Storage::url($inst->logo_path) }}" alt="{{ $inst->name }}" class="w-16 h-16 object-contain mb-4">
                        @else
                            <div class="w-16 h-16 rounded-full bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center mb-4">
                                <flux:icon.building-office-2 class="w-8 h-8 text-emerald-600" />
                            </div>
                        @endif
                        <flux:heading size="sm" class="mb-1">{{ $inst->name }}</flux:heading>
                        @if($inst->slug)
                            <p class="text-[11px] font-medium text-slate-400 mb-4 uppercase">[{{ $inst->slug }}]</p>
                        @endif
                        <div class="w-full flex justify-between items-center mt-auto pt-4 border-t border-slate-100 dark:border-slate-800">
                            <span class="text-xs text-slate-500">নিয়োগ পরীক্ষা</span>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full">
                                {{ $inst->past_exams_count }}
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500">
                        কোনো প্রতিষ্ঠান পাওয়া যায়নি।
                @endforelse
            </div>
            <div class="mt-6">
                {{ $institutions->links() }}
            </div>
        @endif
    </div>
</div>
