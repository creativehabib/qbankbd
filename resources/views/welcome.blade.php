<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qerobi.Com | ডিজিটাল প্রশ্নভান্ডার ও স্মার্ট ক্যারিয়ার প্রস্তুতি</title>

    <!-- Primary Font: Noto Sans Bengali -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Noto Sans Bengali"', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body, html {
            -webkit-user-select: none;
            user-select: none;
        }
        /* Hide scrollbar for clean app-like drawer */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @livewireStyles
</head>
<body class="bg-slate-50 dark:bg-[#0B1120] text-slate-800 dark:text-slate-200 font-sans antialiased min-h-screen flex flex-col pb-20 lg:pb-0 transition-colors duration-300">

<!-- Top Navigation Header -->
<header class="sticky top-0 z-40 bg-white/80 dark:bg-[#0B1120]/80 backdrop-blur-xl border-b border-slate-200/80 dark:border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-4">

            <!-- Logo & Brand -->
            <div class="flex items-center gap-6">
                <a href="#" class="group inline-flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 via-teal-500 to-emerald-400 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8.5 7V5.2A2.2 2.2 0 0 1 10.7 3h2.6a2.2 2.2 0 0 1 2.2 2.2V7" stroke-width="1.8"/>
                            <rect x="2.5" y="7" width="19" height="13.5" rx="3" stroke-width="1.8"/>
                            <path d="M2.5 12h19" stroke-width="1.3" stroke-dasharray="2 2" opacity="0.7"/>
                        </svg>
                    </div>
                    <div class="flex flex-col leading-none">
                        <div class="flex items-center gap-1.5">
                            <span class="text-xl font-extrabold tracking-tight text-slate-900 dark:text-white">কেরোবি.কম</span>
                        </div>
                        <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400 mt-1">ডিজিটাল প্রশ্নভান্ডার</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center gap-2 text-sm font-semibold">
                    <a href="#" class="px-4 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400">হোম</a>
                    <a href="#" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600">প্রশ্ন ব্যাংক</a>
                    <a href="{{ route('job-solutions.index') }}" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600">জব সল্যুশন</a>
                    <a href="#" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600">ভর্তি ও পরীক্ষা</a>
                    <a href="#" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600">পিডিএফ বই</a>
                </nav>
            </div>

            <!-- Right Action Bar -->
            <div class="flex items-center gap-2 sm:gap-3">

                <!-- Search Button -->
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-search'))" class="hidden md:flex items-center gap-3 px-3 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-slate-500 dark:text-slate-400 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span class="text-sm font-medium">খুঁজুন...</span>
                    <kbd class="hidden sm:inline-block px-1.5 py-0.5 text-[10px] font-mono font-bold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded text-slate-500 dark:text-slate-400 shadow-sm">Ctrl K</kbd>
                </button>

                <!-- Download App Button -->
                <button type="button" title="ডাউনলোড অ্যাপ" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 rounded-full transition-colors cursor-pointer max-md:hidden">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </button>

                <!-- Theme Toggle -->
                <button type="button" id="theme-toggle" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 rounded-full transition-colors cursor-pointer">
                    <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                </button>

                <!-- Login Button -->
                <button class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors shadow-sm cursor-pointer">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">লগইন</span>
                </button>

                <!-- Mobile Login Icon -->
                <button class="sm:hidden p-2 rounded-xl bg-emerald-50 dark:bg-slate-800 text-emerald-600 dark:text-emerald-400 border border-slate-200 dark:border-slate-700 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Main Content Area -->
