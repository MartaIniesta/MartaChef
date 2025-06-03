<?php

use App\Livewire\PostRating;
use Database\Seeders\RolesSeeder;
use App\Models\{User, Post, Rating};
use Livewire\Livewire;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

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

/* Autoriza al usuario con permiso para calificar la publicación */
it('authorizes user with permission to rate post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => User::factory()->create()->id,
        'visibility' => 'public',
    ]);

    $user->givePermissionTo('rate-posts');

    actingAs($user);

    Livewire::test(PostRating::class, ['post' => $post])
        ->call('rate', 4)
        ->assertSet('userRating', 4);
});

/* No autoriza al usuario sin permiso a calificar la publicación */
it('does not authorize user without permission to rate post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    actingAs($user);

    Livewire::test(PostRating::class, ['post' => $post])
        ->call('rate', 4)
        ->assertForbidden();
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
