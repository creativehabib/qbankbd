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

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function editUser(int $userId): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $targetUser = User::query()->findOrFail($userId);
        $this->editingUserId = $targetUser->id;
        $this->name = $targetUser->name;
        $this->email = $targetUser->email;
        $this->selectedRole = (string) $targetUser->role_id;
        $this->resetValidation();
        $this->showEditModal = true;
    }

    public function saveUser(): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        if ($this->editingUserId === null) {
            return;
        }

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', Rule::unique('users', 'email')->ignore($this->editingUserId)],
            'selectedRole' => ['required', 'exists:roles,id'],
        ]);

        $targetUser = User::query()->findOrFail($this->editingUserId);
        $roleModel = Role::query()->findOrFail((int) $validated['selectedRole']);

        if ($targetUser->id === auth()->id() && $roleModel->slug !== 'super_admin') {
            $this->addError('role', 'নিজের Super Admin role নামানো যাবে না।');

            return;
        }

        $targetUser->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $roleModel->slug,
            'role_id' => $roleModel->id,
        ]);

        $this->showEditModal = false;
        $this->dispatch('entity-saved', message: 'User updated successfully.');
    }

    public function deleteUser(int $userId): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $targetUser = User::query()->findOrFail($userId);

        if ($targetUser->id === auth()->id()) {
            $this->addError('deleteUser', 'নিজের account delete করা যাবে না।');

            return;
        }

        $targetUser->permissions()->detach();
        $targetUser->delete();

        $this->dispatch('entity-deleted', message: 'User deleted successfully.');
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
            ->latest()
            ->paginate(10);

        return view('livewire.user-role-management', [
            'users' => $users,
            'roles' => Role::query()->orderBy('name')->get(),
        ])->layout('layouts.app', ['title' => 'User Management']);
    }
}
