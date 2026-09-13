<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <div>
        <flux:heading size="xl">Cache Management</flux:heading>
        <flux:subheading>সিস্টেমের স্পিড এবং পারফরম্যান্স বাড়াতে ক্যাশ ফাইলগুলো নিয়মিত ক্লিয়ার করুন।</flux:subheading>
    </div>

    <!-- Cache Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <flux:card class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400">
                <flux:icon.server class="w-6 h-6" />
            </div>
            <div>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Cache Driver</p>
                <p class="text-lg font-bold text-zinc-900 dark:text-white uppercase">{{ $this->cacheInfo['driver'] }}</p>
            </div>
        </flux:card>

        <flux:card class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <flux:icon.document-duplicate class="w-6 h-6" />
            </div>
            <div>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">File Cache Size</p>
                <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $this->cacheInfo['file_cache_size'] }}</p>
            </div>
        </flux:card>
        
        <flux:card class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center text-purple-600 dark:text-purple-400">
                <flux:icon.photo class="w-6 h-6" />
            </div>
            <div>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Views Cache Size</p>
                <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $this->cacheInfo['views_size'] }}</p>
            </div>
        </flux:card>
    </div>

    <!-- Clear Cache Options -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- App Cache -->
        <flux:card>
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                        <flux:icon.circle-stack class="w-5 h-5 text-zinc-500" />
                        Application Cache
                    </h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">
                        সিস্টেমের ডিফল্ট ক্যাশ। ডাটাবেজ কুয়েরি বা অন্যান্য স্ট্যাটিক ডাটা ক্যাশ ক্লিয়ার করতে এটি ব্যবহার করুন।
                    </p>
                </div>
                <flux:button wire:click="clearApplicationCache" wire:loading.attr="disabled" size="sm" variant="danger" class="shrink-0">
                    <span wire:loading.remove wire:target="clearApplicationCache">Clear Cache</span>
                    <span wire:loading wire:target="clearApplicationCache">Clearing...</span>
                </flux:button>
            </div>
        </flux:card>

        <!-- Views Cache -->
        <flux:card>
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                        <flux:icon.window class="w-5 h-5 text-zinc-500" />
                        Views Cache
                    </h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">
                        ব্লেড ফাইলের কম্পাইলড ক্যাশ। ডিজাইনে কোনো পরিবর্তন করলে এবং সেটি শো না করলে এটি ক্লিয়ার করুন।
                    </p>
                </div>
                <flux:button wire:click="clearViewCache" wire:loading.attr="disabled" size="sm" variant="danger" class="shrink-0">
                    <span wire:loading.remove wire:target="clearViewCache">Clear Views</span>
                    <span wire:loading wire:target="clearViewCache">Clearing...</span>
                </flux:button>
            </div>
        </flux:card>

        <!-- Config Cache -->
        <flux:card>
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                        <flux:icon.cog-6-tooth class="w-5 h-5 text-zinc-500" />
                        Configuration Cache
                    </h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">
                        .env ফাইল বা কনফিগারেশন ফাইলে কোনো পরিবর্তন আনলে এই ক্যাশটি ক্লিয়ার করতে হয়।
                    </p>
                </div>
                <flux:button wire:click="clearConfigCache" wire:loading.attr="disabled" size="sm" variant="danger" class="shrink-0">
                    <span wire:loading.remove wire:target="clearConfigCache">Clear Config</span>
                    <span wire:loading wire:target="clearConfigCache">Clearing...</span>
                </flux:button>
            </div>
        </flux:card>

        <!-- Route Cache -->
        <flux:card>
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                        <flux:icon.map class="w-5 h-5 text-zinc-500" />
                        Route Cache
                    </h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">
                        নতুন কোনো রাউট বা URL তৈরি করলে এই ক্যাশটি ক্লিয়ার করা প্রয়োজন হয়।
                    </p>
                </div>
                <flux:button wire:click="clearRouteCache" wire:loading.attr="disabled" size="sm" variant="danger" class="shrink-0">
                    <span wire:loading.remove wire:target="clearRouteCache">Clear Routes</span>
                    <span wire:loading wire:target="clearRouteCache">Clearing...</span>
                </flux:button>
            </div>
        </flux:card>

    </div>
    
    <!-- Optimize All -->
    <flux:card class="bg-red-50 dark:bg-red-950/20 border-red-200 dark:border-red-900/50">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-black text-red-700 dark:text-red-400 flex items-center gap-2">
                    <flux:icon.bolt class="w-6 h-6" />
                    Optimize Clear (Clear All)
                </h3>
                <p class="mt-1 text-sm text-red-600/80 dark:text-red-400/80">
                    সিস্টেমের সমস্ত ক্যাশ (Application, Views, Routes, Config, Compiled Services) এক ক্লিকে মুছে ফেলুন।
                </p>
            </div>
            
            <flux:button wire:click="optimizeClear" wire:loading.attr="disabled" variant="danger" class="shrink-0 w-full md:w-auto shadow-sm">
                <span wire:loading.remove wire:target="optimizeClear" class="flex items-center gap-2">
                    <flux:icon.trash class="size-4" />
                    Clear All Caches
                </span>
                <span wire:loading wire:target="optimizeClear">Processing...</span>
            </flux:button>
        </div>
    </flux:card>
    
</div>
