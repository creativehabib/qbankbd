<x-layouts.frontend title="অনুসন্ধান ফলাফল" description="প্রশ্ন ব্যাংক এ প্রশ্ন অনুসন্ধান করুন।">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <h1 class="text-xl font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                অনুসন্ধান ফলাফল
            </h1>
            
            <form action="{{ route('search') }}" method="GET" class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" class="flex-grow px-4 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-slate-800 dark:text-white" placeholder="প্রশ্ন, পরীক্ষা, প্রতিষ্ঠান বা বই অনুসন্ধান করুন...">
                <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-colors">খুঁজুন</button>
            </form>
        </div>

        @if(!empty($query))
            @if($results && $results->count() > 0)
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">"{{ $query }}" এর জন্য {{ $results->total() }} টি ফলাফল পাওয়া গেছে।</p>
                    
                    <div class="space-y-4">
                        @foreach($results as $question)
                            <a href="{{ route('question.show', $question->slug) }}" class="block p-4 bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-700/50 rounded-xl hover:border-emerald-500/50 dark:hover:border-emerald-500/50 transition-colors group">
                                <div class="flex items-start gap-3">
                                    <span class="px-2 py-1 rounded bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-bold shrink-0 mt-0.5">প্রশ্ন</span>
                                    <h3 class="text-slate-800 dark:text-slate-200 font-medium group-hover:text-emerald-600 dark:group-hover:text-emerald-400 line-clamp-2">
                                        {!! strip_tags(preg_replace('/<a\b[^>]*>(.*?)<\/a>/i', '<span>$1</span>', $question->title)) !!}
                                    </h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $results->appends(['q' => $query])->links() }}
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-12 text-center">
                    <svg class="w-16 h-16 text-slate-300 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">কোনো ফলাফল পাওয়া যায়নি</h3>
                    <p class="text-slate-500 dark:text-slate-400">"{{ $query }}" এর জন্য কোনো প্রশ্ন পাওয়া যায়নি। অন্য কোনো শব্দ দিয়ে চেষ্টা করুন।</p>
                </div>
            @endif
        @endif
    </div>
</x-layouts.frontend>
