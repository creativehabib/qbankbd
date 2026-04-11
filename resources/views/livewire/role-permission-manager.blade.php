<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">Roles & Permissions</flux:heading>
            <flux:subheading>Role CRUD এবং permission assign system.</flux:subheading>
        </div>
        <flux:button wire:click="createRole" variant="primary" icon="plus">
            Create role
        </flux:button>
    </div>

    @error('roleName')
    <div class="rounded-md border border-red-200 bg-red-50 dark:border-red-900/50 dark:bg-red-900/20 px-3 py-2 text-sm text-red-600 dark:text-red-400">
        {{ $message }}
    </div>
    @enderror

    <flux:card>
        <div class="mb-4 text-sm text-zinc-600 dark:text-zinc-400">
            Role overview and assigned permissions
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>NAME</flux:table.column>
                <flux:table.column>PERMISSIONS</flux:table.column>
                <flux:table.column align="right">ACTIONS</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($roles as $role)
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $role->name }}</div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Guard: {{ $role->guard_name }}</div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex flex-wrap gap-2">
                                @forelse($role->permissions->take(5) as $permission)
                                    <flux:badge size="sm" variant="outline">{{ $permission->name }}</flux:badge>
                                @empty
                                    <span class="text-sm text-zinc-500 dark:text-zinc-400">None</span>
                                @endforelse

                                @if($role->permissions->count() > 5)
                                    <flux:badge size="sm" variant="solid">
                                        +{{ $role->permissions->count() - 5 }}
                                    </flux:badge>
                                @endif
                            </div>
                        </flux:table.cell>

                        <flux:table.cell align="right">
                            <div class="flex justify-end gap-2">
                                <flux:button size="sm" variant="outline" wire:click="editRole({{ $role->id }})">
                                    Edit
                                </flux:button>
                                <flux:button size="sm" variant="danger" wire:click="deleteRole({{ $role->id }})"
                                    wire:confirm="Are you sure you want to delete this role?">
                                    Delete
                                </flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="3" class="py-8 text-center text-zinc-500 dark:text-zinc-400">
                            No roles found.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal wire:model="showModal" class="md:w-[800px] max-w-4xl space-y-6">
        <div>
            <flux:heading size="lg">{{ $editingRoleId ? 'Edit Role' : 'Create Role' }}</flux:heading>
        </div>

        <flux:input
            wire:model="roleName"
            label="Role Name *"
            placeholder="Enter role name"
        />

        <div class="space-y-4">
            <div>
                <flux:heading size="sm" class="mb-3">Assign Permissions</flux:heading>
                <flux:checkbox
                    wire:change="toggleAllPermissions($event.target.checked)"
                    :checked="count($selectedPermissions) === $permissions->count() && $permissions->count() > 0"
                    label="Select all permissions"
                />
            </div>

            <div class="space-y-3 pr-2">
                @foreach($groupedPermissions as $group => $groupPermissions)
                    <flux:card class="!p-4">
                        <flux:subheading class="mb-3 uppercase tracking-wide">{{ $group }}</flux:subheading>
                        <div class="grid gap-3 md:grid-cols-3">
                            @foreach($groupPermissions as $permission)
                                <flux:checkbox
                                    wire:model="selectedPermissions"
                                    value="{{ $permission->id }}"
                                    label="{{ $permission->name }}"
                                />
                            @endforeach
                        </div>
                    </flux:card>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <flux:button wire:click="$set('showModal', false)" @class('cursor-pointer') variant="ghost">Cancel</flux:button>
            <flux:button wire:click="saveRole" variant="primary" @class('cursor-pointer')>Save Role</flux:button>
        </div>
    </flux:modal>
</div>
