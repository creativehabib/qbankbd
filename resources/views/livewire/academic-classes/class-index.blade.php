<div class="space-y-6">
    <div class="grid gap-6">
        <section class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-700">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <flux:heading size="lg">Academic Class</flux:heading>
                        <flux:text>Create, search and manage classes from one place.</flux:text>
                    </div>
                    <flux:button wire:click="openClassModal" variant="primary" icon="plus">
                        New Class
                    </flux:button>
                </div>

                <div class="mt-4">
                    <flux:input
                        wire:model.live.debounce.300ms="classSearch"
                        icon="magnifying-glass"
                        placeholder="Search class..."
                    />
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500 dark:bg-gray-700/40 dark:text-gray-300">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold">Class</th>
                            <th class="px-5 py-3 text-left font-semibold">ID</th>
                            <th class="px-5 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($academicClasses as $academicClass)
                            <tr wire:key="academic-class-{{ $academicClass->id }}" class="transition hover:bg-indigo-50/40 dark:hover:bg-gray-700/30">
                                <td class="px-5 py-3">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $academicClass->name }}</div>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                        #{{ $academicClass->id }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <flux:button wire:click="editClass({{ $academicClass->id }})" variant="ghost" size="sm" icon="pencil-square" aria-label="Edit class" />
                                        <flux:button wire:click="deleteClass({{ $academicClass->id }})" wire:confirm="Delete this class?" variant="danger" size="sm" icon="trash" aria-label="Delete class" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No class found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <flux:modal wire:model="showClassModal" class="w-full max-w-xl">
        <form wire:submit="saveClass" class="space-y-4">
            <div>
                <flux:heading size="lg">{{ $editingClassId ? 'Edit Class' : 'Create New Class' }}</flux:heading>
                <flux:text class="mt-1">Add the class details and availability settings.</flux:text>
            </div>

            <flux:field>
                <flux:label>Class name</flux:label>
                <flux:input wire:model="class_name" placeholder="Class name" />
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

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button type="button" variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>

@push('scripts')
    <script>
        window.addEventListener('entity-saved', event => {
            if (window.Swal) {
                Swal.fire({ toast: true, icon: 'success', title: event.detail.message, position: 'top-end', timer: 1500, showConfirmButton: false });
            }
        });

        window.addEventListener('entity-deleted', event => {
            if (window.Swal) {
                Swal.fire({ toast: true, icon: 'success', title: event.detail.message, position: 'top-end', timer: 1500, showConfirmButton: false });
            }
        });
    </script>
@endpush
