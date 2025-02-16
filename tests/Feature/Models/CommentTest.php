<?php

use App\Models\{Comment, Post, User};

it('belongs to a post', function () {
    // Arrange
    $post = Post::factory()->create();
    $comment = Comment::factory()->create(['post_id' => $post->id]);

    // Act & Assert
    expect($comment->post)
        ->toBeInstanceOf(Post::class)
        ->and($comment->post->id)->toBe($post->id);
});

it('belongs to a user', function () {
    // Arrange
    $user = User::factory()->create();
    $comment = Comment::factory()->create(['user_id' => $user->id]);

    // Act & Assert
    expect($comment->user)
        ->toBeInstanceOf(User::class)
        ->and($comment->user->id)->toBe($user->id);
});

/* Comprueba que un comentario puede ser respuesta de otro */
it('can have a parent comment', function () {
    // Arrange
    $parentComment = Comment::factory()->create();
    $reply = Comment::factory()->create(['parent_id' => $parentComment->id]);

    // Act & Assert
    expect($reply->parent)
        ->toBeInstanceOf(Comment::class)
        ->and($reply->parent->id)->toBe($parentComment->id);
});

/* Asegura que un comentario puede tener varias respuestas */
it('can have multiple replies', function () {
    // Arrange
    $parentComment = Comment::factory()->create();
    $replies = Comment::factory()->count(3)->create(['parent_id' => $parentComment->id]);

    // Act & Assert
    expect($parentComment->replies)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Comment::class);
});
