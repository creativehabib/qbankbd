<div class="space-y-6">
    <div>
        <flux:heading size="xl">Academic Structure</flux:heading>
        <flux:subheading>Manage Classes smoothly.</flux:subheading>
        <flux:separator class="my-6" />
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="mb-3 flex items-center justify-between gap-3">
                <h2 class="text-lg font-semibold">Academic Class</h2>
                <button wire:click="openClassModal" class="rounded-lg bg-indigo-600 px-3 py-2 text-sm text-white hover:bg-indigo-700">New Class</button>
            </div>
            <input wire:model.live.debounce.300ms="classSearch" type="text" placeholder="Search class" class="mb-3 w-full px-2 py-1.5 rounded-lg border border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500" />
            <table class="w-full text-sm">
                <thead><tr class="border-b dark:border-gray-700"><th class="py-2 text-left">Name</th><th class="text-right">Action</th></tr></thead>
                <tbody>
                @forelse($academicClasses as $academicClass)
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <td class="py-2">{{ $academicClass->name }}</td>
                        <td class="space-x-2 py-2 text-right">
                            <button wire:click="editClass({{ $academicClass->id }})" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">Edit</button>
                            <button wire:click="deleteClass({{ $academicClass->id }})" class="text-red-600 hover:text-red-800 dark:text-red-400">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="py-2 text-center text-gray-500">No class found.</td></tr>
                @endforelse
                </tbody>
            </table>
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
