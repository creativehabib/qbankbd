<?php

namespace App\Livewire;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UserRoleManagement extends Component
{
    use InteractsWithFluxToasts;
    use WithPagination;

    public string $search = '';

    public int $perPage = 10;

    public string $sortOrder = 'default';

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
    
    public function updatingSortOrder(): void
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
        $this->toastSuccess('User created successfully.');
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
        $this->toastSuccess('User updated successfully.');
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
        $this->toastSuccess('User deleted successfully.');
    }

    public function toggleStatus(int $userId): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $targetUser = User::query()->findOrFail($userId);

        if ($targetUser->id === auth()->id()) {
            $this->toastError('নিজের account inactive করা যাবে না।');
            return;
        }

        $targetUser->is_active = !$targetUser->is_active;
        $targetUser->save();

        $this->toastSuccess('User status updated successfully.');
    }

    public function signOutEverywhere(int $userId): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $targetUser = User::query()->findOrFail($userId);

        if (config('session.driver') === 'database') {
            \Illuminate\Support\Facades\DB::table('sessions')->where('user_id', $targetUser->id)->delete();
        }
        
        // Also update remember_token to log them out of "remember me"
        $targetUser->update(['remember_token' => null]);

        $this->toastSuccess('User has been signed out from all devices.');
    }

    public function render(): View
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $query = User::query()
            ->with('roles')
            ->when($this->search !== '', function ($query): void {
                $searchTerm = '%'.$this->search.'%';
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm);
            });
            
        match ($this->sortOrder) {
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'id_asc' => $query->orderBy('id', 'asc'),
            'id_desc' => $query->orderBy('id', 'desc'),
            default => $query->latest(),
        };

        $users = $query->paginate($this->perPage);

        return view('livewire.user-role-management', [
            'users' => $users,
            'roles' => Role::query()->orderBy('name')->get(),
        ])->layout('layouts.app', ['title' => 'User Management']);
    }
}
