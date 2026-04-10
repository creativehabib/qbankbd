<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:badge size="sm" class="mb-2 uppercase tracking-widest">Access Control</flux:badge>
            <flux:heading size="xl">Permissions</flux:heading>
            <flux:subheading>Manage granular access by assigning permissions to roles and system users.</flux:subheading>
        </div>
        <div class="flex items-center gap-3">
            <flux:badge variant="outline" class="text-sm">
                {{ $permissions->count() }} permissions
            </flux:badge>
            <flux:button wire:click="createPermission" variant="primary" icon="plus">
                Create permission
            </flux:button>
        </div>
    </div>

    <flux:card>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>#</flux:table.column>
                <flux:table.column>NAME</flux:table.column>
                <flux:table.column>GROUP</flux:table.column>
                <flux:table.column align="right">ACTIONS</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($permissions as $index => $permission)
                    <flux:table.row>
                        <flux:table.cell class="text-zinc-500">
                            {{ $index + 1 }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $permission->name }}</p>
                            <div class="mt-1 flex items-center gap-1 text-xs text-zinc-500">
                                System key: <flux:badge size="sm" variant="outline">{{ $permission->name }}</flux:badge>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge variant="primary" size="sm">
                                {{ str($permission->name)->before('.')->replace('_', ' ')->title() }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell align="right">
                            <div class="flex justify-end gap-2">
                                <flux:button size="sm" variant="outline" wire:click="editPermission({{ $permission->id }})">
                                    Edit
                                </flux:button>
                                <flux:button size="sm" variant="danger" wire:click="deletePermission({{ $permission->id }})">
                                    Delete
                                </flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4" class="py-8 text-center text-zinc-500 dark:text-zinc-400">
                            No permissions found.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal wire:model="showModal" class="md:w-[600px] max-w-2xl space-y-6">
        <div>
            <flux:heading size="lg">{{ $editingPermissionId ? 'Edit Permission' : 'Create Permission' }}</flux:heading>
        </div>

        <div class="grid gap-4">
            <flux:input
                wire:model="name"
                label="Permission name *"
                placeholder="Enter permission name"
                autofocus
            />

            <flux:input
                wire:model="slug"
                label="Permission Slug *"
                placeholder="Enter permission slug"
            />
        </div>

        <div class="flex justify-end gap-2 mt-4">
            <flux:button wire:click="$set('showModal', false)" variant="ghost">Cancel</flux:button>
            <flux:button wire:click="savePermission" variant="primary">Save</flux:button>
        </div>
    </flux:modal>
</div>
