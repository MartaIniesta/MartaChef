<?php

use App\Events\UserFollowedEvent;
use App\Events\UserUnfollowedEvent;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

it('returns a list of users', function () {
    // Arrange
    User::factory()->count(3)->create();
    $user = User::factory()->create();
    loginAsUser($user);

    // Act
    $response = $this->getJson(route('api.users.index'));

    // Assert
    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

it('returns a specific user', function () {
    // Arrange
    $user = User::factory()->create();
    $authUser = User::factory()->create();
    loginAsUser($authUser);

    // Act
    $response = $this->getJson(route('api.users.show', $user));

    // Assert
    $response->assertStatus(200)
        ->assertJsonFragment(['name' => $user->name]);
});

it('follows another user', function () {
    // Arrange
    $userToFollow = User::factory()->create();
    $authUser = User::factory()->create();

    $authUser->givePermissionTo('follow-users');
    loginAsUser($authUser);
    Event::fake();

    expect($authUser->isFollowing($userToFollow))->toBeFalse();

    // Act
    $response = $this->postJson(route('api.users.follow', $userToFollow));

    // Assert
    $response->assertStatus(200)
        ->assertJson(['success' => "You are now following {$userToFollow->name}."]);

    expect($authUser->isFollowing($userToFollow))->toBeTrue();

    Event::assertDispatched(UserFollowedEvent::class);
});

it('A user cannot follow himself', function () {
    // Arrange
    $authUser = User::factory()->create();

    $authUser->givePermissionTo('follow-users');
    loginAsUser($authUser);

    // Act
    $response = $this->postJson(route('api.users.follow', $authUser));

    // Assert
    $response->assertStatus(400)
        ->assertJson(['error' => 'You cannot follow yourself.']);
});

it('should unfollow another user', function () {
    // Arrange
    $userToUnfollow = User::factory()->create();
    $authUser = User::factory()->create();

    $authUser->givePermissionTo('unfollow-users');
    loginAsUser($authUser);
    Event::fake();

    $authUser->follow($userToUnfollow);

    // Act
    $response = $this->postJson(route('api.users.unfollow', $userToUnfollow));

    // Assert
    $response->assertStatus(200)
        ->assertJson(['success' => "You have unfollowed {$userToUnfollow->name}."]);

    expect($authUser->isFollowing($userToUnfollow))->toBeFalse();

    Event::assertDispatched(UserUnfollowedEvent::class);
});
