<?php

use App\Livewire\RolePermissionManager;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;

it('stores legacy role slug when syncing role permissions', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $permissionIds = Permission::query()
        ->whereIn('slug', ['questions.read', 'questions.create'])
        ->pluck('id')
        ->all();

    Livewire::actingAs($superAdmin)
        ->test(RolePermissionManager::class)
        ->set('roleName', 'Content Reviewer')
        ->set('selectedPermissions', $permissionIds)
        ->call('saveRole')
        ->assertHasNoErrors();

    $role = Role::query()->where('name', 'Content Reviewer')->firstOrFail();

    foreach ($permissionIds as $permissionId) {
        $this->assertDatabaseHas('role_permissions', [
            'role_id' => $role->id,
            'permission_id' => $permissionId,
            'role' => $role->slug,
        ]);
    }
});
