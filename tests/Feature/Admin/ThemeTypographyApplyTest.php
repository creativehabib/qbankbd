<?php

use App\Models\Setting;
use App\Models\User;

it('applies saved typography settings to public frontend output', function () {
    Setting::query()->create(['key' => 'primary_font', 'value' => 'Poppins', 'group' => 'typography', 'autoload' => true]);
    Setting::query()->create(['key' => 'primary_font_weights', 'value' => '300;400;600', 'group' => 'typography', 'autoload' => true]);
    Setting::query()->create(['key' => 'body_font_size', 'value' => '17px', 'group' => 'typography', 'autoload' => true]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('family=Poppins:wght@300;400;600&display=swap', false);
    $response->assertSee('--body-font-size: 17px;', false);
});

it('applies saved typography settings to authenticated backend output', function () {
    Setting::query()->create(['key' => 'primary_font', 'value' => 'Nunito', 'group' => 'typography', 'autoload' => true]);
    Setting::query()->create(['key' => 'primary_font_weights', 'value' => '400;500;700', 'group' => 'typography', 'autoload' => true]);
    Setting::query()->create(['key' => 'body_font_size', 'value' => '18px', 'group' => 'typography', 'autoload' => true]);

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
    $response->assertSee('family=Nunito:wght@400;500;700&display=swap', false);
    $response->assertSee('--body-font-size: 18px;', false);
});
