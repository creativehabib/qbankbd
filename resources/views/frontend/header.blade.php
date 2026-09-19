<header class="sticky top-0 z-40 bg-white/80 header-dynamic-bg backdrop-blur-xl border-b border-slate-200/80 dark:border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-4">

            <!-- Logo & Brand -->
            <div class="flex items-center gap-6">
                <a href="/" class="group inline-flex items-center">
                    @php
                        $branding = \App\Support\SettingsStore::group('branding');
                        $appName = $branding['app_name'] ?? config('app.name', 'Question Bank');
                        $logoLight = !empty($branding['logo_light']) ? (\Illuminate\Support\Str::startsWith($branding['logo_light'], ['http://', 'https://']) ? $branding['logo_light'] : asset('storage/'.$branding['logo_light'])) : asset('images/logo_dark.png');
                        $logoDark = !empty($branding['logo_dark']) ? (\Illuminate\Support\Str::startsWith($branding['logo_dark'], ['http://', 'https://']) ? $branding['logo_dark'] : asset('storage/'.$branding['logo_dark'])) : asset('images/logo_light.png');
                    @endphp
                    <img src="{{ $logoLight }}" alt="{{ $appName }}" class="h-7 md:h-8 w-auto block dark:hidden">
                    <img src="{{ $logoDark }}" alt="{{ $appName }}" class="h-7 md:h-8 w-auto hidden dark:block">
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center gap-2 text-sm font-semibold">
                    <a href="{{ url('/') }}" class="px-4 py-2 rounded-xl {{ request()->is('/') ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600' }}">হোম</a>
                    <a href="#" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600">প্রশ্ন ব্যাংক</a>
                    <a href="{{ route('job-solutions.index') }}" class="px-4 py-2 rounded-xl {{ request()->is('job-solutions*') || request()->routeIs('job-solutions.*') || request()->routeIs('institution.show') ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600' }}">জব সল্যুশন</a>
                    <a href="#" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600">ভর্তি ও পরীক্ষা</a>
                    <a href="#" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600">পিডিএফ বই</a>
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
                <button type="button" id="theme-toggle" aria-label="Toggle dark mode" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 rounded-full transition-colors cursor-pointer">
                    <svg class="w-5 h-5 block dark:hidden pointer-events-none" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg class="w-5 h-5 hidden dark:block pointer-events-none" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                </button>

                <!-- Login Button -->
                <button aria-label="User profile" class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors shadow-sm cursor-pointer">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">লগইন</span>
                </button>

                <!-- Mobile Login Icon -->
                <button aria-label="User profile" class="sm:hidden p-2 rounded-xl bg-emerald-50 dark:bg-slate-800 text-emerald-600 dark:text-emerald-400 border border-slate-200 dark:border-slate-700 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </button>
            </div>
        </div>
    </div>
</header>
