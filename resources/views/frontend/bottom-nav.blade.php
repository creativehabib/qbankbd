<!-- MOBILE APP-LIKE BOTTOM NAVIGATION BAR -->
<!-- ============================================== -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 dark:bg-[#0B1120]/95 backdrop-blur-lg border-t border-slate-200 dark:border-slate-800 pb-safe">
    <div class="flex items-center justify-between px-4 py-2.5 max-w-md mx-auto">

        <!-- Home -->
        <a href="/" class="flex flex-col items-center gap-1 w-14 text-emerald-600 dark:text-emerald-400">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-[10px] font-bold">হোম</span>
        </a>

        <!-- Solutions -->
        <a href="/job-solutions" class="flex flex-col items-center gap-1 w-14 text-slate-500 dark:text-slate-400 hover:text-emerald-600 transition-colors">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            <span class="text-[10px] font-semibold">সল্যুশন</span>
        </a>

        <!-- Search -->
        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-search'));" class="flex flex-col items-center gap-1 w-14 text-slate-500 dark:text-slate-400 hover:text-emerald-600 transition-colors">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <span class="text-[10px] font-semibold">সার্চ</span>
        </button>

        <!-- Tools (Replaced PDF) -->
        <a href="/tools" class="relative flex flex-col items-center gap-1 w-14 text-slate-500 dark:text-slate-400 hover:text-emerald-600 transition-colors">
            <div class="relative">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                <!-- Animated New Badge Dot -->
                <span class="absolute -top-0.5 -right-0.5 flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500 border border-white dark:border-slate-900"></span>
                </span>
            </div>
            <span class="text-[10px] font-semibold text-rose-600 dark:text-rose-400">টুলস</span>
        </a>

        <!-- Menu -->
        <button onclick="toggleMobileMenu()" class="flex flex-col items-center gap-1 w-14 text-slate-500 dark:text-slate-400 hover:text-emerald-600 transition-colors outline-none">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            <span class="text-[10px] font-semibold">মেনু</span>
        </button>
    </div>
</nav>
