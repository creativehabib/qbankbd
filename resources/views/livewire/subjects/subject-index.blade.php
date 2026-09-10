<x-split-layout>
    <x-slot:form>
        <form wire:submit="save" class="space-y-4">
            <div>
                <flux:heading size="lg">{{ $editId ? 'Edit Subject' : 'Create New Subject' }}</flux:heading>
                <flux:text class="mt-1">Add the subject details and assign a class.</flux:text>
            </div>

            <flux:field>
                <flux:label>Academic Class</flux:label>
                <flux:select wire:model="academic_class_id" placeholder="Choose a class...">
                    @foreach($classes as $class)
                        <flux:select.option value="{{ $class->id }}">{{ $class->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="academic_class_id" />
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
                @if($editId)
                    <flux:button type="button" wire:click="cancelEdit" variant="ghost">Cancel</flux:button>
                @endif
                <flux:button type="submit" variant="primary">
                    <span wire:loading.remove wire:target="save">Save</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </flux:button>
            </div>
        </form>
    </x-slot:form>

    <x-slot:table>
        <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-700">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <flux:heading size="lg">Subjects</flux:heading>
                    <flux:text>Manage subjects assigned to classes.</flux:text>
                </div>
            </div>

            <div class="mt-4">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    icon="magnifying-glass"
                    placeholder="Search subjects or code..."
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500 dark:bg-gray-700/40 dark:text-gray-300">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold">Class</th>
                        <th class="px-5 py-3 text-left font-semibold">Subject</th>
                        <th class="px-5 py-3 text-center font-semibold">Status</th>
                        <th class="px-5 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($subjects as $subject)
                        <tr wire:key="subject-{{ $subject->id }}" class="transition hover:bg-indigo-50/40 dark:hover:bg-gray-700/30">
                            <td class="px-5 py-3 text-gray-600 dark:text-gray-300">
                                {{ $subject->academicClass?->name ?? 'N/A' }}
                            </td>
                            <td class="px-5 py-3">
                                <div class="font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                    {{ $subject->name }}
                                    @if($subject->is_premium)
                                        <flux:badge size="sm" color="amber">PREMIUM</flux:badge>
                                    @endif
                                </div>
                                <div class="text-[10px] text-gray-500">{{ $subject->subject_code }}</div>
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($subject->is_active)
                                    <flux:badge size="sm" color="green">Active</flux:badge>
                                @else
                                    <flux:badge size="sm" color="red">Inactive</flux:badge>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button wire:click="edit({{ $subject->id }})" variant="ghost" size="sm" icon="pencil-square" aria-label="Edit" />
                                    <flux:button x-data x-on:click="window.confirmDeleteAction(() => $wire.delete({{ $subject->id }}))" variant="danger" size="sm" icon="trash" aria-label="Delete" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                No subjects found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subjects->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-800/30">
                {{ $subjects->links() }}
            </div>
        @endif
    </x-slot:table>
</x-split-layout>
