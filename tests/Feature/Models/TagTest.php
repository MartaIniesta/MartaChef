<?php

use App\Models\{Post, Tag};

it('has posts', function () {
    // Arrange
    $tag = Tag::factory()
        ->has(Post::factory(), 'posts')
        ->create();

    // Act & Assert
    expect($tag->posts)
        ->each->toBeInstanceOf(Post::class);
});
