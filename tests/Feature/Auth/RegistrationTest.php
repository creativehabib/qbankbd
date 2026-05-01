<?php

use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyFeature(Features::registration());
});

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'registration_role' => 'student',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('teacher registration requires institution information', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Teacher User',
        'email' => 'teacher@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'registration_role' => 'teacher',
    ]);

    $response->assertSessionHasErrors(['institution_name', 'institution_type', 'institution_address']);
});
