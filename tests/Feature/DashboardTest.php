<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('student sees student dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Student Panel');
});

test('teacher sees teacher dashboard', function () {
    $user = User::factory()->teacher()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Teacher Panel');
});

test('admin sees admin dashboard', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Admin Panel');
});

test('super admin sees super admin dashboard', function () {
    $user = User::factory()->superAdmin()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Super Admin Panel');
});


test('dashboard renders custom non flux sidebar shell', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('data-test="desktop-sidebar"', false)
        ->assertSee('data-test="sidebar-nav"', false)
        ->assertSee('data-test="sidebar-collapse-button"', false)
        ->assertSee('data-test="sidebar-flyout-panel"', false)
        ->assertSee('data-test="mobile-sidebar-trigger"', false)
        ->assertSee('প্রশ্ন ভান্ডার')
        ->assertSee('Question Create')
        ->assertSee('data-test="sticky-page-header"', false)
        ->assertSee('data-test="profile-dropdown-button"', false)
        ->assertSee('data-test="theme-toggle-button"', false)
        ->assertSee('data-test="collapsed-profile-menu-button"', false)
        ->assertSee('data-test="collapsed-profile-menu-panel"', false)
        ->assertSee('data-test="page-loading-overlay"', false);
});

use App\Models\QuestionSet;

test('super admin dashboard shows question set creator summary', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $teacher = User::factory()->teacher()->create(['name' => 'Teacher One']);

    QuestionSet::create([
        'name' => 'Set A',
        'user_id' => $teacher->id,
        'generation_criteria' => ['type' => 'mcq', 'quantity' => 20],
    ]);

    $this->actingAs($superAdmin)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Teacher One')
        ->assertSee('MCQ: 1')
        ->assertSee('20');
});

test('super admin can update and delete question set from dashboard', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $teacher = User::factory()->teacher()->create();

    $questionSet = QuestionSet::create([
        'name' => 'Old Name',
        'user_id' => $teacher->id,
        'generation_criteria' => ['type' => 'mcq', 'quantity' => 10],
    ]);

    $this->actingAs($superAdmin)
        ->patch(route('dashboard.question-sets.update', $questionSet), [
            'name' => 'New Name',
            'type' => 'cq',
            'quantity' => 15,
        ])
        ->assertRedirect();

    $questionSet->refresh();
    expect($questionSet->name)->toBe('New Name');
    expect($questionSet->generation_criteria['type'])->toBe('cq');
    expect($questionSet->generation_criteria['quantity'])->toBe(15);

    $this->actingAs($superAdmin)
        ->delete(route('dashboard.question-sets.destroy', $questionSet))
        ->assertRedirect();

    $this->assertDatabaseMissing('question_sets', ['id' => $questionSet->id]);
});
