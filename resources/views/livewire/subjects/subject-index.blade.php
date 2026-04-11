<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 relative">

    <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search subjects or code..."
                       class="app-search-input" />
            </div>

            <button wire:click="openModal" wire:loading.attr="disabled"
                    class="app-primary-action-btn shrink-0">
                <svg wire:loading wire:target="openModal" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <svg wire:loading.remove wire:target="openModal" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1.1em" width="1.1em" xmlns="http://www.w3.org/2000/svg"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                New Subject
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full w-full text-sm align-middle whitespace-nowrap">
            <thead>
            <tr class="bg-gray-50/80 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-600 text-gray-500 dark:text-gray-300">
                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider text-xs">Class Name</th>
                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider text-xs">Subject Name</th>
                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider text-xs">Description</th>
                <th class="px-6 py-4 text-center font-semibold uppercase tracking-wider text-xs">Status</th>
                <th class="px-6 py-4 text-right font-semibold uppercase tracking-wider text-xs w-32">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
            @forelse($subjects as $subject)
                <tr class="hover:bg-indigo-50/50 dark:hover:bg-gray-700/50 group">
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                        {{ $subject->academicClass?->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                        <div class="flex items-center gap-2">
                            {{ $subject->name }}
                            @if($subject->is_premium)
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300 rounded-full">PREMIUM</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                        {{ $subject->description ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($subject->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Active</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-1">
                        <button type="button" wire:click="edit({{ $subject->id }})" wire:loading.attr="disabled"
                                class="app-icon-btn-edit" title="Edit">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>

                        <button type="button"
                                x-data
                                x-on:click="
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: 'You will not be able to recover this!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#ef4444',
                                        cancelButtonColor: '#6b7280',
                                        confirmButtonText: 'Yes, delete it!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $wire.delete({{ $subject->id }});
                                        }
                                    });
                                "
                                class="app-icon-btn-delete" title="Delete">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" class="mb-3 text-gray-300 dark:text-gray-600" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="3" x2="9" y2="21"></line></svg>
                            <p class="text-lg font-medium">No subjects found</p>
                        </div>
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

    <div x-data="{ open: false }"
         x-show="open"
         x-on:open-subject-modal.window="open = true"
         x-on:close-subject-modal.window="open = false"
         @keydown.escape.window="open = false"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto"
         wire:ignore.self> <div x-show="open"
                                x-transition.opacity.duration.300ms
                                class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" aria-hidden="true"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

            <div x-show="open"
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative w-full max-w-2xl overflow-hidden rounded-xl bg-white dark:bg-gray-800 text-left shadow-2xl border border-gray-200 dark:border-gray-700 transform">

                <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ $editId ? 'Edit Subject' : 'Create New Subject' }}
                    </h3>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form wire:submit.prevent="save">
                    <div class="px-6 py-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Academic Class <span class="text-red-500">*</span></label>
                                <select wire:model="academic_class_id" class="app-form-control">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @error('academic_class_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subject Name <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="name" placeholder="e.g. Mathematics" class="app-form-control">
                                @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image (Optional)</label>
                                <input type="file" wire:model="newImage" class="block w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2.5 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-600 dark:file:text-white cursor-pointer transition-colors border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none">
                                @error('newImage') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <textarea wire:model="description" rows="3" placeholder="Enter subject description..." class="app-form-control"></textarea>
                            @error('description') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center gap-6 pt-2">
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" wire:model="is_active" class="h-4 w-4 border border-gray-300 rounded text-indigo-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:checked:bg-indigo-600 transition-colors">
                                <span class="text-sm text-gray-700 dark:text-gray-300 font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">Is Active</span>
                            </label>

                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" wire:model="is_premium" class="h-4 w-4 border border-gray-300 rounded text-amber-500 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:checked:bg-amber-500 transition-colors">
                                <span class="text-sm text-gray-700 dark:text-gray-300 font-medium group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">Is Premium</span>
                            </label>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                        <button type="button" @click="open = false" class="app-form-button">
                            Cancel
                        </button>
                        <button type="submit" class="app-primary-submit-btn">
                            <span wire:loading.remove wire:target="save">{{ $editId ? 'Update Subject' : 'Save Subject' }}</span>
                            <span wire:loading wire:target="save" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Saving...
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
        window.addEventListener('subjectSaved', e => {
            if (window.Swal) {
                Swal.fire({ toast: true, icon: 'success', title: e.detail.message, position: 'top-end', showConfirmButton: false, timer: 2000 });
            }
        });
        window.addEventListener('subjectDeleted', e => {
            if (window.Swal) {
                Swal.fire({ toast: true, icon: 'success', title: e.detail.message, position: 'top-end', showConfirmButton: false, timer: 2000 });
            }
        });
    </script>
@endpush
