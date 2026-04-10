<?php

use App\Livewire\UserRoleManagement;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;

it('super admin can access user role management page', function () {
    $superAdmin = User::factory()->superAdmin()->create();

    $this->actingAs($superAdmin)
        ->get(route('users.index'))
        ->assertOk();
});

it('non super admin cannot access user role management page', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('users.index'))
        ->assertForbidden();
});

it('user with direct manage roles permission can access user role page', function () {
    $admin = User::factory()->admin()->create();
    $permission = Permission::query()->where('name', 'users.manage_roles')->firstOrFail();
    $admin->givePermissionTo($permission);

    $this->actingAs($admin)
        ->get(route('users.index'))
        ->assertOk();
});

it('super admin can assign role to another user', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $targetUser = User::factory()->create();
    $teacherRoleId = Role::query()->where('name', 'teacher')->value('id');

    Livewire::actingAs($superAdmin)
        ->test(UserRoleManagement::class)
        ->call('editUser', $targetUser->id)
        ->set('selectedRole', (string) $teacherRoleId)
        ->set('name', $targetUser->name)
        ->set('email', $targetUser->email)
        ->call('saveUser')
        ->assertHasNoErrors();

    expect($targetUser->fresh()->hasRole('teacher'))->toBeTrue();
});

it('super admin can create a new user', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $teacherRoleId = Role::query()->where('name', 'teacher')->value('id');

    Livewire::actingAs($superAdmin)
        ->test(UserRoleManagement::class)
        ->call('createUser')
        ->set('name', 'Created User')
        ->set('email', 'created-user@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('selectedRole', (string) $teacherRoleId)
        ->call('saveUser')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', [
        'name' => 'Created User',
        'email' => 'created-user@example.com',
    ]);
});

it('super admin can edit user profile details', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $targetUser = User::factory()->create([
        'email' => 'student@example.com',
    ]);
    $adminRoleId = Role::query()->where('name', 'admin')->value('id');

    Livewire::actingAs($superAdmin)
        ->test(UserRoleManagement::class)
        ->call('editUser', $targetUser->id)
        ->set('name', 'Updated User')
        ->set('email', 'updated-user@example.com')
        ->set('selectedRole', (string) $adminRoleId)
        ->call('saveUser')
        ->assertHasNoErrors();

    expect($targetUser->fresh())
        ->name->toBe('Updated User')
        ->email->toBe('updated-user@example.com');

    expect($targetUser->fresh()->hasRole('admin'))->toBeTrue();
});

it('super admin can delete another user', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $targetUser = User::factory()->create();

    Livewire::actingAs($superAdmin)
        ->test(UserRoleManagement::class)
        ->call('deleteUser', $targetUser->id)
        ->assertHasNoErrors();

    $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
});

it('super admin cannot demote own role', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $adminRoleId = Role::query()->where('name', 'admin')->value('id');

    Livewire::actingAs($superAdmin)
        ->test(UserRoleManagement::class)
        ->call('editUser', $superAdmin->id)
        ->set('selectedRole', (string) $adminRoleId)
        ->set('name', $superAdmin->name)
        ->set('email', $superAdmin->email)
        ->call('saveUser')
        ->assertHasErrors('role');

    expect($superAdmin->fresh()->hasRole('super_admin'))->toBeTrue();
});

it('user management page does not show direct permissions column', function () {
    $superAdmin = User::factory()->superAdmin()->create();

    $this->actingAs($superAdmin)
        ->get(route('users.index'))
        ->assertSee('Create User')
        ->assertSee('ACTIONS')
        ->assertDontSee('DIRECT PERMISSIONS');
});
