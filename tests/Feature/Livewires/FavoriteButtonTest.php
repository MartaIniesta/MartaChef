<?php

use App\Livewire\FavoriteButton;
use App\Models\{Favorite, Post, User};
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

/* Muestra el estado favorito inicial correcto */
it('shows correct initial favorite state', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    actingAs($user);

    Livewire::test(FavoriteButton::class, ['postId' => $post->id])
        ->assertSet('isFavorite', false);

    $user->favoritePosts()->attach($post->id);

    Livewire::test(FavoriteButton::class, ['postId' => $post->id])
        ->assertSet('isFavorite', true);
});

/* Puede activar y desactivar favoritos */
it('can toggle favorite on and off', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    actingAs($user);

    $component = Livewire::test(FavoriteButton::class, ['postId' => $post->id]);

    $component->call('toggleFavorite')
        ->assertSet('isFavorite', true);

    assertDatabaseHas('favorites', [
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    $component->call('toggleFavorite')
        ->assertSet('isFavorite', false);

    assertDatabaseMissing('favorites', [
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);
});
