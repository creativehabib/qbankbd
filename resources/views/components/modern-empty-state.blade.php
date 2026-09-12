@props(['icon' => 'tag', 'title' => 'Select an item', 'description' => 'Pick a row to view its details, or add a new one.'])

<div class="py-16 px-6 text-center flex flex-col items-center">
    <div class="size-12 bg-zinc-100 dark:bg-zinc-800 rounded-xl flex items-center justify-center mb-4">
        <flux:icon :icon="$icon" class="size-6 text-zinc-400" />
    </div>
    <h3 class="text-base font-medium text-zinc-900 dark:text-zinc-100 mb-1">{{ $title }}</h3>
    <p class="text-sm text-zinc-500">{{ $description }}</p>
</div>
