<div class="space-y-6">
    <flux:card>
        <div class="mb-6 flex items-center justify-between gap-4">
            <div class="w-full sm:w-96">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    icon="magnifying-glass"
                    placeholder="Search by name or email..."
                />
            </div>
            <flux:button wire:click="createUser" variant="primary" icon="plus">
                Create User
            </flux:button>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>NAME</flux:table.column>
                <flux:table.column>EMAIL</flux:table.column>
                <flux:table.column>CURRENT ROLE</flux:table.column>
                <flux:table.column align="right">ACTIONS</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($users as $user)
                    <flux:table.row>
                        <flux:table.cell class="font-medium text-zinc-900 dark:text-zinc-100">
                            {{ $user->name }}
                        </flux:table.cell>

                        <flux:table.cell class="text-zinc-600 dark:text-zinc-400">
                            {{ $user->email }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge variant="primary" size="sm">
                                {{ str(optional($user->roles->first())->name)->replace('_', ' ')->title() }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell align="right">
                            <div class="flex justify-end gap-2">
                                <flux:button size="sm" variant="outline" wire:click="editUser({{ $user->id }})">
                                    Edit
                                </flux:button>
                                <flux:button
                                    size="sm"
                                    variant="danger"
                                    x-data
                                    x-on:click="window.confirmDeleteAction(() => $wire.deleteUser({{ $user->id }}))"
                                >
                                    Delete
                                </flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4" class="py-8 text-center text-zinc-500">
                            No users found.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if($users->hasPages())
            <div class="mt-4 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                {{ $users->links() }}
            </div>
        @endif
    </flux:card>

    <flux:modal wire:model="showEditModal" class="md:w-[620px] max-w-2xl space-y-6">
        <div>
            <flux:heading size="lg">{{ $editingUserId ? 'Edit User' : 'Create User' }}</flux:heading>
            <flux:text class="mt-2 text-sm text-zinc-500">
                {{ $editingUserId ? 'Update user information and assign a role.' : 'Create a new user with name, email, password and role.' }}
            </flux:text>
        </div>

        @error('role')
            <div class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-600 dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-400">
                {{ $message }}
            </div>
        @enderror

        @error('deleteUser')
            <div class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-600 dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-400">
                {{ $message }}
            </div>
        @enderror

        <div class="grid gap-4">
            <flux:input
                wire:model="name"
                label="Name *"
                placeholder="Enter name"
                autofocus
            />

            <flux:input
                wire:model="email"
                type="email"
                label="Email *"
                placeholder="Enter email address"
            />

            @if(!$editingUserId)
                <flux:input
                    wire:model="password"
                    type="password"
                    label="Password *"
                    placeholder="Enter password"
                />

                <flux:input
                    wire:model="password_confirmation"
                    type="password"
                    label="Confirm Password *"
                    placeholder="Confirm password"
                />
            @endif

            <div>
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Assign Role *</label>
                <select
                    wire:model="selectedRole"
                    class="app-form-select"
                >
                    <option value="">Select role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <flux:button wire:click="$set('showEditModal', false)" variant="ghost">Cancel</flux:button>
            <flux:button wire:click="saveUser" variant="primary">{{ $editingUserId ? 'Update' : 'Create' }}</flux:button>
        </div>
    </flux:modal>
</div>
