<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-white sm:text-4xl">
            আপনার লক্ষ্য কী?
        </h1>
        <p class="mt-4 text-lg text-zinc-500 dark:text-zinc-400">
            @if($step == 1)
                আপনি কোন পর্যায়ের প্রস্তুতি নিচ্ছেন তা নির্বাচন করুন
            @else
                আপনার নির্দিষ্ট লক্ষ্য বাছাই করুন
            @endif
        </p>
    </div>

    @if($step == 1)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($parents as $parent)
                <button wire:click="selectParent({{ $parent->id }})" class="group relative bg-white dark:bg-zinc-800 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-8 hover:shadow-md hover:border-indigo-500 dark:hover:border-indigo-500 transition-all text-left">
                    <div class="text-indigo-600 dark:text-indigo-400 mb-4">
                        <flux:icon.academic-cap class="size-10" />
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ $parent->name }}
                    </h3>
                    @if($parent->description)
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">
                            {{ $parent->description }}
                        </p>
                    @endif
                </button>
            @empty
                <div class="col-span-full text-center py-12 text-zinc-500 dark:text-zinc-400">
                    <flux:icon.inbox class="size-12 mx-auto mb-4 opacity-50" />
                    কোনো ক্যাটাগরি পাওয়া যায়নি। অ্যাডমিন প্যানেল থেকে ক্যাটাগরি যুক্ত করুন।
                </div>
            @endforelse
        </div>
    @endif

    @if($step == 2)
        <div class="mb-6 flex items-center justify-between">
            <button wire:click="backToParents" class="inline-flex items-center gap-2 text-sm font-medium text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors">
                <flux:icon.arrow-left class="size-4" />
                পেছনে ফিরে যান
            </button>
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">{{ $parentName }}</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            @forelse($children as $child)
                <button wire:click="selectGoal({{ $child->id }})" class="relative rounded-xl border {{ $selectedGoalId == $child->id ? 'border-indigo-600 bg-indigo-50/50 dark:bg-indigo-900/20' : 'border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800' }} p-6 text-left hover:border-indigo-500 transition-all">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold {{ $selectedGoalId == $child->id ? 'text-indigo-700 dark:text-indigo-300' : 'text-zinc-900 dark:text-white' }}">
                            {{ $child->name }}
                        </h4>
                        @if($selectedGoalId == $child->id)
                            <flux:icon.check-circle class="size-6 text-indigo-600 dark:text-indigo-400" />
                        @endif
                    </div>
                </button>
            @empty
                <div class="col-span-full text-center py-12 text-zinc-500 dark:text-zinc-400">
                    এই ক্যাটাগরিতে এখনো কোনো লক্ষ্য যুক্ত করা হয়নি।
                </div>
            @endforelse
        </div>

        @if($selectedGoalId)
            <div class="flex justify-center">
                <button wire:click="saveGoal" wire:loading.attr="disabled" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-8 py-3 text-lg font-semibold text-white shadow-sm transition hover:bg-indigo-700 disabled:opacity-75">
                    <span wire:loading.remove>শুরু করুন</span>
                    <span wire:loading>সংরক্ষণ করা হচ্ছে...</span>
                    <flux:icon.arrow-right class="size-5" wire:loading.remove />
                </button>
            </div>
        @endif
    @endif
</div>
