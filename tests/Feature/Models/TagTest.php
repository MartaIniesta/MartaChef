<?php

use App\Models\{Post, Tag};

it('has posts', function () {
    // Arrange
    $tag = Tag::factory()->create();
    $posts = Post::factory()->count(3)->create();

    $tag->posts()->attach($posts);

    $tag->refresh();

    // Act & Assert
    expect($tag->posts)
        ->each->toBeInstanceOf(Post::class);
});
