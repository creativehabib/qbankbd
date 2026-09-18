<div x-data="{ 
        open: false,
        query: '',
        results: [],
        loading: false,
        timer: null,
        fetchResults() {
            if (this.query.length < 2) {
                this.results = [];
                this.loading = false;
                return;
            }
            this.loading = true;
            fetch('/search/live?q=' + encodeURIComponent(this.query))
                .then(response => response.json())
                .then(data => {
                    this.results = data.results;
                    this.loading = false;
                })
                .catch(() => {
                    this.loading = false;
                });
        }
     }" 
     x-init="
        $watch('query', value => {
            clearTimeout(timer);
            timer = setTimeout(() => fetchResults(), 300);
        });
        $watch('open', value => {
            if(value && query.length > 1 && results.length === 0) fetchResults();
        });
     "
     @keydown.window.ctrl.k.prevent="open = true" 
     @keydown.window.meta.k.prevent="open = true" 
     @open-search.window="open = true">
    
    <!-- Search Modal -->
    <div x-show="open" 
         class="fixed inset-0 z-[100] flex items-start justify-center pt-20 px-4 sm:px-6"
         style="display: none;">
        
        <!-- Backdrop -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             @click="open = false" 
             class="fixed inset-0 bg-slate-900/40 dark:bg-[#0B1120]/80 backdrop-blur-sm transition-opacity"></div>

        <!-- Modal Content -->
        <div x-show="open" 
             @keydown.escape.window="open = false"
             x-transition:enter="ease-out duration-300 transform" 
             x-transition:enter-start="opacity-0 -translate-y-4 scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
             x-transition:leave="ease-in duration-200 transform" 
             x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
             x-transition:leave-end="opacity-0 -translate-y-4 scale-95" 
             class="relative w-full max-w-2xl bg-white dark:bg-zinc-900 rounded-xl shadow-2xl overflow-hidden ring-1 ring-slate-200 dark:ring-zinc-800 flex flex-col max-h-[85vh]">
            
            <form action="{{ route('search') }}" method="GET" class="shrink-0">
                <div class="relative flex items-center p-4 border-b border-slate-100 dark:border-zinc-800">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input name="q" 
                           x-model="query"
                           x-ref="searchInput"
                           x-effect="if (open) $nextTick(() => $refs.searchInput.focus())"
                           type="text" 
                           autocomplete="off"
                           class="w-full bg-transparent border-0 focus:ring-0 focus:border-0 focus:outline-none outline-none shadow-none text-slate-800 dark:text-zinc-100 placeholder-slate-400 text-sm pl-4" style="box-shadow: none;" 
                           placeholder="প্রশ্ন, পরীক্ষা, প্রতিষ্ঠান বা বই অনুসন্ধান করুন...">
                    
                    <div x-show="loading" class="absolute right-16" style="display: none;">
                        <svg class="animate-spin h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>

                    <button type="button" @click="open = false" class="text-[10px] font-bold text-slate-400 hover:text-slate-600 bg-slate-100 dark:bg-zinc-800 dark:hover:text-zinc-300 px-2 py-1 rounded">ESC</button>
                </div>
            </form>

            <div class="overflow-y-auto">
                <template x-if="query.length > 1">
                    <div>
                        <template x-if="results.length > 0">
                            <div class="p-4">
                                <h3 class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 mb-3 px-2">প্রশ্নসমূহ</h3>
                                <div class="space-y-1">
                                    <template x-for="question in results" :key="question.slug">
                                        <a :href="'/question/' + question.slug" class="flex items-start gap-3 p-2.5 rounded-lg hover:bg-slate-50 dark:hover:bg-zinc-800/50 transition-colors group">
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 shrink-0 mt-0.5">প্রশ্ন</span>
                                            <div class="text-sm text-slate-700 dark:text-zinc-300 font-medium group-hover:text-emerald-600 dark:group-hover:text-emerald-400 line-clamp-1" x-html="question.title"></div>
                                        </a>
                                    </template>
                                </div>
                                
                                <div class="mt-6 mb-2 text-center">
                                    <a :href="'/search?q=' + encodeURIComponent(query)" class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 flex items-center justify-center gap-1 mx-auto">
                                        সকল রেজাল্ট দেখতে ক্লিক করুন <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        </template>
                        
                        <template x-if="results.length === 0 && !loading">
                            <div class="p-12 text-center">
                                <p class="text-sm text-slate-500 dark:text-zinc-400">কোনো রেজাল্ট পাওয়া যায়নি।</p>
                            </div>
                        </template>
                    </div>
                </template>
                
                <template x-if="query.length <= 1">
                    <div class="p-12 text-center">
                        <p class="text-sm text-slate-500 dark:text-zinc-400">যেকোনো কীওয়ার্ড টাইপ করুন (যেমন: বাংলাদেশ, বিসিএস, ঢাকা বিশ্ববিদ্যালয়, কম্পিউটার...)</p>
                    </div>
                </template>
            </div>
            
            <div class="bg-slate-50 dark:bg-zinc-800/50 p-3 shrink-0 flex justify-between items-center text-[10px] text-slate-500 border-t border-slate-100 dark:border-zinc-800 mt-auto">
                <span>সার্চ করে এন্টার চাপলে পূর্ণাঙ্গ রেজাল্ট পেইজে যাবে</span>
                <span class="text-emerald-500 font-medium tracking-wider">Qerobi.Com</span>
            </div>
        </div>
    </div>
</div>
