<!-- ============================================== -->
<!-- MOBILE APP DRAWER MENU (Side Menu) -->
<!-- ============================================== -->
<div id="mobile-drawer-overlay" class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 md:hidden" onclick="toggleMobileMenu()"></div>

<div id="mobile-drawer" class="fixed top-0 bottom-0 right-0 z-[70] w-[85%] max-w-sm bg-slate-50 dark:bg-[#121B2B] shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out md:hidden flex flex-col">

    <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-slate-800">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo_dark.png') }}" alt="Logo" class="h-8 w-auto block dark:hidden">
            <img src="{{ asset('images/logo_light.png') }}" alt="Logo" class="h-8 w-auto hidden dark:block">
        </div>
        <button aria-label="Open mobile" onclick="toggleMobileMenu()" class="p-2 text-slate-500 hover:text-slate-800 dark:hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto p-4 space-y-5 no-scrollbar">

        <div class="bg-gradient-to-r from-emerald-900/40 to-teal-900/40 border border-emerald-500/20 p-3.5 rounded-xl flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="p-1.5 bg-emerald-500/20 rounded-lg text-emerald-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                <div>
                    <h4 class="text-xs font-bold text-white">কেরোবি.কম অ্যাপ <span class="bg-emerald-500 text-white text-[8px] px-1 rounded">PWA</span></h4>
                    <p class="text-[10px] text-slate-400">১ ক্লিকে ফোনে অ্যাপ হিসেবে...</p>
                </div>
            </div>
            <button class="bg-emerald-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> ইন্সটল
            </button>
        </div>

        <div class="bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 p-4 rounded-xl">
            <h4 class="text-xs font-bold text-slate-900 dark:text-white mb-1 flex items-center gap-1.5">🎯 স্মার্ট প্রস্তুতি ও মূল্যায়ন</h4>
            <p class="text-[10px] text-slate-500 dark:text-slate-400 mb-3">প্রশ্ন তৈরি, পরীক্ষা নেওয়া ও অগ্রগতি ট্র্যাক রাখতে সাইন ইন করুন。</p>
            <button class="w-full bg-slate-900 dark:bg-[#1A233A] border dark:border-slate-700 text-white text-xs font-bold py-2.5 rounded-lg flex items-center justify-center gap-2">
                <span class="text-blue-400">G</span> গুগল দিয়ে প্রবেশ করুন
            </button>
        </div>

        <div>
            <h4 class="text-[11px] font-semibold text-slate-500 mb-2 px-1">মূল পোর্টালসমূহ</h4>
            <div class="grid grid-cols-2 gap-2">
                <a href="#" class="flex items-center gap-2 p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-600 dark:text-emerald-400 text-xs font-bold">🏠 হোম</a>
                <a href="{{ route('job-solutions.index') }}" class="flex items-center gap-2 p-3 bg-slate-100 dark:bg-slate-800/80 rounded-xl text-slate-700 dark:text-slate-300 text-xs font-bold">💼 জব সল্যুশন</a>
                <a href="#" class="flex items-center gap-2 p-3 bg-slate-100 dark:bg-slate-800/80 rounded-xl text-slate-700 dark:text-slate-300 text-xs font-bold">🎓 ভর্তি ও এসএসসি</a>
                <a href="#" class="flex items-center gap-2 p-3 bg-slate-100 dark:bg-slate-800/80 rounded-xl text-slate-700 dark:text-slate-300 text-xs font-bold">📚 পিডিএফ বই</a>
                <a href="#" class="col-span-2 flex items-center gap-2 p-3 bg-slate-100 dark:bg-slate-800/80 rounded-xl text-slate-700 dark:text-slate-300 text-xs font-bold">🛠️ প্রশ্ন তৈরি ও টুলস</a>
            </div>
        </div>

        <div>
            <h4 class="text-[11px] font-semibold text-slate-500 mb-2 px-1">সাইটের তথ্য ও সহায়িকা</h4>
            <div class="grid grid-cols-2 gap-2">
                <a href="#" class="flex justify-between items-center p-2.5 bg-slate-100 dark:bg-slate-800/50 rounded-lg text-slate-600 dark:text-slate-400 text-[11px]">আমাদের সম্পর্কে <span class="text-slate-500">&rsaquo;</span></a>
                <a href="#" class="flex justify-between items-center p-2.5 bg-slate-100 dark:bg-slate-800/50 rounded-lg text-slate-600 dark:text-slate-400 text-[11px]">ব্যবহারের শর্তাবলী <span class="text-slate-500">&rsaquo;</span></a>
                <a href="#" class="flex justify-between items-center p-2.5 bg-slate-100 dark:bg-slate-800/50 rounded-lg text-slate-600 dark:text-slate-400 text-[11px]">গোপনীয়তা নীতি <span class="text-slate-500">&rsaquo;</span></a>
                <a href="#" class="flex justify-between items-center p-2.5 bg-slate-100 dark:bg-slate-800/50 rounded-lg text-slate-600 dark:text-slate-400 text-[11px]">যোগাযোগ <span class="text-slate-500">&rsaquo;</span></a>
            </div>
        </div>

    </div>
</div>
