<div>
    <!-- Breadcrumb -->
    <div class="mb-4">
        <nav class="flex text-[11px] text-zinc-500 font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="/" class="hover:text-emerald-600 flex items-center gap-1">
                        <flux:icon.home class="w-3 h-3" /> হোম
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <flux:icon.chevron-right class="w-3 h-3 mx-1" />
                        <a href="{{ route('job-solutions.index') }}" class="hover:text-emerald-600">জব সলিউশন</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <flux:icon.chevron-right class="w-3 h-3 mx-1" />
                        <span class="text-zinc-700 dark:text-zinc-300">{{ $institution->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Header Card -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 md:p-8 mb-8 shadow-sm flex flex-col md:flex-row gap-6 items-start md:items-center relative">
        <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl border border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/50 flex items-center justify-center p-2 shrink-0">
            @if($institution->logo_path)
                <img src="{{ Storage::url($institution->logo_path) }}" alt="{{ $institution->name }}" class="w-full h-full object-contain rounded-xl">
            @else
                <flux:icon.building-office-2 class="w-10 h-10 text-emerald-600" />
            @endif
        </div>
        
        <div class="flex-grow w-full">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 px-2 py-0.5 rounded text-[10px] font-bold">নিয়োগকারী প্রতিষ্ঠান</span>
                        @if($institution->established_year)
                            <span class="text-[11px] text-zinc-500 font-medium">প্রতিষ্ঠিত: {{ $institution->established_year }}</span>
                        @endif
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-zinc-800 dark:text-zinc-100 flex items-center gap-2">
                        {{ $institution->name }} @if($institution->short_name) <span class="text-zinc-400 font-normal">({{ strtoupper($institution->short_name) }})</span> @endif
                    </h1>
                </div>
                
                @if($institution->official_website)
                    <a href="{{ $institution->official_website }}" target="_blank" class="flex items-center gap-1.5 px-4 py-2 rounded-full border border-emerald-200 bg-emerald-50/50 hover:bg-emerald-50 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400 dark:hover:bg-emerald-900/40 text-xs font-bold transition-colors">
                        <flux:icon.arrow-top-right-on-square class="w-3.5 h-3.5" /> অফিসিয়াল ওয়েবসাইট &rarr;
                    </a>
                @endif
            </div>
            
            <div x-data="{ expanded: false }">
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-3 leading-relaxed max-w-4xl transition-all duration-300 ease-in-out overflow-hidden" :class="expanded ? 'max-h-[1000px]' : 'max-h-[46px] line-clamp-2'">
                    {{ $institution->description ?? $institution->name . ' কর্তৃক পরিচালিত বিগত সালের সকল পরীক্ষার প্রশ্ন ও সমাধান নিচে দেওয়া হলো।' }}
                </p>
                @if($institution->description && strlen($institution->description) > 150)
                    <button @click="expanded = !expanded" class="text-emerald-600 hover:text-emerald-700 dark:hover:text-emerald-500 text-xs font-bold mt-1.5 flex items-center gap-1 transition-colors">
                        <span x-text="expanded ? 'সংক্ষিপ্ত করুন' : 'আরও দেখুন'"></span> 
                        <flux:icon.chevron-down class="w-3 h-3 transition-transform" x-bind:class="expanded ? 'rotate-180' : ''" />
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Filter & Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-6">
        <div>
            <h2 class="text-lg font-bold text-zinc-800 dark:text-zinc-200 flex items-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> 
                অনুষ্ঠিত নিয়োগ ও প্রশ্ন সমাধান তালিকা ({{ $exams->total() }})
            </h2>
            <p class="text-xs text-zinc-500">{{ $institution->name }} কর্তৃক পরিচালিত বিগত সালের সকল পরীক্ষার পূর্ণাঙ্গ সমাধান</p>
        </div>
        
        <div class="flex items-center gap-2">
            <button wire:click="setType('all')" class="px-4 py-1.5 text-[11px] font-bold rounded-full transition-colors {{ $type === 'all' ? 'bg-emerald-600 text-white border border-emerald-600' : 'bg-white text-zinc-600 dark:bg-zinc-900 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50' }}">সকল</button>
            <button wire:click="setType('mcq')" class="px-4 py-1.5 text-[11px] font-bold rounded-full transition-colors {{ $type === 'mcq' ? 'bg-emerald-600 text-white border border-emerald-600' : 'bg-white text-zinc-600 dark:bg-zinc-900 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50' }}">MCQ</button>
            <button wire:click="setType('written')" class="px-4 py-1.5 text-[11px] font-bold rounded-full transition-colors {{ $type === 'written' ? 'bg-emerald-600 text-white border border-emerald-600' : 'bg-white text-zinc-600 dark:bg-zinc-900 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50' }}">লিখিত</button>
        </div>
    </div>

    <!-- Exams Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
        @forelse($exams as $exam)
            <a href="{{ route('job-solutions.show', ['institutionSlug' => $institution->slug, 'examSlug' => $exam->slug]) }}" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 shadow-sm hover:border-emerald-400 hover:shadow-md transition-all flex gap-5 group cursor-pointer">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50/50 dark:bg-zinc-800 border border-emerald-50 dark:border-zinc-700 flex items-center justify-center shrink-0">
                    <span class="text-emerald-700 dark:text-emerald-400 font-bold text-sm">{{ $exam->exam_date ? $exam->exam_date->format('Y') : 'N/A' }}</span>
                </div>
                <div class="flex-grow flex flex-col justify-between">
                    <div>
                        <div class="text-[10px] font-medium text-zinc-500 mb-1 flex items-center gap-1.5">
                            <span>{{ $exam->exam_date ? $exam->exam_date->format('d/m/Y') : '-' }}</span>
                            <span class="text-zinc-300">&bull;</span>
                            <span class="uppercase">{{ $exam->type }}</span>
                            <span class="text-zinc-300">&bull;</span>
                            <span>{{ $exam->total_marks ?? '-' }} নম্বর</span>
                        </div>
                        <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors mb-4">{{ $exam->title }}</h3>
                    </div>
                    
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-zinc-500 font-medium">মোট প্রশ্ন: {{ $exam->questions_count }} টি</span>
                        <span class="text-emerald-600 dark:text-emerald-400 font-bold flex items-center gap-1 hover:underline">
                            সমাধান পড়ুন <flux:icon.arrow-right class="w-3 h-3" />
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-1 md:col-span-2 text-center py-12 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl text-zinc-500">
                এই ক্যাটাগরিতে কোনো পরীক্ষা পাওয়া যায়নি।
            </div>
        @endforelse
    </div>
    
    <div>
        {{ $exams->links() }}
    </div>
</div>