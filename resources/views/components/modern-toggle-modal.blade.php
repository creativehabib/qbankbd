@props([
    'name' => 'toggle-confirm',
])

<flux:modal name="{{ $name }}" wire:model="showToggleModal" class="md:w-96">
    <div class="flex gap-4">
        <div class="shrink-0">
            <div class="flex size-10 items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200/50 dark:border-amber-500/20 text-amber-600 dark:text-amber-500">
                <flux:icon icon="exclamation-triangle" class="size-6" variant="outline" />
            </div>
        </div>
        <div class="flex-1">
            <flux:heading size="lg" class="!font-semibold">
                {{ $this->toggleTargetState ? 'Activate' : 'Deactivate' }} "{{ $this->toggleTargetName }}"?
            </flux:heading>
            
            <flux:text class="mt-1 !text-sm">
                Are you sure you want to {{ $this->toggleTargetState ? 'activate' : 'deactivate' }} this item?
            </flux:text>
            
            <div class="mt-6 flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost" size="sm">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="performToggle" variant="primary" size="sm" class="{{ !$this->toggleTargetState ? '!bg-orange-500 hover:!bg-orange-600 !text-white !border-orange-500' : '' }}">
                    <span wire:loading.remove wire:target="performToggle">
                        {{ $this->toggleTargetState ? 'Activate' : 'Deactivate' }}
                    </span>
                    <span wire:loading wire:target="performToggle">Wait...</span>
                </flux:button>
            </div>
        </div>
    </div>
</flux:modal>
