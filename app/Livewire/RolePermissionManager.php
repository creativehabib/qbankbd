<?php

namespace App\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

class RolePermissionManager extends Component
{
    public bool $showModal = false;

    public ?int $editingRoleId = null;

    public string $roleName = '';

    /** @var array<int> */
    public array $selectedPermissions = [];


    public function createRole(): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_permissions'), 403);

        $this->editingRoleId = null;
        $this->roleName = '';
        $this->selectedPermissions = [];
        $this->resetValidation();
        $this->showModal = true;
    }

    public function editRole(int $roleId): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_permissions'), 403);

        $role = Role::query()->findOrFail($roleId);

        $this->editingRoleId = $role->id;
        $this->roleName = $role->name;
        $this->selectedPermissions = $role->permissions()->pluck('permissions.id')->map(fn ($id) => (int) $id)->all();
        $this->resetValidation();
        $this->showModal = true;
    }

    public function saveRole(): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_permissions'), 403);

        $validated = $this->validate([
            'roleName' => ['required', 'string', 'max:255'],
            'selectedPermissions' => ['array'],
            'selectedPermissions.*' => ['exists:permissions,id'],
        ]);

        $slug = Str::slug($validated['roleName'], '_');

        $role = Role::query()->updateOrCreate(
            ['id' => $this->editingRoleId],
            [
                'name' => $validated['roleName'],
                'slug' => $this->editingRoleId ? Role::query()->find($this->editingRoleId)?->slug : $slug,
                'guard' => 'web',
            ]
        );

        Role::query()->whereKey($role->id)->update(['slug' => $role->slug ?: $slug]);

        $role->permissions()->sync($validated['selectedPermissions'] ?? []);

        $this->dispatch('entity-saved', message: 'Role saved successfully.');
        $this->showModal = false;
    }

    public function deleteRole(int $roleId): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_permissions'), 403);

        $role = Role::query()->findOrFail($roleId);

        if (in_array($role->slug, ['student', 'teacher', 'admin', 'super_admin'], true)) {
            $this->addError('roleName', 'Default role delete করা যাবে না।');

            return;
        }

        $role->permissions()->detach();
        $role->delete();

        $this->dispatch('entity-deleted', message: 'Role deleted successfully.');
    }

    public function render(): View
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_permissions'), 403);

        $permissions = Permission::query()->orderBy('slug')->get();

        return view('livewire.role-permission-manager', [
            'roles' => Role::query()->with('permissions')->orderBy('name')->get(),
            'permissions' => $permissions,
            'groupedPermissions' => $permissions->groupBy(function (Permission $permission): string {
                return (string) str($permission->slug)->before('.');
            }),
        ])->layout('layouts.app', ['title' => 'Roles & Permissions']);
    }

    public function toggleAllPermissions(bool $selected): void
    {
        if ($selected) {
            $this->selectedPermissions = Permission::query()->pluck('id')->map(fn ($id) => (int) $id)->all();

            return;
        }

        $this->selectedPermissions = [];
    }
}
