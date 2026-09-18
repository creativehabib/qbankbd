<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qerobi.Com | ডিজিটাল প্রশ্নভান্ডার ও স্মার্ট ক্যারিয়ার প্রস্তুতি</title>
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
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
                    <a href="{{ url('/') }}" class="px-4 py-2 rounded-xl {{ request()->is('/') ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600' }}">হোম</a>
                    <a href="#" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600">প্রশ্ন ব্যাংক</a>
                    <a href="{{ route('job-solutions.index') }}" class="px-4 py-2 rounded-xl {{ request()->is('job-solutions*') || request()->routeIs('job-solutions.*') || request()->routeIs('institution.show') ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600' }}">জব সল্যুশন</a>
                    <a href="#" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600">ভর্তি ও পরীক্ষা</a>
                    <a href="#" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600">পিডিএফ বইি</a>
                </nav>
            </div>

            <!-- Right Action Bar -->
            <div class="flex items-center gap-2 sm:gap-3">

                <!-- Search Button -->
                <button type="button" class="hidden md:flex items-center gap-3 px-3 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-slate-500 dark:text-slate-400 cursor-pointer" onclick="window.dispatchEvent(new CustomEvent('open-search'))">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span class="text-sm font-medium">খুঁজুন...</span>
                    <kbd x-data="{ isMac: /Mac|iPhone|iPod|iPad/i.test(navigator.platform) }" class="hidden sm:inline-flex items-center gap-1 px-1.5 py-0.5 text-[10px] font-mono font-bold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded text-slate-500 dark:text-slate-400 shadow-sm"><span x-text="isMac ? '⌘' : 'Ctrl'">Ctrl</span><span>K</span></kbd>
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
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

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
            localStorage.setItem('flux.appearance', 'light');
            localStorage.setItem('color-theme', 'light');
            document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
            document.getElementById('theme-toggle-light-icon').classList.add('hidden');
        } else {
            htmlClasses.add('dark');
            localStorage.setItem('flux.appearance', 'dark');
            localStorage.setItem('color-theme', 'dark');
            document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
            document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
        }
    });

    // Initialize Theme icon state
    window.addEventListener('DOMContentLoaded', () => {
        if(document.documentElement.classList.contains('dark')) {
            document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
            document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
        } else {
            document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
            document.getElementById('theme-toggle-light-icon').classList.add('hidden');
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
    @stack('scripts')
</body>
</html>
