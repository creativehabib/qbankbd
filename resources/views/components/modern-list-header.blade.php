@props(['total' => 0, 'model' => 'search'])

<div class="flex items-center justify-between px-4 py-3 border-b border-zinc-100 dark:border-zinc-800">
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <span class="font-medium text-sm whitespace-nowrap text-zinc-700 dark:text-zinc-300">All items ({{ $total }})</span>
        <div class="relative">
            <flux:input wire:model.live.debounce.300ms="{{ $model }}" icon="magnifying-glass" placeholder="Search..." class="w-full sm:w-64" />
        </div>
    </div>
    <div class="hidden lg:block text-xs text-zinc-400">
        Drag the handle to reorder
    </div>
    <div class="flex items-center gap-2">
                <flux:dropdown>
            <flux:button variant="ghost" size="sm" icon="arrows-up-down" icon-trailing="chevron-down" class="text-zinc-500">Sort</flux:button>
            <flux:menu class="w-48">
                <flux:menu.radio.group wire:model.live="sortField">
                    <flux:menu.radio value="default">Default order</flux:menu.radio>
                    <flux:menu.separator />
                    <flux:menu.radio value="name_asc">Name A &rarr; Z</flux:menu.radio>
                    <flux:menu.radio value="name_desc">Name Z &rarr; A</flux:menu.radio>
                </flux:menu.radio.group>
            </flux:menu>
        </flux:dropdown>
        <flux:button variant="ghost" size="sm" icon="arrow-path" wire:click="$refresh" class="text-zinc-500" />
    </div>
</div>
