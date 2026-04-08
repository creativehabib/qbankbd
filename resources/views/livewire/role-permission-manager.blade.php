<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">Roles & Permissions</flux:heading>
            <flux:subheading>Role CRUD এবং permission assign system.</flux:subheading>
        </div>
        <button wire:click="createRole" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">+ Create role</button>
    </div>

    @error('roleName')
        <div class="rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-600">{{ $message }}</div>
    @enderror

    <section class="rounded-xl border border-zinc-700 bg-zinc-900/80 shadow-sm">
        <div class="border-b border-zinc-800 px-4 py-3 text-sm text-zinc-300">Role overview and assigned permissions</div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-zinc-200">
                <thead>
                    <tr class="border-b border-zinc-800 text-left text-zinc-400">
                        <th class="px-4 py-3">NAME</th>
                        <th class="px-4 py-3">PERMISSIONS</th>
                        <th class="px-4 py-3 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr class="border-b border-zinc-800/60">
                            <td class="px-4 py-3">
                                <div class="font-semibold">{{ $role->name }}</div>
                                <div class="text-xs text-zinc-500">Guard: {{ $role->guard }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    @forelse($role->permissions->take(5) as $permission)
                                        <span class="rounded-full border border-zinc-700 px-2 py-1 text-xs text-zinc-300">{{ $permission->slug }}</span>
                                    @empty
                                        <span class="text-zinc-500">None</span>
                                    @endforelse

                                    @if($role->permissions->count() > 5)
                                        <span class="rounded-full bg-zinc-200 px-2 py-1 text-xs text-zinc-900">+{{ $role->permissions->count() - 5 }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button wire:click="editRole({{ $role->id }})" class="rounded-lg border border-zinc-600 px-3 py-1.5 text-xs text-zinc-200">Edit</button>
                                <button wire:click="deleteRole({{ $role->id }})" class="rounded-lg border border-red-500 px-3 py-1.5 text-xs text-red-400">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-zinc-500">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-xl border border-zinc-700 bg-zinc-900/80 p-4">
        <h4 class="mb-3 text-sm font-semibold text-zinc-200">Permission CRUD</h4>
        <div class="grid gap-2 md:grid-cols-3">
            <input wire:model="permissionName" type="text" placeholder="Permission name" class="rounded-lg border-zinc-700 bg-zinc-800 text-sm text-zinc-100" />
            <input wire:model="permissionSlug" type="text" placeholder="permission.slug" class="rounded-lg border-zinc-700 bg-zinc-800 text-sm text-zinc-100" />
            <button wire:click="createPermission" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white">Create Permission</button>
        </div>
        @error('permissionName') <p class="mt-2 text-xs text-red-400">{{ $message }}</p> @enderror
        @error('permissionSlug') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror

        <div class="mt-4 flex flex-wrap gap-2">
            @foreach($permissions as $permission)
                <span class="inline-flex items-center gap-2 rounded-full border border-zinc-700 px-3 py-1 text-xs text-zinc-200">
                    {{ $permission->slug }}
                    <button wire:click="deletePermission({{ $permission->id }})" class="text-red-400">×</button>
                </span>
            @endforeach
        </div>
    </section>

    <div x-data="{ open: @entangle('showModal') }" x-show="open" style="display:none" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="open" class="fixed inset-0 bg-black/60" @click="open = false"></div>

            <div x-show="open" class="relative z-10 w-full max-w-4xl rounded-xl border border-zinc-700 bg-zinc-900 p-6">
                <h3 class="mb-4 text-lg font-semibold text-zinc-100">{{ $editingRoleId ? 'Edit Role' : 'Create Role' }}</h3>

                <div class="mb-4">
                    <label class="mb-1 block text-sm text-zinc-300">Role Name *</label>
                    <input wire:model="roleName" type="text" class="w-full rounded-lg border-zinc-700 bg-zinc-800 text-sm text-zinc-100" />
                    @error('roleName') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm text-zinc-300">Assign Permissions</label>
                    <div class="grid gap-2 md:grid-cols-3">
                        @foreach($permissions as $permission)
                            <label class="flex items-center gap-2 rounded-lg border border-zinc-700 bg-zinc-800 px-3 py-2 text-sm text-zinc-200">
                                <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->id }}" class="rounded border-zinc-600 text-indigo-500" />
                                <span>{{ $permission->slug }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" @click="open = false" class="rounded-lg border border-zinc-600 px-4 py-2 text-sm text-zinc-200">Cancel</button>
                    <button type="button" wire:click="saveRole" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white">Save Role</button>
                </div>
            </div>
        </div>
    </div>
</div>
