<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-2 lg:p-6">
        <div class="bg-gradient-to-r from-indigo-600 to-violet-600 rounded-3xl p-8 lg:p-10 text-white shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl lg:text-4xl font-extrabold mb-3 tracking-tight">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-indigo-100 text-lg mb-8 max-w-2xl font-medium">We're glad to see you again. Check out your latest statistics, recent activities, and more below.</p>
                <div class="flex gap-4">
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center bg-white text-indigo-600 px-6 py-2.5 rounded-xl font-bold hover:bg-indigo-50 hover:scale-105 transition-all shadow-md focus:outline-none focus:ring-4 focus:ring-indigo-300">
                        View Profile
                    </a>
                </div>
            </div>
            <!-- Decorative Background Elements -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-white opacity-10 blur-3xl"></div>
            <div class="absolute bottom-0 right-40 w-56 h-56 rounded-full bg-indigo-300 opacity-20 blur-2xl"></div>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-shadow flex items-center gap-5">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400 rounded-2xl flex items-center justify-center text-2xl font-bold shadow-inner">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1.2em" width="1.2em" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zM144 272c-17.673 0-32-14.327-32-32s14.327-32 32-32 32 14.327 32 32-14.327 32-32 32zm112 0c-17.673 0-32-14.327-32-32s14.327-32 32-32 32 14.327 32 32-14.327 32-32 32zm112 0c-17.673 0-32-14.327-32-32s14.327-32 32-32 32 14.327 32 32-14.327 32-32 32z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 font-semibold tracking-wide uppercase">Role</p>
                    <p class="text-xl font-bold text-zinc-800 dark:text-zinc-100 uppercase mt-0.5">{{ auth()->user()->roles->pluck('name')->implode(', ') ?: 'User' }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-shadow flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 rounded-2xl flex items-center justify-center text-xl font-bold shadow-inner">
                    <svg stroke="currentColor" fill="none" stroke-width="2.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1.2em" width="1.2em" xmlns="http://www.w3.org/2000/svg"><path d="M22 11.08V12a10.002 10.002 0 0 1-5.938 9.162M22 4L12 14.01l-3-3"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 font-semibold tracking-wide uppercase">Status</p>
                    <p class="text-xl font-bold text-zinc-800 dark:text-zinc-100 mt-0.5">Active</p>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition-shadow flex items-center gap-5">
                <div class="w-14 h-14 bg-purple-50 text-purple-600 dark:bg-purple-900/20 dark:text-purple-400 rounded-2xl flex items-center justify-center text-xl font-bold shadow-inner">
                    <svg stroke="currentColor" fill="none" stroke-width="2.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1.2em" width="1.2em" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 font-semibold tracking-wide uppercase">Joined Date</p>
                    <p class="text-xl font-bold text-zinc-800 dark:text-zinc-100 mt-0.5">{{ auth()->user()->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
        
        <div class="flex-1 rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-8 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-extrabold text-zinc-800 dark:text-zinc-100">Recent Updates</h3>
                <button class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">View All</button>
            </div>
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="bg-zinc-50 dark:bg-zinc-800/50 p-6 rounded-full mb-4">
                    <svg class="w-10 h-10 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-lg font-bold text-zinc-800 dark:text-zinc-100 mb-1">No recent activity</h4>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm max-w-sm">You have no recent activities. New updates from the system will appear here.</p>
            </div>
        </div>
    </div>
</x-layouts::app>
