<?php


use App\Models\{User, Post};

it('has posts', function () {
    // Arrange
    $user = User::factory()
        ->has(Post::factory()->count(2), 'posts')
        ->create();

    // Act & Assert
    expect($user->posts)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Post::class);
});
