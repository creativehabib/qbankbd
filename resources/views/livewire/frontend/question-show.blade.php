<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 z-0 relative">
    
    <!-- Breadcrumbs -->
    <div class="mb-6">
        <nav class="flex text-[11px] text-zinc-500 font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="/" class="hover:text-emerald-600 flex items-center gap-1">
                        <flux:icon.home class="w-3 h-3" /> হোম
                    </a>
                </li>
                @if($question->subject)
                <li>
                    <div class="flex items-center">
                        <flux:icon.chevron-right class="w-3 h-3 mx-1" />
                        <a href="{{ route('job-solutions.index', ['tab' => 'topics', 'subject' => $question->subject->slug]) }}" class="text-zinc-500 hover:text-emerald-600 transition-colors">{{ $question->subject->name }}</a>
                    </div>
                </li>
                @endif
                @if($question->chapter)
                <li>
                    <div class="flex items-center">
                        <flux:icon.chevron-right class="w-3 h-3 mx-1" />
                        <a href="{{ route('job-solutions.index', ['tab' => 'topics', 'subject' => $question->subject->slug, 'topic' => $question->chapter->slug]) }}" class="text-zinc-500 hover:text-emerald-600 transition-colors">{{ $question->chapter->name }}</a>
                    </div>
                </li>
                @endif
                @if($question->topic)
                <li>
                    <div class="flex items-center">
                        <flux:icon.chevron-right class="w-3 h-3 mx-1" />
                        <a href="{{ route('job-solutions.index', ['tab' => 'topics', 'subject' => $question->subject->slug, 'topic' => $question->chapter->slug, 'sub_topic' => $question->topic->slug]) }}" class="text-zinc-500 hover:text-emerald-600 transition-colors">{{ $question->topic->name }}</a>
                    </div>
                </li>
                @endif
                <li>
                    <div class="flex items-center">
                        <flux:icon.chevron-right class="w-3 h-3 mx-1" />
                        <span class="text-zinc-700 dark:text-zinc-300 line-clamp-1 max-w-xs">{!! strip_tags($question->title) !!}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Side: Question Details (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <div class="bg-white dark:bg-zinc-900 border border-emerald-100 dark:border-zinc-800 rounded-2xl shadow-sm overflow-hidden relative">
                <!-- Top Emerald Line -->
                <div class="absolute top-0 left-0 w-full h-1 bg-emerald-500"></div>
                
                <div class="p-6 md:p-8">
                    <!-- Meta Row -->
                    

                    <!-- Question Title -->
                    <h1 class="text-xl md:text-2xl font-bold text-zinc-800 dark:text-zinc-100 leading-relaxed mb-3">
                        {!! $question->title !!}
                    </h1>
                    
                    <!-- Tags -->
                    <div class="mt-2 mb-8 flex flex-wrap gap-2 text-xs">
                        @if($question->subject)
                            <span class="rounded-full border border-indigo-200 bg-indigo-50/50 px-2 py-0.5 text-indigo-700 dark:border-indigo-800/50 dark:bg-indigo-900/20 dark:text-indigo-400">
                                {{ $question->subject->name }}
                            </span>
                        @endif
                        @if($question->chapter)
                            <span class="rounded-full border border-indigo-200 bg-indigo-50/50 px-2 py-0.5 text-indigo-700 dark:border-indigo-800/50 dark:bg-indigo-900/20 dark:text-indigo-400">
                                {{ $question->chapter->name }}
                            </span>
                        @endif
                        @if(isset($question->tags))
                            @foreach($question->tags as $tag)
                                <span class="rounded-full border border-indigo-200 bg-indigo-50/50 px-2 py-0.5 text-indigo-700 dark:border-indigo-800/50 dark:bg-indigo-900/20 dark:text-indigo-400">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                        @endif
                        @if($question->pastExams && $question->pastExams->count() > 0)
                            @foreach($question->pastExams as $exam)
                                <span class="rounded-full border border-indigo-200 bg-indigo-50/50 px-2 py-0.5 text-indigo-700 dark:border-indigo-800/50 dark:bg-indigo-900/20 dark:text-indigo-400">
                                    #{{ $exam->title }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                    
                    

                    <!-- Options Section -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-bold text-zinc-600 dark:text-zinc-400 flex items-center gap-1.5">
                                <flux:icon.list-bullet class="w-4 h-4" /> অপশনসমূহ
                            </h3>
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full">সঠিক উত্তর চিহ্নিত</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $options = is_string($question->extra_content) ? json_decode($question->extra_content, true) : ($question->extra_content ?? []);
                                $optionLetters = ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ'];
                            @endphp
                            
                            @if(is_array($options))
                                @foreach($options as $index => $optionData)
                                    @php
                                        // Handle both old and new formats gracefully
                                        $isCorrect = isset($optionData['is_correct']) ? $optionData['is_correct'] : false;
                                        $optionText = isset($optionData['option_text']) ? $optionData['option_text'] : (is_string($optionData) ? $optionData : '');
                                        $letter = $optionLetters[$index] ?? chr(65 + $index);
                                    @endphp
                                    <div class="flex items-center gap-2 rounded-lg border px-3 py-2 {{ $isCorrect ? 'border-emerald-300 bg-emerald-50 dark:border-emerald-600 dark:bg-emerald-900/20' : 'border-zinc-200 bg-white dark:border-zinc-600 dark:bg-zinc-800' }}">
                                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border text-xs font-semibold {{ $isCorrect ? 'border-emerald-500 bg-emerald-500 text-white' : 'border-zinc-300 text-zinc-700 dark:border-zinc-600 dark:text-zinc-200' }}">
                                            {{ $letter }}
                                        </span>
                                        <span class="text-sm prose prose-sm dark:prose-invert prose-p:my-0 text-zinc-800 dark:text-zinc-100" data-math-content>
                                            {!! $optionText !!}
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                    
                    
                    <!-- Bottom Action Bar & Explanation -->
                    <div x-data="{ openDescription: {{ filled($question->description) ? 'true' : 'false' }} }" class="mt-6 border-t border-zinc-200/60 pt-3 dark:border-zinc-700/60 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                            <button type="button" x-on:click="openDescription = !openDescription" class="inline-flex w-fit items-center gap-1 text-sm font-semibold text-zinc-500 hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400">
                                <span>Explanation</span>
                                <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="openDescription ? 'rotate-180' : ''" />
                            </button>

                            <div class="flex items-center gap-4 text-zinc-400 dark:text-zinc-500">
                                <div class="flex items-center gap-1.5" title="Views">
                                    <flux:icon.eye class="size-[18px]" />
                                    <span class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">{{ $question->views ?? 0 }}</span>
                                </div>
                                <button type="button" class="cursor-pointer hover:text-emerald-600 dark:hover:text-emerald-400" title="Statistics">
                                    <flux:icon.chart-pie class="size-[18px]" />
                                </button>
                                <button type="button" class="cursor-pointer hover:text-emerald-600 dark:hover:text-emerald-400" title="Bookmark">
                                    <flux:icon.bookmark class="size-[18px]" variant="outline" />
                                </button>
                                <button type="button" class="flex items-center gap-1 cursor-pointer hover:text-pink-500" title="Like">
                                    <flux:icon.heart class="size-[18px]" variant="outline" />
                                </button>
                                <button type="button" class="cursor-pointer hover:text-amber-500 dark:hover:text-amber-400" title="Report">
                                    <flux:icon.flag class="size-[18px]" />
                                </button>
                                <button type="button" class="cursor-pointer hover:text-blue-500 dark:hover:text-blue-400" title="Share">
                                    <flux:icon.share class="size-[18px]" />
                                </button>
                            </div>
                        </div>

                        <div x-show="openDescription" x-collapse x-cloak class="rounded-xl border border-dashed border-zinc-300 p-5 dark:border-zinc-600 mt-3">
                            @if(filled($question->description))
                                <div class="prose prose-sm tex2jax_process max-w-none text-zinc-700 dark:prose-invert dark:text-zinc-200" data-math-content>
                                    {!! $question->description !!}
                                </div>
                            @else
                                <div class="space-y-3 text-center">
                                    <div class="py-4">
                                        <flux:icon.sparkles class="mx-auto size-6 text-violet-500 mb-2" />
                                        <p class="font-semibold text-zinc-600 dark:text-zinc-300">কোনো ব্যাখ্যা নেই</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center gap-4">
                @if($prevQuestion)
                    <a href="{{ route('question.show', $prevQuestion->slug) }}" class="px-5 py-2.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-sm font-bold text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors flex items-center gap-2 cursor-pointer">
                        <flux:icon.chevron-left class="w-4 h-4" /> পূর্ববর্তী প্রশ্ন
                    </a>
                @else
                    <div class="px-5 py-2.5 rounded-xl border border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 text-sm font-bold text-zinc-400 dark:text-zinc-600 cursor-not-allowed flex items-center gap-2">
                        <flux:icon.chevron-left class="w-4 h-4" /> পূর্ববর্তী প্রশ্ন
                    </div>
                @endif
                
                @if($nextQuestion)
                    <a href="{{ route('question.show', $nextQuestion->slug) }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold shadow-md shadow-emerald-600/20 transition-colors flex items-center gap-2 cursor-pointer">
                        পরবর্তী প্রশ্ন <flux:icon.chevron-right class="w-4 h-4" />
                    </a>
                @else
                    <div class="px-5 py-2.5 rounded-xl bg-zinc-200 dark:bg-zinc-800 text-zinc-400 dark:text-zinc-600 text-sm font-bold cursor-not-allowed flex items-center gap-2">
                        পরবর্তী প্রশ্ন <flux:icon.chevron-right class="w-4 h-4" />
                    </div>
                @endif
            </div>

        </div>

        <!-- Right Side: Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Subject Chapters List -->
            @if(count($chapterStats) > 0)
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xs font-bold text-zinc-800 dark:text-zinc-200 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $question->subject->name ?? 'বিষয়' }} এর অধ্যায়সমূহ
                    </h3>
                    <span class="text-[10px] font-bold text-emerald-600">সকল</span>
                </div>
                
                <div class="space-y-1">
                    @foreach($chapterStats as $chap)
                        <div class="flex justify-between items-center px-3 py-2 rounded-lg text-xs {{ $question->chapter_id == $chap->id ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-bold' : 'text-zinc-600 dark:text-zinc-400' }}">
                            <span>{{ $chap->name }}</span>
                            <span class="text-[9px] px-1.5 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-500">{{ $chap->questions_count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Related Questions -->
            @if(count($relatedQuestions) > 0)
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm p-5">
                <h3 class="text-xs font-bold text-zinc-800 dark:text-zinc-200 flex items-center gap-2 mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> সম্পর্কিত আরও প্রশ্ন
                </h3>
                
                <div class="space-y-3">
                    @foreach($relatedQuestions as $related)
                        <a href="{{ route('question.show', $related->slug) }}" class="block p-3 rounded-xl border border-zinc-100 dark:border-zinc-800 hover:border-emerald-200 dark:hover:border-emerald-800 hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-colors group">
                            <h4 class="text-xs font-medium text-zinc-700 dark:text-zinc-300 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 line-clamp-2 leading-relaxed">
                                {!! strip_tags($related->title) !!}
                            </h4>
                            <div class="mt-2 text-[10px] text-zinc-400 font-medium flex justify-between items-center">
                                <span>See ▾</span>
                                <flux:icon.arrow-right class="w-3 h-3 text-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity" />
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
