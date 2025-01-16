<?php

use App\Models\{Post, Category, Tag};

it('has categories', function () {
    // Arrange
    $post = Post::factory()
        ->has(Category::factory()->count(4), 'categories')
        ->create();

    // Act & Assert
    expect($post->categories)
        ->toHaveCount(4)
        ->each->toBeInstanceOf(Category::class);
});

it('has tags', function () {
    // Arrange
    $post = Post::factory()
        ->has(Tag::factory()->count(10), 'tags')
        ->create();

    // Act & Assert
    expect($post->tags)
        ->toHaveCount(10)
        ->each->toBeInstanceOf(Tag::class);
});
