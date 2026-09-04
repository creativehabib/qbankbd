<flux:modal name="delete-confirmation" class="w-full max-w-md">
    <div class="space-y-4">
        <div>
            <flux:heading size="lg">Delete this item?</flux:heading>
            <flux:text class="mt-2">This action cannot be undone.</flux:text>
        </div>

        <div class="flex justify-end gap-2">
            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>
            <flux:button variant="danger" x-on:click="window.confirmPendingDeletion()">Delete</flux:button>
        </div>
    </div>
</flux:modal>
