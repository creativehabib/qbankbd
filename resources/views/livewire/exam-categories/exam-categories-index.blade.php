<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 relative">

    <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search exams..."
                       class="app-search-input" />
            </div>

            <button wire:click="openModal" wire:loading.attr="disabled"
                    class="app-primary-action-btn shrink-0">
                <svg wire:loading wire:target="openModal" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <svg wire:loading.remove wire:target="openModal" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1.1em" width="1.1em" xmlns="http://www.w3.org/2000/svg"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                New Exam
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full w-full text-sm align-middle whitespace-nowrap">
            <thead>
            <tr class="bg-gray-50/80 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-600 text-gray-500 dark:text-gray-300">
                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider text-xs w-24">#ID</th>
                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider text-xs">Exam Name</th>
                <th class="px-6 py-4 text-right font-semibold uppercase tracking-wider text-xs w-32">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
            @forelse($examCategories as $examCat)
                <tr class="hover:bg-indigo-50/50 dark:hover:bg-gray-700/50 transition-colors group">
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                            #{{ $examCat->id }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                        {{ $examCat->name }}
                    </td>
                    <td class="px-6 py-4 text-right space-x-1">

                        <button type="button" wire:click="edit({{ $examCat->id }})" wire:loading.attr="disabled"
                                class="app-icon-btn-edit" title="Edit Exam">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>

                        <button type="button"
                                x-data
                                x-on:click="window.confirmDeleteAction(() => $wire.delete({{ $examCat->id }}))"
                                class="app-icon-btn-delete" title="Delete Exam">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="mb-3 text-gray-300 dark:text-gray-600" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="3" x2="9" y2="21"></line></svg>
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

    <div x-data="{ showModal: @entangle('showModal') }"
         x-show="showModal"
         @keydown.escape.window="showModal = false"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true"
         wire:ignore.self> <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">

            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300 transition-opacity"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200 transition-opacity"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"
                 @click="showModal = false" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showModal"
                 @click.away="showModal = false"
                 x-transition:enter="transition-all ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition-all ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative inline-block w-full max-w-lg overflow-hidden rounded-xl bg-white dark:bg-gray-800 text-left shadow-2xl border border-gray-200 dark:border-gray-700 align-bottom sm:my-8 sm:align-middle z-10">

                <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white" id="modal-title">
                        {{ $editId ? 'Edit Exam' : 'Create New Exam' }}
                    </h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-500 focus:outline-none transition-colors">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form wire:submit.prevent="save">
                    <div class="px-6 py-6 space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Exam Name <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="name" placeholder="e.g. Admission Exam" class="app-form-control">
                            @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="app-form-button">
                            Cancel
                        </button>
                        <button type="submit" class="app-primary-submit-btn">
                            <span wire:loading.remove wire:target="save">{{ $editId ? 'Update Exam' : 'Save Exam' }}</span>
                            <span wire:loading wire:target="save" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                {{ $editId ? 'Updating...' : 'Saving...' }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function showToast(message) {
            if (!window.Swal) return;
            Swal.fire({
                toast: true,
                icon: 'success',
                title: message,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        }

        window.addEventListener('examSaved', e => {
            showToast(e.detail.message);
        });

        window.addEventListener('examDeleted', e => {
            showToast(e.detail.message || 'Exam has been deleted successfully.');
        });
    </script>
@endpush
