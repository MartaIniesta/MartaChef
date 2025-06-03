<?php

use App\Livewire\Moderator\ModeratorUsers;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(LazilyRefreshDatabase::class);

/* Elimina un usuario y sus publicaciones */
it('soft deletes a user and their posts', function () {
    $user = User::factory()->hasPosts(3)->create();

    Livewire::test(ModeratorUsers::class)
        ->call('softDeleteUser', $user->id);

    assertSoftDeleted('users', ['id' => $user->id]);

    foreach ($user->posts as $post) {
        assertSoftDeleted('posts', ['id' => $post->id]);
    }
});

/* Restaura un usuario eliminado temporalmente y sus publicaciones */
it('restores a soft deleted user and their posts', function () {
    $user = User::factory()->hasPosts(2)->create();
    $user->posts()->delete();
    $user->delete();

    Livewire::test(ModeratorUsers::class)
        ->call('restoreUser', $user->id);

    assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);

    foreach ($user->posts as $post) {
        assertDatabaseHas('posts', ['id' => $post->id, 'deleted_at' => null]);
    }
});

/* Elimina a la fuerza a un usuario y sus publicaciones */
it('force deletes a user and their posts', function () {
    $user = User::factory()->hasPosts(2)->create();
    $user->posts()->delete();
    $user->delete();

    Livewire::test(ModeratorUsers::class)
        ->call('forceDeleteUser', $user->id);

    assertDatabaseMissing('users', ['id' => $user->id]);
    foreach ($user->posts as $post) {
        assertDatabaseMissing('posts', ['id' => $post->id]);
    }
});

/* Representa la vista del componente con los usuarios */
it('renders the component view with users', function () {
    Livewire::test(ModeratorUsers::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.moderator.moderator-users');
});
