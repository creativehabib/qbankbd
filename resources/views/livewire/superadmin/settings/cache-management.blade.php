<div class="space-y-6">
    <div class="space-y-1 mb-2">
        <flux:heading size="xl">Cache Management</flux:heading>
        <flux:subheading size="lg">সিস্টেমের স্পিড এবং পারফরম্যান্স বাড়াতে ক্যাশ ফাইলগুলো নিয়মিত ক্লিয়ার করুন।</flux:subheading>
    </div>

    <!-- Cache Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <flux:card class="relative overflow-hidden group flex items-center gap-4">
            <div class="absolute -right-2 -top-2 size-16 text-blue-100 dark:text-blue-900/30 opacity-30 transition-transform group-hover:scale-110">
                <flux:icon.server class="size-16" />
            </div>
            <div class="z-10 w-12 h-12 rounded-full bg-blue-50 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-800">
                <flux:icon.server class="w-6 h-6" />
            </div>
            <div class="z-10">
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Cache Driver</p>
                <p class="mt-1 text-2xl font-black text-zinc-900 dark:text-white uppercase">{{ $this->cacheInfo['driver'] }}</p>
            </div>
        </flux:card>

        <flux:card class="relative overflow-hidden group flex items-center gap-4">
            <div class="absolute -right-2 -top-2 size-16 text-emerald-100 dark:text-emerald-900/30 opacity-30 transition-transform group-hover:scale-110">
                <flux:icon.document-duplicate class="size-16" />
            </div>
            <div class="z-10 w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800">
                <flux:icon.document-duplicate class="w-6 h-6" />
            </div>
            <div class="z-10">
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">File Cache Size</p>
                <p class="mt-1 text-2xl font-black text-zinc-900 dark:text-white">{{ $this->cacheInfo['file_cache_size'] }}</p>
            </div>
        </flux:card>
        
        <flux:card class="relative overflow-hidden group flex items-center gap-4">
            <div class="absolute -right-2 -top-2 size-16 text-purple-100 dark:text-purple-900/30 opacity-30 transition-transform group-hover:scale-110">
                <flux:icon.photo class="size-16" />
            </div>
            <div class="z-10 w-12 h-12 rounded-full bg-purple-50 dark:bg-purple-900/50 flex items-center justify-center text-purple-600 dark:text-purple-400 border border-purple-100 dark:border-purple-800">
                <flux:icon.photo class="w-6 h-6" />
            </div>
            <div class="z-10">
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Views Cache Size</p>
                <p class="mt-1 text-2xl font-black text-zinc-900 dark:text-white">{{ $this->cacheInfo['views_size'] }}</p>
            </div>
        </flux:card>
    </div>

    <!-- Clear Cache Options -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        
        <!-- App Cache -->
        <flux:card class="group hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="flex gap-3">
                    <div class="mt-1 text-zinc-400 group-hover:text-zinc-600 dark:group-hover:text-zinc-300 transition-colors">
                        <flux:icon.circle-stack class="size-6" />
                    </div>
                    <div>
                        <flux:heading size="md">Application Cache</flux:heading>
                        <flux:text class="mt-1 !text-sm">সিস্টেমের ডিফল্ট ক্যাশ। ডাটাবেজ কুয়েরি বা অন্যান্য স্ট্যাটিক ডাটা ক্যাশ ক্লিয়ার করতে এটি ব্যবহার করুন।</flux:text>
                    </div>
                </div>
                <flux:button wire:click="clearApplicationCache" wire:loading.attr="disabled" size="sm" variant="danger" class="shrink-0 w-full sm:w-auto">
                    <span wire:loading.remove wire:target="clearApplicationCache">Clear Cache</span>
                    <span wire:loading wire:target="clearApplicationCache">Clearing...</span>
                </flux:button>
            </div>
        </flux:card>

        <!-- Views Cache -->
        <flux:card class="group hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="flex gap-3">
                    <div class="mt-1 text-zinc-400 group-hover:text-zinc-600 dark:group-hover:text-zinc-300 transition-colors">
                        <flux:icon.window class="size-6" />
                    </div>
                    <div>
                        <flux:heading size="md">Views Cache</flux:heading>
                        <flux:text class="mt-1 !text-sm">ব্লেড ফাইলের কম্পাইলড ক্যাশ। ডিজাইনে কোনো পরিবর্তন করলে এবং সেটি শো না করলে এটি ক্লিয়ার করুন।</flux:text>
                    </div>
                </div>
                <flux:button wire:click="clearViewCache" wire:loading.attr="disabled" size="sm" variant="danger" class="shrink-0 w-full sm:w-auto">
                    <span wire:loading.remove wire:target="clearViewCache">Clear Views</span>
                    <span wire:loading wire:target="clearViewCache">Clearing...</span>
                </flux:button>
            </div>
        </flux:card>

        <!-- Config Cache -->
        <flux:card class="group hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="flex gap-3">
                    <div class="mt-1 text-zinc-400 group-hover:text-zinc-600 dark:group-hover:text-zinc-300 transition-colors">
                        <flux:icon.cog-6-tooth class="size-6" />
                    </div>
                    <div>
                        <flux:heading size="md">Configuration Cache</flux:heading>
                        <flux:text class="mt-1 !text-sm">.env ফাইল বা কনফিগারেশন ফাইলে কোনো পরিবর্তন আনলে এই ক্যাশটি ক্লিয়ার করতে হয়।</flux:text>
                    </div>
                </div>
                <flux:button wire:click="clearConfigCache" wire:loading.attr="disabled" size="sm" variant="danger" class="shrink-0 w-full sm:w-auto">
                    <span wire:loading.remove wire:target="clearConfigCache">Clear Config</span>
                    <span wire:loading wire:target="clearConfigCache">Clearing...</span>
                </flux:button>
            </div>
        </flux:card>

        <!-- Route Cache -->
        <flux:card class="group hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="flex gap-3">
                    <div class="mt-1 text-zinc-400 group-hover:text-zinc-600 dark:group-hover:text-zinc-300 transition-colors">
                        <flux:icon.map class="size-6" />
                    </div>
                    <div>
                        <flux:heading size="md">Route Cache</flux:heading>
                        <flux:text class="mt-1 !text-sm">নতুন কোনো রাউট বা URL তৈরি করলে এই ক্যাশটি ক্লিয়ার করা প্রয়োজন হয়।</flux:text>
                    </div>
                </div>
                <flux:button wire:click="clearRouteCache" wire:loading.attr="disabled" size="sm" variant="danger" class="shrink-0 w-full sm:w-auto">
                    <span wire:loading.remove wire:target="clearRouteCache">Clear Routes</span>
                    <span wire:loading wire:target="clearRouteCache">Clearing...</span>
                </flux:button>
            </div>
        </flux:card>

    </div>
    
    <!-- Optimize All -->
    <flux:card class="bg-red-50 dark:bg-red-950/20 border-red-200 dark:border-red-900/50 relative overflow-hidden group">
        <div class="absolute -right-2 -top-2 size-24 text-red-100 dark:text-red-900/20 opacity-30 transition-transform group-hover:scale-110">
            <flux:icon.bolt class="size-24" />
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex gap-3">
                <div class="mt-1 text-red-600 dark:text-red-500">
                    <flux:icon.bolt class="size-8" />
                </div>
                <div>
                    <h3 class="text-lg font-black text-red-700 dark:text-red-400">
                        Optimize Clear (Clear All)
                    </h3>
                    <p class="mt-1 text-sm text-red-600/90 dark:text-red-400/90 font-medium">
                        সিস্টেমের সমস্ত ক্যাশ (Application, Views, Routes, Config, Compiled Services) এক ক্লিকে মুছে ফেলুন।
                    </p>
                </div>
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
