@props(['active' => false, 'icon' => 'tag', 'title', 'subtitle' => null, 'editAction' => null, 'deleteAction' => null, 'statusBadge' => null, 'toggleAction' => null, 'toggleState' => false])

<div 
    @if($editAction) wire:click="{{ $editAction }}" @endif
    {{ $attributes->class([
    'group flex items-center justify-between py-3 px-4 transition-all border-b border-zinc-100 dark:border-zinc-800/50 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 relative',
    'cursor-pointer' => $editAction,
    'bg-zinc-50 dark:bg-zinc-800/50' => $active
]) }}>
    <!-- Active Indicator -->
    @if($active)
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-accent rounded-r-full"></div>
    @endif

    <div class="flex items-center gap-4 flex-1 min-w-0">
        <!-- Drag Handle (simulated or real) -->
        <div class="text-zinc-300 dark:text-zinc-600 cursor-grab hover:text-zinc-500 hidden sm:block">
            <svg class="size-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 6a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 12a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 18a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM16 6a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM16 12a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM16 18a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/></svg>
        </div>
        
        <!-- Icon -->
        <div class="size-9 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0 border border-zinc-200 dark:border-zinc-700">
            <flux:icon :icon="$icon" class="size-4 text-zinc-500" />
        </div>

        <!-- Title & Subtitle -->
        <div class="flex flex-col min-w-0 flex-1">
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">{{ $title }}</span>
                @if($statusBadge !== null)
                    <div class="inline-flex items-center gap-1 rounded-full bg-emerald-50 dark:bg-emerald-500/10 px-2 py-0.5 text-[10px] font-medium text-emerald-600 dark:text-emerald-400">
                        <div class="size-1.5 rounded-full bg-emerald-500"></div>
                        {{ $statusBadge }}
                    </div>
                @endif
                @if(isset($badges))
                    {{ $badges }}
                @endif
            </div>
            @if($subtitle)
                <span class="text-xs text-zinc-500 truncate mt-0.5">{{ $subtitle }}</span>
            @endif
        </div>
    </div>

    <!-- Right Actions / Slots -->
    <div class="flex items-center gap-4 shrink-0 ml-4" x-on:click.stop>
        @if(isset($end))
            <div class="flex items-center gap-3">
                {{ $end }}
            </div>
        @endif
        
        @if($toggleAction !== null)
            <button wire:click="{{ $toggleAction }}" type="button" class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 {{ $toggleState ? 'bg-accent' : 'bg-zinc-200 dark:bg-zinc-700' }}" role="switch" aria-checked="{{ $toggleState ? 'true' : 'false' }}">
                <span aria-hidden="true" class="pointer-events-none inline-block size-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $toggleState ? 'translate-x-4' : 'translate-x-0' }}"></span>
            </button>
        @endif
        
        @if($editAction || $deleteAction)
            <flux:dropdown position="bottom-end">
                <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" class="text-zinc-400" />
                <flux:menu>
                    @if($editAction)
                        <flux:menu.item icon="pencil-square" wire:click="{{ $editAction }}">Edit</flux:menu.item>
                    @endif
                    @if($deleteAction)
                        <flux:menu.item icon="trash" variant="danger" x-on:click="window.confirmDeleteAction(() => $wire.{{ $deleteAction }})">Delete</flux:menu.item>
                    @endif
                </flux:menu>
            </flux:dropdown>
        @endif
    </div>
</div>