<main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-12">

    <!-- ============================================== -->
    <!-- CENTERED HERO SECTION (Gradient, No Border) -->
    <!-- ============================================== -->
    <section>
        <!-- Hero Wrapper (Border removed, Gradient added) -->
        <div class="relative rounded-[2rem] bg-gradient-to-br from-emerald-50 via-white to-teal-50 dark:from-[#121b2a] dark:via-[#0B1120] dark:to-[#0a1922] px-6 py-12 sm:px-10 sm:py-16 overflow-hidden flex flex-col items-center justify-center text-center shadow-sm">

            <!-- Background decorative elements -->
            <div class="absolute -right-20 -top-20 w-96 h-96 bg-emerald-400/10 dark:bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-20 -bottom-20 w-72 h-72 bg-teal-400/10 dark:bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="space-y-6 max-w-3xl mx-auto relative z-10 flex flex-col items-center">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 dark:bg-[#121B2B]/60 backdrop-blur-md border border-emerald-200/50 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-xs sm:text-sm font-bold shadow-sm">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                    ✨ স্মার্ট ডিজিটাল প্রশ্নব্যাংক
                </div>

                <!-- Headline -->
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white leading-[1.35] tracking-tight">
                    স্মার্ট শিক্ষার জন্য <br class="hidden sm:block"/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 via-teal-500 to-emerald-400 dark:from-emerald-400 dark:via-teal-300 dark:to-emerald-300">
                            ডিজিটাল প্রশ্নভান্ডার
                        </span>
                </h1>

                <!-- Sub-headline -->
                <p class="text-sm sm:text-base lg:text-lg text-slate-600 dark:text-slate-400 font-medium leading-relaxed max-w-2xl mx-auto">
                    নির্ভুল প্রশ্ন সমাধান ও মডেল টেস্টের পাশাপাশি, <span class="text-emerald-600 dark:text-emerald-400 font-bold">আপনার সার্বক্ষণিক সহযোগী টিউটর হিসেবে থাকছে AI</span>। আপনার স্মার্ট প্রস্তুতির বিশ্বস্ত ঠিকানা।
                </p>

                <!-- Search Box -->
                <div class="pt-6 w-full max-w-2xl">
                    <div class="flex items-center bg-white dark:bg-[#0B1120] border-2 border-slate-200 dark:border-slate-700/80 rounded-2xl p-1.5 focus-within:border-emerald-500 transition-colors shadow-sm">
                        <div class="pl-4 pr-3 text-slate-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div>
                        <input type="text" onclick="window.dispatchEvent(new CustomEvent('open-search'))" readonly placeholder="প্রশ্ন, পরীক্ষা বা বিষয় খুঁজুন (যেমন: সমাস, ৫০তম বিসিএস)..." class="w-full bg-transparent text-slate-800 dark:text-white text-sm font-medium focus:outline-none placeholder-slate-400 cursor-pointer">
                        <button onclick="window.dispatchEvent(new CustomEvent('open-search'))" type="button" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 sm:px-8 py-3.5 rounded-xl text-sm font-bold shadow-md whitespace-nowrap transition-all hover:scale-105 cursor-pointer">অনুসন্ধান</button>
                    </div>

                    <!-- Popular Search Tags -->
                    <div class="flex flex-wrap justify-center items-center gap-2 sm:gap-3 mt-5 text-xs">
                        <span class="text-slate-500 font-medium">জনপ্রিয়:</span>
                        <a href="#" class="px-3 py-1.5 rounded-lg bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border border-slate-200/50 dark:border-slate-700/50 text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:border-emerald-300 dark:hover:border-emerald-500/50 font-medium transition">AI সল্যুশন</a>
                        <a href="#" class="px-3 py-1.5 rounded-lg bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border border-slate-200/50 dark:border-slate-700/50 text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:border-emerald-300 dark:hover:border-emerald-500/50 font-medium transition">বিসিএস প্রশ্ন</a>
                        <a href="#" class="px-3 py-1.5 rounded-lg bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border border-slate-200/50 dark:border-slate-700/50 text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:border-emerald-300 dark:hover:border-emerald-500/50 font-medium transition">মডেল টেস্ট</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- CORE CATEGORIES -->
    <!-- ============================================== -->
    <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="#" class="p-4 rounded-2xl bg-white dark:bg-[#121B2B] border border-slate-200 dark:border-slate-800 hover:border-emerald-500 hover:-translate-y-1 transition-all group flex flex-col items-center text-center sm:flex-row sm:text-left gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div><h3 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-emerald-500">জব সল্যুশন</h3><p class="text-[11px] text-slate-500 mt-0.5">বিগত প্রশ্ন সমাধান</p></div>
        </a>
        <a href="#" class="p-4 rounded-2xl bg-white dark:bg-[#121B2B] border border-slate-200 dark:border-slate-800 hover:border-blue-500 hover:-translate-y-1 transition-all group flex flex-col items-center text-center sm:flex-row sm:text-left gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-500 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div><h3 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-500">প্রশ্ন আর্কাইভ</h3><p class="text-[11px] text-slate-500 mt-0.5">মন্ত্রণালয় ও ব্যাংক</p></div>
        </a>
        <a href="#" class="p-4 rounded-2xl bg-white dark:bg-[#121B2B] border border-slate-200 dark:border-slate-800 hover:border-rose-500 hover:-translate-y-1 transition-all group flex flex-col items-center text-center sm:flex-row sm:text-left gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-500 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
            <div><h3 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-rose-500">ক্যারিয়ার ব্লগ</h3><p class="text-[11px] text-slate-500 mt-0.5">প্রস্তুতি ও গাইডলাইন</p></div>
        </a>
        <a href="#" class="p-4 rounded-2xl bg-white dark:bg-[#121B2B] border border-slate-200 dark:border-slate-800 hover:border-amber-500 hover:-translate-y-1 transition-all group flex flex-col items-center text-center sm:flex-row sm:text-left gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>
            </div>
            <div><h3 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-amber-500">প্রস্তুতি টুলস</h3><p class="text-[11px] text-slate-500 mt-0.5">টাইপিং ও অন্যান্য</p></div>
        </a>
    </section>

    <!-- ============================================== -->
    <!-- ACADEMIC & ADMISSION ARCHIVE -->
    <!-- ============================================== -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 flex items-center justify-center">🎓</div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">একাডেমিক ও ভর্তি প্রস্তুতি</h2>
            </div>
            <a href="#" class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">সব দেখুন &rarr;</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="#" class="bg-white dark:bg-[#121B2B] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-emerald-400 hover:shadow-md transition-all text-center group">
                <div class="w-14 h-14 mx-auto rounded-full bg-emerald-50 dark:bg-slate-800 border-2 border-emerald-100 dark:border-slate-700 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform text-2xl">🎒</div>
                <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200">এসএসসি (SSC) প্রস্তুতি</h3>
                <p class="text-[10px] text-slate-500 mt-1">বোর্ড প্রশ্ন ও অধ্যায়ভিত্তিক টেস্ট</p>
            </a>

            <a href="#" class="bg-white dark:bg-[#121B2B] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-blue-400 hover:shadow-md transition-all text-center group">
                <div class="w-14 h-14 mx-auto rounded-full bg-blue-50 dark:bg-slate-800 border-2 border-blue-100 dark:border-slate-700 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform text-2xl">🎓</div>
                <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200">এইচএসসি (HSC) প্রস্তুতি</h3>
                <p class="text-[10px] text-slate-500 mt-1">বিগত সালের বোর্ড প্রশ্ন সমাধান</p>
            </a>

            <a href="#" class="bg-white dark:bg-[#121B2B] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-purple-400 hover:shadow-md transition-all text-center group">
                <div class="w-14 h-14 mx-auto rounded-full bg-purple-50 dark:bg-slate-800 border-2 border-purple-100 dark:border-slate-700 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform text-2xl">🏛️</div>
                <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200">বিশ্ববিদ্যালয় ভর্তি</h3>
                <p class="text-[10px] text-slate-500 mt-1">ঢাবি, রাবি, চবি ও গুচ্ছ প্রশ্নব্যাংক</p>
            </a>

            <a href="#" class="bg-white dark:bg-[#121B2B] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-rose-400 hover:shadow-md transition-all text-center group">
                <div class="w-14 h-14 mx-auto rounded-full bg-rose-50 dark:bg-slate-800 border-2 border-rose-100 dark:border-slate-700 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform text-2xl">⚕️</div>
                <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200">মেডিকেল ও ইঞ্জিনিয়ারিং</h3>
                <p class="text-[10px] text-slate-500 mt-1">বিগত বছরের প্রশ্ন ও মডেল টেস্ট</p>
            </a>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- TOP ORGANIZATIONS -->
    <!-- ============================================== -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 flex items-center justify-center">🏛️</div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">শীর্ষ প্রতিষ্ঠান ও প্রশ্ন আর্কাইভ</h2>
            </div>
            <a href="#" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">সব দেখুন &rarr;</a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            <!-- Org Cards -->
            <a href="#" class="bg-white dark:bg-[#121B2B] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-indigo-400 hover:shadow-lg transition-all text-center group">
                <div class="w-14 h-14 mx-auto rounded-full bg-slate-50 dark:bg-slate-800 border-4 border-white dark:border-slate-900 shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform text-xl">🇧🇩</div>
                <h3 class="text-xs font-bold text-slate-800 dark:text-slate-200">বিসিএস</h3>
            </a>
            <a href="#" class="bg-white dark:bg-[#121B2B] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-indigo-400 hover:shadow-lg transition-all text-center group">
                <div class="w-14 h-14 mx-auto rounded-full bg-slate-50 dark:bg-slate-800 border-4 border-white dark:border-slate-900 shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform text-xl">🏛️</div>
                <h3 class="text-xs font-bold text-slate-800 dark:text-slate-200">কর্ম কমিশন</h3>
            </a>
            <a href="#" class="bg-white dark:bg-[#121B2B] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-indigo-400 hover:shadow-lg transition-all text-center group">
                <div class="w-14 h-14 mx-auto rounded-full bg-slate-50 dark:bg-slate-800 border-4 border-white dark:border-slate-900 shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform text-xl">💼</div>
                <h3 class="text-xs font-bold text-slate-800 dark:text-slate-200">মন্ত্রীপরিষদ</h3>
            </a>
            <a href="#" class="bg-white dark:bg-[#121B2B] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-indigo-400 hover:shadow-lg transition-all text-center group">
                <div class="w-14 h-14 mx-auto rounded-full bg-slate-50 dark:bg-slate-800 border-4 border-white dark:border-slate-900 shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform text-xl">🎓</div>
                <h3 class="text-xs font-bold text-slate-800 dark:text-slate-200">প্রাথমিক শিক্ষা</h3>
            </a>
            <a href="#" class="hidden md:block bg-white dark:bg-[#121B2B] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-indigo-400 hover:shadow-lg transition-all text-center group">
                <div class="w-14 h-14 mx-auto rounded-full bg-slate-50 dark:bg-slate-800 border-4 border-white dark:border-slate-900 shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform text-xl">🏦</div>
                <h3 class="text-xs font-bold text-slate-800 dark:text-slate-200">ব্যাংক জব</h3>
            </a>
            <a href="#" class="hidden md:flex flex-col items-center justify-center bg-indigo-50 dark:bg-indigo-500/10 rounded-2xl p-5 border border-dashed border-indigo-200 dark:border-indigo-500/30 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition-colors text-center group">
                <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
                <h3 class="text-xs font-bold text-indigo-700 dark:text-indigo-400">সব দেখুন</h3>
            </a>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- RECENT EXAM SOLUTIONS -->
    <!-- ============================================== -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 flex items-center justify-center">📝</div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">সাম্প্রতিক জব সল্যুশন</h2>
            </div>
            <a href="#" class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">সব দেখুন &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Solution Card 1 -->
            <a href="#" class="relative flex flex-col justify-between p-5 rounded-2xl bg-white dark:bg-[#121B2B] border border-slate-200 dark:border-slate-800 hover:shadow-lg transition-shadow overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500"></div>
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[10px] font-bold uppercase rounded-md">Ministry</span>
                        <span class="text-[11px] text-slate-400 flex items-center gap-1">28 Aug, 2026</span>
                    </div>
                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 text-[10px] font-bold rounded">MCQ</span>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4 group-hover:text-emerald-500 transition-colors">মন্ত্রীপরিষদ বিভাগ (কম্পিউটার অপারেটর) প্রশ্ন সমাধান</h3>
                <div class="flex items-center justify-between border-t border-slate-100 dark:border-slate-800 pt-3">
                    <div class="text-xs text-slate-500 font-medium">পূর্ণমান: <span class="text-slate-800 dark:text-slate-200 font-bold">69</span></div>
                    <span class="text-xs font-bold text-emerald-600 flex items-center gap-1 group-hover:translate-x-1 transition-transform">সমাধান পড়ুন &rarr;</span>
                </div>
            </a>

            <!-- Solution Card 2 -->
            <a href="#" class="relative flex flex-col justify-between p-5 rounded-2xl bg-white dark:bg-[#121B2B] border border-slate-200 dark:border-slate-800 hover:shadow-lg transition-shadow overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-indigo-500"></div>
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[10px] font-bold uppercase rounded-md">MOPA</span>
                        <span class="text-[11px] text-slate-400 flex items-center gap-1">02 Jul, 2026</span>
                    </div>
                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 text-[10px] font-bold rounded">MCQ</span>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4 group-hover:text-indigo-500 transition-colors">জনপ্রশাসন মন্ত্রণালয় (ব্যক্তিগত কর্মকর্তা) প্রশ্ন সমাধান</h3>
                <div class="flex items-center justify-between border-t border-slate-100 dark:border-slate-800 pt-3">
                    <div class="text-xs text-slate-500 font-medium">পূর্ণমান: <span class="text-slate-800 dark:text-slate-200 font-bold">100</span></div>
                    <span class="text-xs font-bold text-indigo-600 flex items-center gap-1 group-hover:translate-x-1 transition-transform">সমাধান পড়ুন &rarr;</span>
                </div>
            </a>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- RECENT JOB CIRCULARS (চাকরির বিজ্ঞপ্তি) - LAST SECTION -->
    <!-- ============================================== -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-500/20 text-red-600 flex items-center justify-center">📢</div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">সাম্প্রতিক চাকরির বিজ্ঞপ্তি</h2>
            </div>
            <a href="#" class="text-sm font-semibold text-red-600 dark:text-red-400 hover:underline">সকল বিজ্ঞপ্তি &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <!-- Circular Card 1 -->
            <div class="bg-white dark:bg-[#121B2B] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-red-400 hover:shadow-lg transition-all group flex flex-col justify-between h-full">
                <div>
                    <div class="flex justify-between items-start mb-3">
                        <span class="px-2.5 py-1 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 text-[10px] font-bold rounded-md">সরকারি চাকরি</span>
                        <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-1 bg-slate-50 dark:bg-slate-800 px-2 py-0.5 rounded">
                                ⏳ শেষ: ২২ সেপ্টে, ২০২৬
                            </span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-red-600 transition-colors mb-2">বাংলাদেশ রেলওয়ে (ওয়েম্যান)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">বাংলাদেশ রেলওয়েতে ওয়েম্যান পদে ১৩৮৫ জনের বিশাল নিয়োগ বিজ্ঞপ্তি প্রকাশ করা হয়েছে। যোগ্য প্রার্থীরা দ্রুত আবেদন করুন...</p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">পদ: ১৩৮৫ জন</span>
                    <a href="#" class="text-xs font-bold text-white bg-slate-900 dark:bg-red-600 px-3.5 py-2 rounded-lg hover:bg-red-600 transition-colors">বিস্তারিত দেখুন</a>
                </div>
            </div>

            <!-- Circular Card 2 -->
            <div class="bg-white dark:bg-[#121B2B] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-blue-400 hover:shadow-lg transition-all group flex flex-col justify-between h-full">
                <div>
                    <div class="flex justify-between items-start mb-3">
                        <span class="px-2.5 py-1 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 text-[10px] font-bold rounded-md">ব্যাংক জব</span>
                        <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-1 bg-slate-50 dark:bg-slate-800 px-2 py-0.5 rounded">
                                ⏳ শেষ: ২৮ সেপ্টে, ২০২৬
                            </span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors mb-2">বাংলাদেশ ব্যাংক (অফিসার জেনারেল)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">বাংলাদেশ ব্যাংকে 'অফিসার (জেনারেল)' পদে নিয়োগের জন্য আগ্রহী প্রার্থীদের কাছ থেকে আবেদন আহ্বান করা হয়েছে...</p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">পদ: ২৫০ জন</span>
                    <a href="#" class="text-xs font-bold text-white bg-slate-900 dark:bg-blue-600 px-3.5 py-2 rounded-lg hover:bg-blue-600 transition-colors">বিস্তারিত দেখুন</a>
                </div>
            </div>

            <!-- Circular Card 3 -->
            <div class="bg-white dark:bg-[#121B2B] rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-purple-400 hover:shadow-lg transition-all group flex flex-col justify-between h-full">
                <div>
                    <div class="flex justify-between items-start mb-3">
                        <span class="px-2.5 py-1 bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 text-[10px] font-bold rounded-md">মন্ত্রণালয়</span>
                        <span class="text-[11px] font-bold text-rose-500 bg-rose-50 dark:bg-rose-500/10 px-2 py-0.5 rounded flex items-center gap-1 animate-pulse">
                                ⏳ শেষ: আজ
                            </span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-purple-600 transition-colors mb-2">খাদ্য অধিদপ্তর (উপ-পরিদর্শক)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">খাদ্য অধিদপ্তরের অধীনে উপ-খাদ্য পরিদর্শক ও অন্যান্য পদে নতুন নিয়োগ বিজ্ঞপ্তি। দ্রুত আবেদন সম্পন্ন করুন...</p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">পদ: ৪১০ জন</span>
                    <a href="#" class="text-xs font-bold text-white bg-slate-900 dark:bg-purple-600 px-3.5 py-2 rounded-lg hover:bg-purple-600 transition-colors">বিস্তারিত দেখুন</a>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- ==================== FOOTER ==================== -->
