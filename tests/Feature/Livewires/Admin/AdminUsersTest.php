<?php

use App\Livewire\Admin\AdminUsers;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

/* Valida y actualiza el rol del usuario */
it('validates and updates user role', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    Livewire::test(AdminUsers::class)
        ->set("roles.{$user->id}", 'admin')
        ->call('updateRole', $user->id);

    expect($user->fresh()->hasRole('admin'))->toBeTrue();
});

/* Genera un error de validación en una actualización de rol no válida */
it('throws validation error on invalid role update', function () {
    $user = User::factory()->create();

    Livewire::test(AdminUsers::class)
        ->set("roles.{$user->id}", 'invalidrole')
        ->call('updateRole', $user->id)
        ->assertHasErrors(["roles.{$user->id}" => 'in']);
});

/* Eliminación suave del usuario y sus publicaciones */
it('soft deletes user and their posts', function () {
    $user = User::factory()->create();
    $post = $user->posts()->create([
        'title' => 'Test post',
        'description' => 'desc',
        'ingredients' => 'ings',
        'image' => 'image.png',
        'visibility' => 'public',
    ]);

    Livewire::test(AdminUsers::class)
        ->call('softDeleteUser', $user->id);

    expect($user->fresh()->trashed())->toBeTrue()
        ->and($post->fresh()->trashed())->toBeTrue();
});

/* Restaura al usuario y sus publicaciones */
it('restores user and their posts', function () {
    $user = User::factory()->create();
    $post = $user->posts()->create([
        'title' => 'Test post',
        'description' => 'desc',
        'ingredients' => 'ings',
        'image' => 'image.png',
        'visibility' => 'public',
    ]);

    $user->delete();
    $post->delete();

    Livewire::test(AdminUsers::class)
        ->call('restoreUser', $user->id);

    expect($user->fresh()->trashed())->toBeFalse()
        ->and($post->fresh()->trashed())->toBeFalse();
});

/* Elimina permanentemente al usuario y sus publicaciones */
it('force deletes user and their posts', function () {
    $user = User::factory()->create();
    $post = $user->posts()->create([
        'title' => 'Test post',
        'description' => 'desc',
        'ingredients' => 'ings',
        'image' => 'image.png',
        'visibility' => 'public',
    ]);

    $user->delete();
    $post->delete();

    Livewire::test(AdminUsers::class)
        ->call('forceDeleteUser', $user->id);

    expect(User::withTrashed()->find($user->id))->toBeNull()
        ->and($post->fresh())->toBeNull();
});
