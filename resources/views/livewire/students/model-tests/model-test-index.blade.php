<div>
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-zinc-100 tracking-tight">Model Tests (মডেল টেস্ট)</h1>
        <p class="mt-2 text-zinc-600 dark:text-zinc-400">অংশগ্রহণ করুন এবং নিজের প্রস্তুতি যাচাই করুন।</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($modelTests as $test)
            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-100 to-indigo-50 dark:from-indigo-900/30 dark:to-indigo-900/10 rounded-bl-[100px] -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white relative z-10 pr-6 leading-tight mb-3 flex items-start gap-2">
                    {{ $test->title }}
                    @if($test->is_premium || $test->package_id)
                        <span class="inline-flex items-center justify-center p-1 bg-amber-100 text-amber-600 rounded-md dark:bg-amber-900/30 shrink-0" title="Premium Content">
                            <flux:icon.lock-closed class="size-4" />
                        </span>
                    @endif
                </h3>
                
                @if($test->description)
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4 line-clamp-2">
                        {{ $test->description }}
                    </p>
                @endif
                
                <div class="space-y-2 mb-6">
                    <div class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-300 font-medium">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        সময়: {{ $test->duration_minutes }} মিনিট
                    </div>
                    <div class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-300 font-medium">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        মোট প্রশ্ন: {{ $test->questions_count }} টি
                    </div>
                    <div class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-300 font-medium">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        নেগেটিভ মার্ক: {{ $test->negative_mark_weight }}
                    </div>
                </div>

                @if(auth()->user()->hasAccessToModelTest($test))
                    <a href="{{ route('student.model-tests.attempt', $test->id) }}" wire:navigate class="block w-full text-center py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition shadow-sm hover:shadow">
                        Start Exam
                    </a>
                @else
                    <a href="{{ route('student.pricing') }}" wire:navigate class="block w-full text-center py-2.5 px-4 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold transition shadow-sm hover:shadow flex items-center justify-center gap-2">
                        <flux:icon.lock-closed class="size-4" /> 
                        {{ $test->package_id ? 'Buy Course' : 'Upgrade to Pro' }}
                    </a>
                @endif
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800">
                <svg class="w-16 h-16 mx-auto text-zinc-300 dark:text-zinc-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <h3 class="text-xl font-bold text-zinc-700 dark:text-zinc-300 mb-1">কোনো মডেল টেস্ট নেই</h3>
                <p class="text-zinc-500 dark:text-zinc-500">বর্তমানে কোনো মডেল টেস্ট এভেইলেবল নেই।</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-8">
        {{ $modelTests->links() }}
    </div>
</div>
