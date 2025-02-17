<?php

use App\Livewire\PostRating;
use App\Models\{User, Post, Rating};
use Livewire\Livewire;

/* Se inicializa correctamente con la calificación del usuario y la calificación promedio */
it('initializes correctly with user rating and average rating', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create();
    Rating::factory()->create(['post_id' => $post->id, 'user_id' => $user->id, 'rating' => 4]);

    // Act
    loginAsUser($user);
    Livewire::test(PostRating::class, ['post' => $post])
        ->assertSet('userRating', 4)
        ->assertSet('averageRating', 4);
});

/* Verificar permisos de calificación */
it('checks if user is authorized to rate the post', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create();

    // Act
    loginAsUser($user);
    $component = Livewire::test(PostRating::class, ['post' => $post]);

    $component->call('rate', 4);

    // Assert
    $component->assertForbidden();
});

/* Muestra la vista correcta del componente */
it('shows correct view for the component', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create();

    // Act & Assert
    loginAsUser($user);
    Livewire::test(PostRating::class, ['post' => $post])
        ->assertViewIs('livewire.post-rating');
});
