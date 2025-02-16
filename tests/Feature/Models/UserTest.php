<?php

use Database\Seeders\RolesSeeder;
use App\Models\{User, Post};

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

it('has posts', function () {
    // Arrange
    $user = User::factory()
        ->has(Post::factory()->count(2), 'posts')
        ->create();

    $user->refresh();

    // Act & Assert
    expect($user->posts)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Post::class);
});

/* Permite a un usuario seguir a otro usuario */
it('allows a user to follow another user', function () {
    // Arrange
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $user1->givePermissionTo('follow-users');
    loginAsUser($user1);

    $user1->following()->attach($user2);

    $user1->refresh();
    $user2->refresh();

    // Act & Assert
    expect($user1->following->pluck('id'))
        ->toContain($user2->id)
        ->and($user2->followers->pluck('id'))
        ->toContain($user1->id);
});

/* No permite que un invitado siga a otro usuario */
it('does not allow a guest to follow another user', function () {
    // Arrange
    $user1 = User::factory()->create();

    // Act
    $response = $this->post(route('users.follow', ['user' => $user1->id]));

    // Assert
    $response->assertRedirect(route('login'));
});

/* Permite que un usuario tenga múltiples seguidores */
it('allows a user to have multiple followers', function () {
    // Arrange
    $user = User::factory()->create();
    $followers = User::factory()->count(3)->create();

    $user->givePermissionTo('follow-users');
    loginAsUser($user);

    foreach ($followers as $follower) {
        $follower->following()->attach($user);
    }
    $user->refresh();

    // Act & Assert
    expect($user->followers)->toHaveCount(3);
});

/* Permite a un usuario dejar de seguir a otro usuario */
it('allows a user to unfollow another user', function () {
    // Arrange
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $user1->givePermissionTo('follow-users');
    $user1->givePermissionTo('unfollow-users');

    loginAsUser($user1);
    $user1->following()->attach($user2);

    $user1->refresh();
    $user2->refresh();

    // Assert
    expect($user1->following->pluck('id'))->toContain($user2->id)
        ->and($user2->followers->pluck('id'))->toContain($user1->id);

    // Act
    $user1->following()->detach($user2);
    $user1->refresh();
    $user2->refresh();

    // Assert
    expect($user1->following->pluck('id'))->not->toContain($user2->id)
        ->and($user2->followers->pluck('id'))->not->toContain($user1->id);
});

/* No permite que un usuario se siga a si mismo */
it('does not allow a user to follow itself', function () {
    // Arrange
    $user = User::factory()->create();

    $user->givePermissionTo('follow-users');
    loginAsUser($user);

    $user->following()->attach($user);
    $user->refresh();

    // Act & Assert
    expect($user->following)->not->toContain($user);
});
