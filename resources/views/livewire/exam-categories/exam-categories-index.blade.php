<x-split-layout>
    <x-slot:form>
        <form wire:submit="save" class="space-y-4">
            <div>
                <flux:heading size="lg">{{ $editId ? 'Edit Exam Category' : 'Create Exam Category' }}</flux:heading>
                <flux:text class="mt-1">Add or update exam category details.</flux:text>
            </div>

            <flux:field>
                <flux:label>Exam Name</flux:label>
                <flux:input wire:model="name" placeholder="e.g. Admission Exam" />
                <flux:error name="name" />
            </flux:field>

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
                    <flux:heading size="lg">Exam Categories</flux:heading>
                    <flux:text>Manage exam categories like Admission Exam, Board Exam etc.</flux:text>
                </div>
            </div>

            <div class="mt-4">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    icon="magnifying-glass"
                    placeholder="Search exams..."
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500 dark:bg-gray-700/40 dark:text-gray-300">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold w-24">#ID</th>
                        <th class="px-5 py-3 text-left font-semibold">Exam Name</th>
                        <th class="px-5 py-3 text-right font-semibold w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($examCategories as $examCat)
                        <tr wire:key="exam-cat-{{ $examCat->id }}" class="transition hover:bg-indigo-50/40 dark:hover:bg-gray-700/30">
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                    #{{ $examCat->id }}
                                </span>
                            </td>
                            <td class="px-5 py-3 font-medium text-gray-900 dark:text-gray-100">
                                {{ $examCat->name }}
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button wire:click="edit({{ $examCat->id }})" variant="ghost" size="sm" icon="pencil-square" aria-label="Edit Exam" />
                                    <flux:button x-data x-on:click="window.confirmDeleteAction(() => $wire.delete({{ $examCat->id }}))" variant="danger" size="sm" icon="trash" aria-label="Delete Exam" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-10 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                    <p class="text-lg font-medium">No exam found</p>
                                    <p class="text-sm mt-1">Get started by creating a new exam.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($examCategories->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-800/30">
                {{ $examCategories->links() }}
            </div>
        @endif
    </x-slot:table>
</x-split-layout>
