<?php

use Database\Seeders\RolesSeeder;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\{Post, Rating, User};
use Illuminate\Support\Facades\Gate;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

it('belongs to a post', function () {
    // Arrange
    $post = Post::factory()->create();
    $rating = Rating::factory()->create(['post_id' => $post->id]);

    // Act & Assert
    expect($rating->post)
        ->toBeInstanceOf(Post::class)
        ->and($rating->post->id)->toBe($post->id);
});

it('belongs to a user', function () {
    // Arrange
    $user = User::factory()->create();
    $rating = Rating::factory()->create(['user_id' => $user->id]);

    // Act & Assert
    expect($rating->user)
        ->toBeInstanceOf(User::class)
        ->and($rating->user->id)->toBe($user->id);
});

/* No puede calificar su propia publicación */
it('cannot rate their own post', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $user->givePermissionTo('rate-posts');
    loginAsUser($user);

    $rating = Rating::factory()->make(['user_id' => $user->id, 'post_id' => $post->id]);

    // Act & Assert
    $this->expectException(AuthorizationException::class);
    Gate::forUser($user)->authorize('rate', $post);

    $rating->save();
});

/* Puede calificar la publicación de otro usuario */
it('can rate another users post', function () {
    // Arrange
    $user = User::factory()->create();
    $user->givePermissionTo('rate-posts');
    loginAsUser($user);

    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $otherUser->id]);

    // Act
    $rating = Rating::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    // Assert
    expect($rating->user_id)->toBe($user->id);
});

/* No se pueden calificar publicaciones sin el permiso de calificar publicaciones. */
it('cannot rate posts without rate-posts permission', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create();

    loginAsUser($user);

    // Act & Assert
    $this->expectException(AuthorizationException::class);

    Gate::forUser($user)->authorize('rate', $post);

    Rating::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'rating' => 4,
    ]);
});

/* Calcula la calificación promedio correctamente */
it('calculates the average rating correctly', function () {
    // Arrange
    $post = Post::factory()->create();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    loginAsUser($user1);

    // Act
    Rating::factory()->create(['user_id' => $user1->id, 'post_id' => $post->id, 'rating' => 3]);
    Rating::factory()->create(['user_id' => $user2->id, 'post_id' => $post->id, 'rating' => 5]);

    // Assert
    $averageRating = Rating::where('post_id', $post->id)->avg('rating');
    expect($averageRating)->toEqual(4.0);
});
