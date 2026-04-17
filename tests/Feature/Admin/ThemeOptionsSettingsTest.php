<?php

use App\Livewire\Admin\Settings\ThemeOptions;
use App\Models\Setting;
use App\Models\User;
use Livewire\Livewire;

it('authorized users can access theme options page', function () {
    $superAdmin = User::factory()->superAdmin()->create();

    $this->actingAs($superAdmin)
        ->get(route('admin.theme-options'))
        ->assertOk();
});

it('stores typography settings as grouped json with autoload flag', function () {
    $superAdmin = User::factory()->superAdmin()->create();

    Livewire::actingAs($superAdmin)
        ->test(ThemeOptions::class)
        ->set('primaryFont', 'Poppins')
        ->set('fontWeights', '300;400;500;600;700')
        ->set('bodyFontSize', '16px')
        ->set('autoload', true)
        ->call('save')
        ->assertHasNoErrors();

    $setting = Setting::query()
        ->where('group', 'typography')
        ->where('key', 'theme_options')
        ->first();

    expect($setting)->not()->toBeNull();
    expect($setting?->autoload)->toBeTrue();

    $value = json_decode((string) $setting?->value, true);

    expect($value)->toBeArray();
    expect($value['primary_font'])->toBe('Poppins');
    expect($value['body_font_size'])->toBe('16px');
});
