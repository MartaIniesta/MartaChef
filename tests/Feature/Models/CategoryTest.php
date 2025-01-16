<?php

use App\Models\{Post, Category};

it('has posts', function () {
    // Arrange
    $category = Category::factory()
        ->has(Post::factory(), 'posts')
        ->create();

    // Act & Assert
    expect($category->posts)
        ->each->toBeInstanceOf(Post::class);
});
