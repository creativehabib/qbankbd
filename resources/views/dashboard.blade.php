<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-6">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-8 text-white shadow-lg">
            <h1 class="text-3xl font-bold mb-2">স্বাগতম, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-indigo-100 mb-6">আপনার ড্যাশবোর্ডে আপনাকে স্বাগতম। নিচে আপনার সাম্প্রতিক কার্যকলাপ এবং পরিসংখ্যান দেখুন।</p>
            <div class="flex gap-4">
                <a href="{{ route('profile.edit') }}" class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-semibold hover:bg-indigo-50 transition shadow">প্রোফাইল দেখুন</a>
            </div>
        </div>

        <div class="grid auto-rows-min gap-6 md:grid-cols-3">
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-neutral-200 dark:border-neutral-700 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 rounded-full flex items-center justify-center text-2xl font-bold">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zM144 272c-17.673 0-32-14.327-32-32s14.327-32 32-32 32 14.327 32 32-14.327 32-32 32zm112 0c-17.673 0-32-14.327-32-32s14.327-32 32-32 32 14.327 32 32-14.327 32-32 32zm112 0c-17.673 0-32-14.327-32-32s14.327-32 32-32 32 14.327 32 32-14.327 32-32 32z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 font-medium">রোল</p>
                    <p class="text-xl font-bold text-neutral-800 dark:text-neutral-100 uppercase">{{ auth()->user()->roles->pluck('name')->implode(', ') ?: 'User' }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-neutral-200 dark:border-neutral-700 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-full flex items-center justify-center text-xl font-bold">
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M22 11.08V12a10.002 10.002 0 0 1-5.938 9.162M22 4L12 14.01l-3-3"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 font-medium">স্ট্যাটাস</p>
                    <p class="text-xl font-bold text-neutral-800 dark:text-neutral-100">অ্যাক্টিভ</p>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-neutral-200 dark:border-neutral-700 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400 rounded-full flex items-center justify-center text-xl font-bold">
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 font-medium">যোগদানের তারিখ</p>
                    <p class="text-xl font-bold text-neutral-800 dark:text-neutral-100">{{ auth()->user()->created_at->format('d M, Y') }}</p>
                </div>
            </div>
        </div>
        
        <div class="relative h-full flex-1 overflow-hidden rounded-2xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-100 mb-4">সাম্প্রতিক আপডেট</h3>
            <p class="text-neutral-600 dark:text-neutral-400 text-sm">আপনার কোনো সাম্প্রতিক কার্যকলাপ নেই। সিস্টেম থেকে নতুন আপডেট এখানে প্রদর্শিত হবে।</p>
        </div>
    </div>
</x-layouts::app>
