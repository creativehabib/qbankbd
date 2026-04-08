<div class="space-y-6">
    <section class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <div class="mb-2 inline-flex items-center rounded-full bg-zinc-100 px-3 py-1 text-xs uppercase tracking-widest text-zinc-500 dark:bg-zinc-800">Access Control</div>
                <flux:heading size="xl">Permissions</flux:heading>
                <flux:subheading>Manage granular access by assigning permissions to roles and system users.</flux:subheading>
            </div>
            <div class="flex items-center gap-3">
                <span class="rounded-full bg-zinc-100 px-3 py-1 text-sm text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">{{ $permissions->count() }} permissions</span>
                <button wire:click="createPermission" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">+ Create permission</button>
            </div>
        </div>

        <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-zinc-500">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">NAME</th>
                        <th class="px-4 py-3 text-left">GROUP</th>
                        <th class="px-4 py-3 text-left">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $index => $permission)
                        <tr class="border-t border-zinc-200 dark:border-zinc-700">
                            <td class="px-4 py-3 text-zinc-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $permission->slug }}</p>
                                <p class="text-xs text-zinc-500">System key: <span class="rounded bg-zinc-100 px-1 dark:bg-zinc-800">{{ $permission->slug }}</span></p>
                            </td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                    {{ str($permission->slug)->before('.')->replace('_', ' ')->title() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 space-x-2">
                                <button wire:click="editPermission({{ $permission->id }})" class="rounded-lg border border-zinc-300 px-3 py-1.5 text-xs text-zinc-700 dark:border-zinc-600 dark:text-zinc-200">Edit</button>
                                <button wire:click="deletePermission({{ $permission->id }})" class="rounded-lg border border-red-400 px-3 py-1.5 text-xs text-red-600">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-zinc-500">No permissions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div x-data="{ open: @entangle('showModal') }" x-show="open" style="display:none" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="open" class="fixed inset-0 bg-black/50" @click="open = false"></div>

            <div x-show="open" class="relative z-10 w-full max-w-2xl rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <h3 class="mb-4 text-lg font-semibold">{{ $editingPermissionId ? 'Edit Permission' : 'Create Permission' }}</h3>
                <div class="grid gap-4">
                    <div>
                        <label class="mb-1 block text-sm">Permission Name</label>
                        <input wire:model="name" type="text" class="w-full rounded-lg border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-800" />
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm">Permission Slug</label>
                        <input wire:model="slug" type="text" class="w-full rounded-lg border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-800" />
                        @error('slug') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" @click="open = false" class="rounded-lg border border-zinc-300 px-4 py-2 text-sm">Cancel</button>
                    <button type="button" wire:click="savePermission" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
