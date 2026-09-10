<x-split-layout>
    <x-slot:form>
        <form wire:submit="save" class="space-y-4">
            <div>
                <flux:heading size="lg">{{ $editingId ? 'Edit Tag' : 'Create Tag' }}</flux:heading>
                <flux:text class="mt-1">Add or update tag details.</flux:text>
            </div>

            <flux:field>
                <flux:label>Tag Name</flux:label>
                <flux:input wire:model="name" placeholder="e.g. PHP" />
                <flux:error name="name" />
            </flux:field>

            <div class="flex justify-end gap-2 pt-2">
                @if($editingId)
                    <flux:button type="button" wire:click="cancelEdit" variant="ghost">Cancel</flux:button>
                @endif
                @if(($editingId && $canUpdate) || (!$editingId && $canCreate))
                    <flux:button type="submit" variant="primary">
                        <span wire:loading.remove wire:target="save">Save</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </flux:button>
                @endif
            </div>
        </form>
    </x-slot:form>

    <x-slot:table>
        <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-700">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <flux:heading size="lg">Tags</flux:heading>
                    <flux:text>Manage tags for subjects and questions.</flux:text>
                </div>
            </div>

            <div class="mt-4">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    icon="magnifying-glass"
                    placeholder="Search tags..."
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500 dark:bg-gray-700/40 dark:text-gray-300">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold w-24">#ID</th>
                        <th class="px-5 py-3 text-left font-semibold">Name</th>
                        <th class="px-5 py-3 text-right font-semibold w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($tags as $tag)
                        <tr wire:key="tag-{{ $tag->id }}" class="transition hover:bg-indigo-50/40 dark:hover:bg-gray-700/30">
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                    #{{ $tag->id }}
                                </span>
                            </td>
                            <td class="px-5 py-3 font-medium text-gray-900 dark:text-gray-100">
                                {{ $tag->name }}
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($canUpdate)
                                        <flux:button wire:click="edit({{ $tag->id }})" variant="ghost" size="sm" icon="pencil-square" aria-label="Edit Tag" />
                                    @endif
                                    @if($canDelete)
                                        <flux:button type="button" onclick="confirmDelete({{ $tag->id }})" variant="danger" size="sm" icon="trash" aria-label="Delete Tag" />
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-10 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                    <p class="text-lg font-medium">No tags found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tags->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-800/30">
                {{ $tags->links() }}
            </div>
        @endif
    </x-slot:table>
</x-split-layout>

@push('scripts')
<script>
    function confirmDelete(id) {
        window.confirmDeleteAction(() => {
            Livewire.dispatch('deleteTagConfirmed', { id: id });
        });
    }

    window.addEventListener('tag-saved', event => {
        if (window.Flux) {
            window.Flux.toast({ variant: 'success', text: event.detail.message });
        }
    });

    window.addEventListener('tag-deleted', event => {
        if (window.Flux) {
            window.Flux.toast({ variant: 'success', text: event.detail.message });
        }
    });

    window.addEventListener('tagSaved', e => {
        if (window.Flux) window.Flux.toast({ variant: 'success', text: e.detail.message || 'Tag added successfully.' });
    });

    window.addEventListener('tagUpdated', e => {
        if (window.Flux) window.Flux.toast({ variant: 'success', text: e.detail.message || 'Tag updated successfully.' });
    });

    window.addEventListener('tagDeleted', e => {
        if (window.Flux) window.Flux.toast({ variant: 'success', text: e.detail.message || 'Tag deleted successfully.' });
    });
</script>
@endpush
