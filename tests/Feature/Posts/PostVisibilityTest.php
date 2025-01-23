<?php


use App\Models\{Post, User};
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

/* Verifica que los posts privados son accesibles solo por su propietario y no por otros usuarios */
it('private posts are only accessible to their owner', function () {
    // Arrange
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $privatePost = Post::factory()->create([
        'user_id' => $user->id,
        'visibility' => 'private',
    ]);

    // Act & Assert
    actingAs($user)
        ->get(route('posts.show', $privatePost))
        ->assertOk()
        ->assertViewIs('posts.show')
        ->assertSee($privatePost->title);

    actingAs($otherUser)
        ->get(route('posts.show', $privatePost))
        ->assertNotFound();

    get(route('posts.show', $privatePost))
        ->assertNotFound();
});


/* Verifica que los posts públicos solo son accesibles para usuarios autenticados */
it('public posts are accessible only to authenticated users', function () {
    // Arrange
    $post = Post::factory()->create([
        'visibility' => 'public',
    ]);

    // Act & Assert
    get(route('posts.show', $post))
        ->assertRedirect(route('login'));

    $user = User::factory()->create();
    actingAs($user)
        ->get(route('posts.show', $post))
        ->assertOk()
        ->assertViewIs('posts.show')
        ->assertSee($post->title);
});

/* Verifica que es seguidor puede ver el post compartido */
it('the follower can view shared post', function () {
    // Arrange
    $user = User::factory()->create();
    $follower = User::factory()->create();

    $user->followers()->attach($follower);

    $sharedPost = Post::factory()->create([
        'user_id' => $user->id,
        'visibility' => 'shared',
    ]);

    // Act & Assert
    actingAs($follower)
        ->get(route('posts.show', $sharedPost))
        ->assertOk()
        ->assertViewIs('posts.show')
        ->assertSee($sharedPost->title);
});

/* Verifica que el no seguidor no pueda ver el post compartido */
it('the non-follower cannot view shared post', function () {
    // Arrange
    $user = User::factory()->create();
    $nonFollower = User::factory()->create();

    $sharedPost = Post::factory()->create([
        'user_id' => $user->id,
        'visibility' => 'shared',
    ]);

    // Act & Assert
    actingAs($nonFollower)
        ->get(route('posts.show', $sharedPost))
        ->assertRedirect(route('login'));
});
