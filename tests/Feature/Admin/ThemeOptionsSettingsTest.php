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

it('stores typography settings as separate keys with autoload flag', function () {
    $superAdmin = User::factory()->superAdmin()->create();

    Livewire::actingAs($superAdmin)
        ->test(ThemeOptions::class)
        ->set('primaryFont', 'Poppins')
        ->set('fontWeights', '300;400;500;600;700')
        ->set('bodyFontSize', '16px')
        ->set('autoload', true)
        ->call('save')
        ->assertHasNoErrors();

    $primaryFont = Setting::query()->where('group', 'typography')->where('key', 'primary_font')->first();
    $fontWeights = Setting::query()->where('group', 'typography')->where('key', 'primary_font_weights')->first();
    $bodyFontSize = Setting::query()->where('group', 'typography')->where('key', 'body_font_size')->first();

    expect($primaryFont?->value)->toBe('Poppins');
    expect($fontWeights?->value)->toBe('300;400;500;600;700');
    expect($bodyFontSize?->value)->toBe('16px');
    expect($primaryFont?->autoload)->toBeTrue();
});
