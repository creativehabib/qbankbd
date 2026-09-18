<x-split-layout>
    <x-slot:header>
        <x-modern-page-header title="Academic Class"
                    subtitle="" description="Create, search and manage classes from one place." modelName="class"></x-modern-page-header>
    </x-slot:header>

    <x-slot:form>
        <div>
            @if(!$isCreating && !$editingClassId)
            <div>
                <x-modern-empty-state icon="academic-cap" title="Select a class"
                    description='Pick a row to view its details, or click "New class" to add one.' />
            </div>
        @else
            <form wire:submit="saveClass" wire:key="form-{{ $editingClassId ?? 'create' }}" class="space-y-4">
            <div>
                <flux:heading size="lg">{{ $editingClassId ? 'Edit Class' : 'Create New Class' }}</flux:heading>
                <flux:text class="mt-1">Add the class details and availability settings.</flux:text>
            </div>



            <flux:field>
                <flux:label>Class/Category name</flux:label>
                <flux:input wire:model="class_name" placeholder="E.g. Job Prep, BCS, Class 6" />
                <flux:error name="class_name" />
            </flux:field>

            <flux:field>
                <flux:label>Description</flux:label>
                <flux:textarea wire:model="class_description" rows="4" placeholder="Description" />
                <flux:error name="class_description" />
            </flux:field>

            <div class="flex flex-wrap gap-4">
                <flux:checkbox wire:model="class_is_active" label="Active" />
                <flux:checkbox wire:model="class_is_premium" label="Premium" />
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <flux:button type="button" wire:click="resetClassForm" variant="ghost">Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
        @endif
        </div>
    </x-slot:form>

    <x-slot:table>

        <x-modern-list-header :total="$academicClasses->total()" model="classSearch" />

        <x-modern-list>
            @forelse($academicClasses as $academicClass)
                <x-modern-list-item wire:key="item-{{ $academicClass->id }}" 
                    :active="$editingClassId === $academicClass->id"
                    icon="academic-cap"
                    title="{{ $academicClass->name }}"
                    subtitle="{{ $academicClass->questions_count ?? 0 }} Questions"
                    editAction="editClass({{ $academicClass->id }})"
                    deleteAction="deleteClass({{ $academicClass->id }})" toggleAction="toggleActive({{ $academicClass->id }})" :toggleState="$academicClass->is_active"
                >

                                    <x-slot:end>
                        {{ $academicClass->is_premium ? 'Premium' : 'Standard' }}
                    </x-slot:end>
                </x-modern-list-item>
            @empty
                <div class="py-10 text-center flex flex-col items-center justify-center text-gray-400">
                    <flux:icon icon="academic-cap" class="size-10 mb-2 opacity-20" />
                    <p class="text-lg font-medium">No class found</p>
                    <p class="text-sm mt-1">Try adjusting your search.</p>
                </div>
            @endforelse
        </x-modern-list>

        @if(method_exists($academicClasses, 'hasPages') && $academicClasses->hasPages())
            {{ $academicClasses->links('components.modern-pagination') }}
        @endif
    </x-slot:table>
    <x-modern-toggle-modal />
</x-split-layout>
