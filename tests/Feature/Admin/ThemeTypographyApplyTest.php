<?php

use App\Models\Setting;
use App\Models\User;

it('applies saved typography settings to public frontend output', function () {
    Setting::query()->create([
        'key' => 'theme_options',
        'value' => json_encode([
            'primary_font' => 'Poppins',
            'font_weights' => '300;400;600',
            'body_font_size' => '17px',
            'autoload' => true,
        ], JSON_THROW_ON_ERROR),
        'group' => 'typography',
        'autoload' => true,
    ]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('family=Poppins:wght@300;400;600&display=swap', false);
    $response->assertSee('--app-body-font-size: 17px;', false);
});

it('applies saved typography settings to authenticated backend output', function () {
    Setting::query()->create([
        'key' => 'theme_options',
        'value' => json_encode([
            'primary_font' => 'Nunito',
            'font_weights' => '400;500;700',
            'body_font_size' => '18px',
            'autoload' => true,
        ], JSON_THROW_ON_ERROR),
        'group' => 'typography',
        'autoload' => true,
    ]);

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
    $response->assertSee('family=Nunito:wght@400;500;700&display=swap', false);
    $response->assertSee('--app-body-font-size: 18px;', false);
});
