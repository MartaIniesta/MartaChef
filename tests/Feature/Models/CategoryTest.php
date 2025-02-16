<?php

use Database\Seeders\CategorySeeder;
use App\Models\{Post, Category};

beforeEach(function () {
    $this->seed(CategorySeeder::class);
});

it('has posts', function () {
    // Arrange
    $category = Category::first();
    $posts = Post::factory()->count(3)->create();

    $category->posts()->attach($posts);

    $category->refresh();

    // Act & Assert
    expect($category->posts)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Post::class);
});
