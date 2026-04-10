<?php

use App\Livewire\Tags\Index as TagIndex;
use App\Models\Tag;
use App\Models\User;
use Livewire\Livewire;

it('allows user with tag permissions to access tags page', function () {
    $teacher = User::factory()->teacher()->create();

    $this->actingAs($teacher)
        ->get(route('tags.index'))
        ->assertOk();
});

it('forbids user without tag permissions from accessing tags page', function () {
    $student = User::factory()->create();

    $this->actingAs($student)
        ->get(route('tags.index'))
        ->assertForbidden();
});

it('allows user with tags.create permission to create a tag', function () {
    $teacher = User::factory()->teacher()->create();

    Livewire::actingAs($teacher)
        ->test(TagIndex::class)
        ->set('name', 'Physics')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('tags', ['name' => 'Physics']);
});

it('forbids tag creation without tags.create permission', function () {
    $student = User::factory()->create();

    Livewire::actingAs($student)
        ->test(TagIndex::class)
        ->set('name', 'Unauthorized Tag')
        ->call('save')
        ->assertForbidden();
});

it('allows user with tags.update permission to update a tag', function () {
    $teacher = User::factory()->teacher()->create();
    $tag = Tag::query()->create(['name' => 'Old Tag']);

    Livewire::actingAs($teacher)
        ->test(TagIndex::class)
        ->call('edit', $tag->id)
        ->set('editingName', 'Updated Tag')
        ->call('update')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('tags', ['id' => $tag->id, 'name' => 'Updated Tag']);
});

it('allows user with tags.delete permission to delete a tag', function () {
    $teacher = User::factory()->teacher()->create();
    $tag = Tag::query()->create(['name' => 'Delete Me']);

    Livewire::actingAs($teacher)
        ->test(TagIndex::class)
        ->call('delete', $tag->id)
        ->assertHasNoErrors();

    $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
});
