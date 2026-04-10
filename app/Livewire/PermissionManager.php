<?php

namespace App\Livewire;

use App\Models\Permission;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\PermissionRegistrar;

class PermissionManager extends Component
{
    public bool $showModal = false;

    public ?int $editingPermissionId = null;

    public string $name = '';

    public string $slug = '';

    public function createPermission(): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_permissions'), 403);

        $this->editingPermissionId = null;
        $this->name = '';
        $this->slug = '';
        $this->resetValidation();
        $this->showModal = true;
    }

    public function editPermission(int $permissionId): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_permissions'), 403);

        $permission = Permission::query()->findOrFail($permissionId);

        $this->editingPermissionId = $permission->id;
        $this->name = Str::of($permission->name)->replace('.', ' ')->title()->value();
        $this->slug = $permission->name;
        $this->resetValidation();
        $this->showModal = true;
    }

    public function savePermission(): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_permissions'), 403);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:permissions,name,'.($this->editingPermissionId ?? 'null')],
        ]);

        Permission::query()->updateOrCreate(
            ['id' => $this->editingPermissionId],
            [
                'name' => Str::of($validated['slug'])->lower()->replace(' ', '.')->value(),
                'guard_name' => 'web',
            ]
        );

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->showModal = false;
        $this->dispatch('entity-saved', message: 'Permission saved successfully.');
    }

    public function deletePermission(int $permissionId): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_permissions'), 403);

        $permission = Permission::query()->findOrFail($permissionId);
        $permission->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->dispatch('entity-deleted', message: 'Permission deleted successfully.');
    }

    public function render(): View
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_permissions'), 403);

        $permissions = Permission::query()->orderBy('name')->get();

        return view('livewire.permission-manager', [
            'permissions' => $permissions,
        ])->layout('layouts.app', ['title' => 'Permissions']);
    }
}
