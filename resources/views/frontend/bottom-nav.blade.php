<!-- MOBILE APP-LIKE BOTTOM NAVIGATION BAR -->
<!-- ============================================== -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 dark:bg-[#0B1120]/95 backdrop-blur-lg border-t border-slate-200 dark:border-slate-800 pb-safe">
    <div class="flex items-center justify-between px-4 py-2.5 max-w-md mx-auto">

        <a href="/" class="flex flex-col items-center gap-1 w-14 text-emerald-600 dark:text-emerald-400">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-[10px] font-bold">হোম</span>
        </a>

        <a href="/job-solutions" class="flex flex-col items-center gap-1 w-14 text-slate-500 dark:text-slate-400 hover:text-emerald-600 transition-colors">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            <span class="text-[10px] font-semibold">সল্যুশন</span>
        </a>

        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-search'));" class="flex flex-col items-center gap-1 w-14 text-slate-500 dark:text-slate-400 hover:text-emerald-600 transition-colors">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <span class="text-[10px] font-semibold">সার্চ</span>
        </button>

        <a href="#" class="flex flex-col items-center gap-1 w-14 text-slate-500 dark:text-slate-400 hover:text-emerald-600 transition-colors">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477-4.5 1.253"></path></svg>
            <span class="text-[10px] font-semibold">পিডিএফ</span>
        </a>

        <button onclick="toggleMobileMenu()" class="flex flex-col items-center gap-1 w-14 text-slate-500 dark:text-slate-400 hover:text-emerald-600 transition-colors outline-none">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            <span class="text-[10px] font-semibold">মেনু</span>
        </button>
    </div>
</nav>