<?php

use App\Models\{Post, Rating, User};

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
