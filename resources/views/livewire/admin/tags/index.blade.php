<x-split-layout>
    <x-slot:header>
        <x-modern-page-header title="Tags"
                    subtitle="{{ $tag->questions_count ?? 0 }} Questions" description="Manage tags for subjects and questions." modelName="tag"></x-modern-page-header>
    </x-slot:header>

    <x-slot:form>
        <div>
            @if(!$isCreating && !$editingId)
            <div>
                <x-modern-empty-state icon="tag" title="Select a tag"
                    subtitle="{{ $tag->questions_count ?? 0 }} Questions" description='Pick a row to view its details, or click "New tag" to add one.' />
            </div>
        @else
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
                <flux:button type="button" wire:click="cancelEdit" variant="ghost">Cancel</flux:button>
                @if(($editingId && $canUpdate) || (!$editingId && $canCreate))
                    <flux:button type="submit" variant="primary">
                        <span wire:loading.remove wire:target="save">Save</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </flux:button>
                @endif
            </div>
        </form>
        @endif
        </div>
    </x-slot:form>

    <x-slot:table>
        
        <x-modern-list-header :total="$tags->total()" model="search" />

        <x-modern-list>
            @forelse($tags as $tag)
                <x-modern-list-item 
                    :active="$editingId === $tag->id"
                    icon="tag"
                    title="{{ $tag->name }}"
                    subtitle="{{ $tag->questions_count ?? 0 }} Questions"
                    editAction="{{ $canUpdate ? 'edit('.$tag->id.')' : null }}"
                    deleteAction="{{ $canDelete ? 'delete('.$tag->id.')' : null }}"
                >
                    
                </x-modern-list-item>
            @empty
                <div class="py-10 text-center flex flex-col items-center justify-center text-gray-400">
                    <flux:icon icon="tag" class="size-10 mb-2 opacity-20" />
                    <p class="text-lg font-medium">No tags found</p>
                </div>
            @endforelse
        </x-modern-list>

        {{ $tags->links('components.modern-pagination') }}
    </x-slot:table>
    <x-modern-toggle-modal />
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
