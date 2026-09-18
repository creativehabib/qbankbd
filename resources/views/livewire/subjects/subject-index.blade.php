<x-split-layout>
    <x-slot:header>
        <x-modern-page-header title="Subjects" description="Manage subjects assigned to classes." modelName="subject"></x-modern-page-header>
    </x-slot:header>

    <x-slot:form>
        <div>
            @if(!$isCreating && !$editId)
            <div>
                <x-modern-empty-state icon="book-open" title="Select a subject" description="Pick a row to view its details, or click 'New subject' to add one." />
            </div>
        @else
            <form wire:submit="save" wire:key="form-{{ $editId ?? 'create' }}" class="space-y-4">
                <div>
                    <flux:heading size="lg">{{ $editId ? 'Edit Subject' : 'Create New Subject' }}</flux:heading>
                    <flux:text class="mt-1">Add the subject details and assign a class.</flux:text>
                </div>

                <flux:field>
                    <flux:label class="mb-2">Academic Classes</flux:label>
                    <div class="grid grid-cols-2 gap-2 mt-2 max-h-48 overflow-y-auto p-2 border border-gray-200 dark:border-gray-700 rounded-lg">
                        @foreach($classes as $class)
                            <flux:checkbox wire:model="academic_class_ids" value="{{ $class->id }}" label="{{ $class->name }}" />
                        @endforeach
                    </div>
                    <flux:error name="academic_class_ids" />
                </flux:field>

                <flux:field>
                    <flux:label>Subject Name</flux:label>
                    <flux:input wire:model="name" placeholder="e.g. Mathematics" />
                    <flux:error name="name" />
                </flux:field>

                <flux:field>
                    <flux:label>Subject Code (Optional)</flux:label>
                    <flux:input wire:model="subject_code" placeholder="e.g. MTH-101" />
                    <flux:error name="subject_code" />
                </flux:field>

                <flux:field>
                    <flux:label>Image (Optional)</flux:label>
                    @include('mediamanager::includes.media-input', [
                        'name'  => 'image',
                        'id'    => 'image',
                        'label' => 'Select Image',
                        'value' => $image,
                    ])
                    <flux:error name="image" />
                </flux:field>

                <flux:field>
                    <flux:label>Description</flux:label>
                    <flux:textarea wire:model="description" rows="3" placeholder="Enter subject description..." />
                    <flux:error name="description" />
                </flux:field>

                <div class="flex flex-wrap gap-4">
                    <flux:checkbox wire:model="is_active" label="Active" />
                    <flux:checkbox wire:model="is_premium" label="Premium" />
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <flux:button type="button" wire:click="cancelEdit" variant="ghost">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">
                        <span wire:loading.remove wire:target="save">Save</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </flux:button>
                </div>
            </form>
        @endif
        </div>
    </x-slot:form>

    <x-slot:table>
        
        
        <x-modern-list-header :total="$subjects->total()" model="search" />

        <x-modern-list>
            @forelse($subjects as $subject)
                @php
                    $classes = $subject->academicClasses;
                    $classNames = 'Global';
                    if ($classes->isNotEmpty()) {
                        $classNames = $classes->count() > 2 
                            ? $classes->take(2)->pluck('name')->join(', ') . ' (+' . ($classes->count() - 2) . ' more)'
                            : $classes->pluck('name')->join(', ');
                    }
                @endphp
                <x-modern-list-item wire:key="item-{{ $subject->id }}" 
                    :active="$editId === $subject->id"
                    icon="book-open"
                    title="{{ $subject->name }}"
                    subtitle="{{ $classNames }} {{ $subject->subject_code ? ' • '.$subject->subject_code : '' }} • {{ $subject->questions_count ?? 0 }} Questions"
                    editAction="edit({{ $subject->id }})"
                    deleteAction="delete({{ $subject->id }})"
                    :statusBadge="$subject->is_active ? 'Active' : null"
                    toggleAction="toggleActive({{ $subject->id }})"
                    :toggleState="$subject->is_active"
                >
                            <x-slot:end>
            <div class="text-xs font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-md">
                {{ $subject->is_premium ? 'Premium' : 'Standard' }}
            </div>
        </x-slot:end>
                </x-modern-list-item>
            @empty
                <div class="py-10 text-center flex flex-col items-center justify-center text-gray-400">
                    <flux:icon icon="book-open" class="size-10 mb-2 opacity-20" />
                    <p class="text-lg font-medium">No subjects found</p>
                    <p class="text-sm mt-1">Try adjusting your search or filter.</p>
                </div>
            @endforelse
        </x-modern-list>

        {{ $subjects->links('components.modern-pagination') }}
    </x-slot:table>
    <x-modern-toggle-modal />
</x-split-layout>
