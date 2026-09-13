<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <flux:heading size="xl" class="!font-semibold">Users</flux:heading>
            <flux:text class="mt-1 !text-sm">The people who can sign in. Give each a role per store.</flux:text>
        </div>

        <div class="flex items-center gap-3">
            <flux:dropdown>
                <flux:button variant="ghost" icon="arrow-down-tray" icon-trailing="chevron-down" class="!text-zinc-600 dark:!text-zinc-400">Export</flux:button>
                <flux:menu>
                    <flux:menu.item icon="document-text">Export as CSV</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
            <flux:button wire:click="createUser" variant="primary" icon="plus">
                New user
            </flux:button>
        </div>
    </div>

    <!-- Table Card Section -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden shadow-sm">

        <!-- Toolbar -->
        <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4 w-full sm:w-auto">
                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 whitespace-nowrap">
                    Users ({{ $users->total() }})
                </span>
                <div class="w-full sm:w-64">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        icon="magnifying-glass"
                        placeholder="Search users..."
                        size="sm"
                    />
                </div>
            </div>

            <div class="flex items-center gap-2">
                <flux:button variant="ghost" size="sm" icon="arrows-up-down" class="text-zinc-500">Sort</flux:button>
                <flux:button variant="ghost" size="sm" icon="arrow-path" wire:click="$refresh" class="text-zinc-500" />
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-400 dark:text-zinc-500 text-[10px] uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-4 py-3 flex items-center gap-1">USER <flux:icon.chevron-up class="size-3" /></th>
                        <th class="px-4 py-3">ROLE ACCESS</th>
                        <th class="px-4 py-3">STATUS</th>
                        <th class="px-4 py-3 text-right">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($users as $user)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20 transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <flux:avatar size="sm" :initials="$user->initials()" class="border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300" />
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $user->name }}</span>
                                        <span class="text-xs text-zinc-400">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <span class="text-sm text-zinc-400">
                                    {{ str(optional($user->roles->first())->name)->replace('_', ' ')->ucfirst() }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @php
                                        $isActive = $user->is_active ?? true;
                                    @endphp
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full {{ $isActive ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-500/20' : 'bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 border-red-100 dark:border-red-500/20' }} text-[11px] font-semibold tracking-wide border">
                                        <div class="size-1.5 rounded-full {{ $isActive ? 'bg-emerald-500' : 'bg-red-500' }}"></div>
                                        {{ $isActive ? 'Active' : 'Inactive' }}
                                    </div>

                                    @if($user->id === auth()->id())
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 text-[11px] font-semibold tracking-wide border border-orange-100 dark:border-orange-500/20">
                                            <div class="size-1.5 rounded-full bg-orange-500"></div>
                                            You
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($user->id !== auth()->id())
                                        <!-- Mock Toggle Switch -->
                                        <button type="button" wire:click="toggleStatus({{ $user->id }})" class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2" role="switch" aria-checked="{{ $isActive ? 'true' : 'false' }}">
                                            <span class="sr-only">Toggle status</span>
                                            <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white"></span>
                                            <span aria-hidden="true" class="pointer-events-none absolute mx-auto h-4 w-9 rounded-full {{ $isActive ? 'bg-orange-500' : 'bg-gray-200 dark:bg-zinc-700' }} transition-colors duration-200 ease-in-out"></span>
                                            <span aria-hidden="true" class="pointer-events-none absolute left-0 inline-block h-4 w-4 {{ $isActive ? 'translate-x-5' : 'translate-x-0' }} transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                        </button>
                                    @endif

                                    <flux:dropdown align="end" offset="-10">
                                        <flux:button variant="ghost" size="sm" icon="ellipsis-vertical" class="!text-zinc-400 hover:!text-zinc-900 dark:hover:!text-zinc-100" />

                                        <flux:menu>
                                            <flux:menu.item icon="pencil" wire:click="editUser({{ $user->id }})">Edit</flux:menu.item>
                                            <flux:menu.item icon="lock-closed" wire:click="signOutEverywhere({{ $user->id }})">Sign out everywhere</flux:menu.item>

                                            @if($user->id !== auth()->id())
                                                <flux:menu.separator />
                                                <flux:menu.item icon="trash" variant="danger" x-on:click="window.confirmDeleteAction(() => $wire.deleteUser({{ $user->id }}))">Delete</flux:menu.item>
                                            @endif
                                        </flux:menu>
                                    </flux:dropdown>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-zinc-500">
                                No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination / Footer -->
        {{ $users->links('components.modern-pagination') }}
    </div>

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
