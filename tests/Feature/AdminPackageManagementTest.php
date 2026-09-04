<?php

use App\Livewire\Admin\PackageManagement;
use App\Models\Package;
use App\Models\User;
use Livewire\Livewire;

it('admin can create update and delete package', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(['super_admin']);

    $this->actingAs($admin);

    Livewire::test(PackageManagement::class)
        ->set('name', 'Custom Plan')
        ->set('price', '4500')
        ->set('questionCreateLimit', '4000')
        ->set('pageViewLimit', '0')
        ->set('validityDays', '45')
        ->set('isAdFree', true)
        ->set('isActive', true)
        ->call('save')
        ->assertHasNoErrors();

    $package = Package::query()->where('name', 'Custom Plan')->firstOrFail();

    Livewire::test(PackageManagement::class)
        ->call('edit', $package->id)
        ->set('price', '5000')
        ->call('save')
        ->assertHasNoErrors();

    expect((float) $package->fresh()->price)->toBe(5000.0);

    Livewire::test(PackageManagement::class)
        ->call('delete', $package->id);

    expect(Package::query()->whereKey($package->id)->exists())->toBeFalse();
});

it('package management uses Flux UI controls', function () {
    $view = file_get_contents(base_path('resources/views/livewire/admin/package-management.blade.php'));

    expect($view)
        ->toContain('<flux:field')
        ->toContain('<flux:input')
        ->toContain('<flux:checkbox')
        ->toContain('<flux:button');
});
