<?php

use Database\Seeders\CategorySeeder;
use App\Models\{Post, Category, Rating, Tag, User, Comment};

beforeEach(function () {
    $this->seed(CategorySeeder::class);
});

it('belongs to a user', function () {
    // Arrange
    $post = Post::factory()->create();

    // Act & Assert
    expect($post->user)
        ->toBeInstanceOf(User::class);
});

it('has categories', function () {
    // Arrange
    $categories = Category::inRandomOrder()->take(4)->get();

    $post = Post::factory()->create();
    $post->categories()->attach($categories);
    $post->refresh();

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

it('has comments', function () {
    // Arrange
    $post = Post::factory()->create();
    $comments = Comment::factory()->count(3)
        ->create(['post_id' => $post->id]);

    // Act & Assert
    expect($post->comments)
    ->toHaveCount(3)
    ->each->toBeInstanceOf(Comment::class);
});

it('has ratings', function () {
    // Arrange
    $post = Post::factory()
        ->has(Rating::factory()->count(3), 'ratings')
        ->create();

    // Act & Assert
    expect($post->ratings)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Rating::class);
});

/* Recupera solo publicaciones públicas */
it('retrieves only public posts', function () {
    // Arrange
    $publicPost = Post::factory()->create(['visibility' => 'public']);
    Post::factory()->count(2)->create(['visibility' => 'private']);

    // Act
    $publicPosts = Post::visibilityPublic()->get();

    // Assert
    expect($publicPosts)
        ->toHaveCount(1)
        ->and($publicPosts->first()->id)->toBe($publicPost->id);
});

/* Recupera solo publicaciones privadas para el usuario. */
it('retrieves only private posts for the user', function () {
    // Arrange
    $user = User::factory()->create();
    $privatePost = Post::factory()->create(['visibility' => 'private', 'user_id' => $user->id]);

    Post::factory()->count(2)->create(['visibility' => 'private']);
    Post::factory()->count(2)->create(['visibility' => 'public']);

    // Act
    $privatePosts = Post::visibilityPrivate($user->id)->get();

    // Assert
    expect($privatePosts)
        ->toHaveCount(1)
        ->each->toBeInstanceOf(Post::class)
        ->and($privatePosts->first()->id)->toBe($privatePost->id);
});

/* Recupera solo publicaciones compartidas para un usuario. */
it('retrieves only shared posts for a user', function () {
    // Arrange
    $user = User::factory()->create();
    $author = User::factory()->create();

    $sharedPost = Post::factory()->create([
        'visibility' => 'shared',
        'user_id'   => $author->id,
    ]);

    $user->following()->attach($author);

    Post::factory()->create(['visibility' => 'shared']);
    Post::factory()->create(['visibility' => 'private']);
    Post::factory()->create(['visibility' => 'public']);

    // Act
    $sharedPosts = Post::visibilityShared($user->id)->get();

    // Assert
    expect($sharedPosts)
        ->toHaveCount(1)
        ->each->toBeInstanceOf(Post::class)
        ->and($sharedPosts->first()->id)->toBe($sharedPost->id);
});