<footer class="bg-white dark:bg-[#0B1120] border-t border-slate-200 dark:border-slate-800/80 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 lg:gap-12">
            <!-- Brand Info -->
            <div class="col-span-1 md:col-span-3 lg:col-span-2 space-y-4">
                <a href="#" class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-emerald-600 to-emerald-400 flex items-center justify-center text-white shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 7V5.2A2.2 2.2 0 0 1 10.7 3h2.6a2.2 2.2 0 0 1 2.2 2.2V7"/>
                            <rect x="2.5" y="7" width="19" height="13.5" rx="3"/>
                            <path stroke-dasharray="2 2" d="M2.5 12h19"/>
                        </svg>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900 dark:text-white">কেরোবি.কম</span>
                </a>
                <p class="text-sm text-slate-500 dark:text-slate-400 max-w-sm leading-relaxed">
                    একটি স্মার্ট ডিজিটাল প্রশ্নভান্ডার। শিক্ষক, শিক্ষার্থী ও চাকরিপ্রত্যাশী— সবার স্মার্ট প্রস্তুতি ও মূল্যায়নের বিশ্বস্ত ঠিকানা।
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-slate-900 dark:text-white font-bold mb-4">পণ্য ও সেবা</h4>
                <ul class="space-y-2 text-sm text-slate-500 dark:text-slate-400">
                    <li><a href="#" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">ফিচারসমূহ</a></li>
                    <li><a href="#" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">AI জেনারেটর</a></li>
                    <li><a href="#" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">মক টেস্ট</a></li>
                </ul>
            </div>

            <!-- Social Links -->
            <div>
                <h4 class="text-slate-900 dark:text-white font-bold mb-4">যুক্ত থাকুন</h4>
                <div class="flex items-center gap-3">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-[#121B2B] flex items-center justify-center text-slate-500 hover:bg-emerald-100 hover:text-emerald-600 dark:hover:bg-emerald-500/20 dark:hover:text-emerald-400 transition-colors border border-transparent dark:border-slate-800">
                        <span class="font-bold">f</span>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-[#121B2B] flex items-center justify-center text-slate-500 hover:bg-emerald-100 hover:text-emerald-600 dark:hover:bg-emerald-500/20 dark:hover:text-emerald-400 transition-colors border border-transparent dark:border-slate-800">
                        <span class="font-bold">in</span>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-[#121B2B] flex items-center justify-center text-slate-500 hover:bg-red-100 hover:text-red-600 dark:hover:bg-red-500/20 dark:hover:text-red-400 transition-colors border border-transparent dark:border-slate-800">
                        <span class="font-bold">yt</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright -->
        <div class="border-t border-slate-200 dark:border-slate-800 mt-10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs text-slate-500 dark:text-slate-400">&copy; ২০২৬ Qerobi.Com. সর্বস্বত্ব সংরক্ষিত।</p>
            <p class="text-xs text-slate-400 dark:text-slate-500">ডিজিটাল প্রশ্নভান্ডার ও লার্নিং প্ল্যাটফর্ম</p>
        </div>
    </div>
</footer>

<!-- ============================================== -->
<!-- MOBILE APP-LIKE BOTTOM NAVIGATION BAR -->
<!-- ============================================== -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 dark:bg-[#0B1120]/95 backdrop-blur-lg border-t border-slate-200 dark:border-slate-800 pb-safe">
    <div class="flex items-center justify-between px-4 py-2.5 max-w-md mx-auto">

        <a href="#" class="flex flex-col items-center gap-1 w-14 text-emerald-600 dark:text-emerald-400">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-[10px] font-bold">হোম</span>
        </a>

        <a href="#" class="flex flex-col items-center gap-1 w-14 text-slate-500 dark:text-slate-400 hover:text-emerald-600 transition-colors">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            <span class="text-[10px] font-semibold">সল্যুশন</span>
        </a>

        <a href="#" class="flex flex-col items-center gap-1 w-14 text-slate-500 dark:text-slate-400 hover:text-emerald-600 transition-colors">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <span class="text-[10px] font-semibold">সার্চ</span>
        </a>

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

<!-- ============================================== -->
<!-- MOBILE APP DRAWER MENU (Side Menu) -->
<!-- ============================================== -->
<div id="mobile-drawer-overlay" class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 md:hidden" onclick="toggleMobileMenu()"></div>

<div id="mobile-drawer" class="fixed top-0 bottom-0 right-0 z-[70] w-[85%] max-w-sm bg-slate-50 dark:bg-[#121B2B] shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out md:hidden flex flex-col">

    <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-slate-800">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 7V5.2A2.2 2.2 0 0 1 10.7 3h2.6a2.2 2.2 0 0 1 2.2 2.2V7"></path><rect x="2.5" y="7" width="19" height="13.5" rx="3"></rect></svg>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-extrabold text-slate-900 dark:text-white">কেরোবি.কম <span class="text-[9px] bg-emerald-500/20 text-emerald-400 px-1 py-0.5 rounded">AI</span></span>
                <span class="text-[10px] text-slate-400">ডিজিটাল প্রশ্নভান্ডার</span>
            </div>
        </div>
        <button onclick="toggleMobileMenu()" class="p-2 text-slate-500 hover:text-slate-800 dark:hover:text-white">
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

<script>
    // Theme toggle logic
    document.getElementById('theme-toggle').addEventListener('click', function() {
        var htmlClasses = document.documentElement.classList;
        if(htmlClasses.contains('dark')) {
            htmlClasses.remove('dark');
            document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
            document.getElementById('theme-toggle-light-icon').classList.add('hidden');
        } else {
            htmlClasses.add('dark');
            document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
            document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
        }
    });

    // Mobile Menu Drawer Logic
    function toggleMobileMenu() {
        const drawer = document.getElementById('mobile-drawer');
        const overlay = document.getElementById('mobile-drawer-overlay');

        if (drawer.classList.contains('translate-x-full')) {
            // Open Drawer
            drawer.classList.remove('translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100', 'pointer-events-auto');
            document.body.classList.add('overflow-hidden');
        } else {
            // Close Drawer
            drawer.classList.add('translate-x-full');
            overlay.classList.remove('opacity-100', 'pointer-events-auto');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden');
        }
    }
</script>
    @livewire('frontend.global-search')
    @livewireScripts
</body>
</html>
