<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UserRoleManagement extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $showEditModal = false;

    public ?int $editingUserId = null;

    public string $name = '';

    public string $email = '';

    public string $selectedRole = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function createUser(): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $this->editingUserId = null;
        $this->name = '';
        $this->email = '';
        $this->selectedRole = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetValidation();
        $this->showEditModal = true;
    }

    public function editUser(int $userId): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $targetUser = User::query()->findOrFail($userId);
        $this->editingUserId = $targetUser->id;
        $this->name = $targetUser->name;
        $this->email = $targetUser->email;
        $this->selectedRole = (string) $targetUser->roles()->value('id');
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetValidation();
        $this->showEditModal = true;
    }

    public function saveUser(): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', Rule::unique('users', 'email')->ignore($this->editingUserId)],
            'selectedRole' => ['required', 'exists:roles,id'],
        ];

        if ($this->editingUserId === null) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $validated = $this->validate($rules);

        $roleModel = Role::query()->findOrFail((int) $validated['selectedRole']);

        if ($this->editingUserId === null) {
            $createdUser = User::query()->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);
            $createdUser->syncRoles([$roleModel]);

            $this->showEditModal = false;
            $this->dispatch('entity-saved', message: 'User created successfully.');
            $this->reset(['name', 'email', 'selectedRole', 'password', 'password_confirmation']);

            return;
        }

        $targetUser = User::query()->findOrFail($this->editingUserId);

        if ($targetUser->id === auth()->id() && $roleModel->name !== 'super_admin') {
            $this->addError('role', 'নিজের Super Admin role নামানো যাবে না।');

            return;
        }

        $targetUser->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
        $targetUser->syncRoles([$roleModel]);

        $this->showEditModal = false;
        $this->dispatch('entity-saved', message: 'User updated successfully.');
        $this->reset(['password', 'password_confirmation']);
    }

    public function deleteUser(int $userId): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $targetUser = User::query()->findOrFail($userId);

        if ($targetUser->id === auth()->id()) {
            $this->addError('deleteUser', 'নিজের account delete করা যাবে না।');

            return;
        }

        $targetUser->syncPermissions([]);
        $targetUser->syncRoles([]);
        $targetUser->delete();

        $this->dispatch('entity-deleted', message: 'User deleted successfully.');
    }

    public function render(): View
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $users = User::query()
            ->with('roles')
            ->when($this->search !== '', function ($query): void {
                $searchTerm = '%'.$this->search.'%';
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.user-role-management', [
            'users' => $users,
            'roles' => Role::query()->orderBy('name')->get(),
        ])->layout('layouts.app', ['title' => 'User Management']);
    }
}
