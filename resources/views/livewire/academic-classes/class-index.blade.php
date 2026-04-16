<div class="space-y-6">
    <div class="grid gap-6">
        <section class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-700">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Academic Class</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Create, search and manage classes from one place.</p>
                    </div>
                    <button wire:click="openClassModal" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        New Class
                    </button>
                </div>

                <div class="mt-4">
                    <input
                        wire:model.live.debounce.300ms="classSearch"
                        type="text"
                        placeholder="Search class..."
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-500 focus:ring-indigo-500"
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
                            <tr class="transition hover:bg-indigo-50/40 dark:hover:bg-gray-700/30">
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
                                        <button wire:click="editClass({{ $academicClass->id }})" class="app-icon-btn-edit" title="Edit class">
                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                        <button
                                            x-data
                                            x-on:click="window.confirmDeleteAction(() => $wire.deleteClass({{ $academicClass->id }}))"
                                            class="app-icon-btn-delete"
                                            title="Delete class"
                                        >
                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </button>
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

    <div x-data="{ open: @entangle('showClassModal') }"
         x-show="open"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300 transition-opacity" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200 transition-opacity" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="open = false"></div>
            <div x-show="open" x-transition:enter="transition-all ease-out duration-300" x-transition:enter-start="opacity-0 scale-110" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition-all ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative z-10 w-full max-w-xl max-h-[90vh] overflow-y-auto rounded-xl border border-gray-200 bg-white text-left shadow-2xl dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b bg-gray-50 px-6 py-4 dark:border-gray-700 dark:bg-gray-700/50"><h3 class="text-lg font-bold">{{ $editingClassId ? 'Edit Class' : 'Create New Class' }}</h3></div>
                <form wire:submit="saveClass" class="space-y-3 px-6 py-6">
                    <input wire:model="class_name" type="text" placeholder="Class name" class="w-full px-4 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500" />
                    @error('class_name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    <textarea wire:model="class_description" rows="4" placeholder="Description" class="w-full p-4 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    <div class="flex gap-4 text-sm"><label class="flex items-center gap-2"><input type="checkbox" wire:model="class_is_active" class="rounded text-indigo-600"> Active</label><label class="flex items-center gap-2"><input type="checkbox" wire:model="class_is_premium" class="rounded text-indigo-600"> Premium</label></div>
                    <div class="flex justify-end gap-2 border-t pt-4 dark:border-gray-700"><button type="button" @click="open = false" class="rounded border border-gray-300 px-4 py-2 hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">Cancel</button><button type="submit" class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 transition-colors">Save</button></div>
                </form>
            </div>
        </div>
    </div>

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
