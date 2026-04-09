<div class="space-y-6">
    <div>
        <flux:heading size="xl">User Management</flux:heading>
        <flux:subheading>এখান থেকে user role এবং direct permission manage করতে পারবেন।</flux:subheading>
        <flux:separator class="my-6" />
    </div>

    <flux:card>
        <div class="mb-6 flex items-center justify-between gap-4">
            <div class="w-full sm:w-96">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    icon="magnifying-glass"
                    placeholder="Search by name or email..."
                />
            </div>
        </div>

        @error('role')
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 dark:border-red-900/50 dark:bg-red-900/20 px-3 py-2 text-sm text-red-600 dark:text-red-400">
            {{ $message }}
        </div>
        @enderror

        <flux:table>
            <flux:table.columns>
                <flux:table.column>NAME</flux:table.column>
                <flux:table.column>EMAIL</flux:table.column>
                <flux:table.column>CURRENT ROLE</flux:table.column>
                <flux:table.column>ASSIGN ROLE</flux:table.column>
                <flux:table.column>DIRECT PERMISSIONS</flux:table.column>
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
                                {{ str($user->role)->replace('_', ' ')->title() }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            <select
                                wire:change="updateRole({{ $user->id }}, $event.target.value)"
                                class="block w-full min-w-[140px] rounded-lg border-zinc-200 py-1.5 pl-3 pr-8 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            >
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" @selected($user->role_id === $role->id)>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </flux:table.cell>

                        <flux:table.cell>
                            @if($canManagePermissions)
                                <div class="flex flex-col gap-2 max-h-40 overflow-y-auto pr-2 rounded-md border border-zinc-100 p-2 dark:border-zinc-800/80 bg-zinc-50 dark:bg-zinc-800/30">
                                    @foreach($permissions as $permission)
                                        <flux:checkbox
                                            wire:change="togglePermission({{ $user->id }}, {{ $permission->id }}, $event.target.checked)"
                                            :checked="$user->permissions->contains('id', $permission->id)"
                                            label="{{ $permission->name }}"
                                            size="sm"
                                        />
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-zinc-400 italic">Permission নেই</span>
                            @endif
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="5" class="py-8 text-center text-zinc-500">
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
</div>
