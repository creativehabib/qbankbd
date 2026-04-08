<div class="space-y-6">
    <div>
        <flux:heading size="xl">User Role Management</flux:heading>
        <flux:subheading>Super Admin এখান থেকে user role assign/update করতে পারবে।</flux:subheading>
        <flux:separator class="my-6" />
    </div>

    <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="mb-4">
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Search by name or email"
                class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-500 focus:ring-indigo-500"
            />
        </div>

        @error('role')
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-600">
                {{ $message }}
            </div>
        @enderror

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b dark:border-gray-700">
                        <th class="py-2 text-left">Name</th>
                        <th class="py-2 text-left">Email</th>
                        <th class="py-2 text-left">Current Role</th>
                        <th class="py-2 text-left">Assign Role</th>
                        <th class="py-2 text-left">Direct Permissions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="py-3 font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</td>
                            <td class="py-3 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                            <td class="py-3">
                                <span class="rounded-full bg-indigo-100 px-2 py-1 text-xs font-medium text-indigo-700">
                                    {{ str($user->role)->replace('_', ' ')->title() }}
                                </span>
                            </td>
                            <td class="py-3">
                                <select
                                    wire:change="updateRole({{ $user->id }}, $event.target.value)"
                                    class="rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700"
                                >
                                    <option value="student" @selected($user->role === 'student')>Student</option>
                                    <option value="teacher" @selected($user->role === 'teacher')>Teacher</option>
                                    <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                    <option value="super_admin" @selected($user->role === 'super_admin')>Super Admin</option>
                                </select>
                            </td>
                            <td class="py-3">
                                @if($canManagePermissions)
                                    <div class="grid grid-cols-1 gap-1">
                                        @foreach($permissions as $permission)
                                            <label class="inline-flex items-center gap-2 text-xs">
                                                <input
                                                    type="checkbox"
                                                    @checked($user->permissions->contains('id', $permission->id))
                                                    wire:change="togglePermission({{ $user->id }}, {{ $permission->id }}, $event.target.checked)"
                                                    class="rounded border-gray-300 text-indigo-600"
                                                />
                                                <span>{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">Permission নেই</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="pt-4">{{ $users->links() }}</div>
        @endif
    </section>
</div>
