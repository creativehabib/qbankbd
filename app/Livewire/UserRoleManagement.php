<?php

namespace App\Livewire;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class UserRoleManagement extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updateRole(int $userId, string $role): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $targetUser = User::query()->findOrFail($userId);
        $roleModel = Role::query()->findOrFail((int) $role);

        if ($targetUser->id === auth()->id() && $roleModel->slug !== 'super_admin') {
            $this->addError('role', 'নিজের Super Admin role নামানো যাবে না।');

            return;
        }

        $targetUser->update([
            'role' => $roleModel->slug,
            'role_id' => $roleModel->id,
        ]);

        $this->dispatch('entity-saved', message: 'User role updated successfully.');
    }

    public function togglePermission(int $userId, int $permissionId, bool $enabled): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_permissions'), 403);

        $targetUser = User::query()->findOrFail($userId);

        if ($enabled) {
            $targetUser->permissions()->syncWithoutDetaching([$permissionId]);
        } else {
            $targetUser->permissions()->detach($permissionId);
        }
    }

    public function render(): View
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $users = User::query()
            ->when($this->search !== '', function ($query): void {
                $searchTerm = '%'.$this->search.'%';
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm);
            })
            ->with('permissions:id')
            ->latest()
            ->paginate(10);

        return view('livewire.user-role-management', [
            'users' => $users,
            'permissions' => Permission::query()->orderBy('name')->get(),
            'roles' => Role::query()->orderBy('name')->get(),
            'canManagePermissions' => auth()->user()?->hasPermission('users.manage_permissions') ?? false,
        ])->layout('layouts.app', ['title' => 'User Management']);
    }
}
