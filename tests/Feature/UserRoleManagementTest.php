<?php

use App\Livewire\UserRoleManagement;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;

it('super admin can access user role management page', function () {
    $superAdmin = User::factory()->superAdmin()->create();

    $this->actingAs($superAdmin)
        ->get(route('user-roles.index'))
        ->assertOk();
});

it('non super admin cannot access user role management page', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('user-roles.index'))
        ->assertForbidden();
});

it('user with direct manage roles permission can access user role page', function () {
    $admin = User::factory()->admin()->create();
    $permission = Permission::query()->where('slug', 'users.manage_roles')->firstOrFail();
    $admin->permissions()->syncWithoutDetaching([$permission->id]);

    $this->actingAs($admin)
        ->get(route('user-roles.index'))
        ->assertOk();
});

it('super admin can assign role to another user', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $targetUser = User::factory()->create(['role' => 'student']);
    $teacherRoleId = Role::query()->where('slug', 'teacher')->value('id');

    Livewire::actingAs($superAdmin)
        ->test(UserRoleManagement::class)
        ->call('updateRole', $targetUser->id, (string) $teacherRoleId)
        ->assertHasNoErrors();

    expect($targetUser->fresh()->role)->toBe('teacher');
});

it('super admin can assign direct permissions to user', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $targetUser = User::factory()->create(['role' => 'student']);
    $permissionId = \App\Models\Permission::query()->where('slug', 'questions.publish')->value('id');

    Livewire::actingAs($superAdmin)
        ->test(UserRoleManagement::class)
        ->call('togglePermission', $targetUser->id, $permissionId, true)
        ->assertHasNoErrors();

    expect($targetUser->fresh()->hasPermission('questions.publish'))->toBeTrue();
});

it('super admin cannot demote own role', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $adminRoleId = Role::query()->where('slug', 'admin')->value('id');

    Livewire::actingAs($superAdmin)
        ->test(UserRoleManagement::class)
        ->call('updateRole', $superAdmin->id, (string) $adminRoleId)
        ->assertHasErrors('role');

    expect($superAdmin->fresh()->role)->toBe('super_admin');
});
