<?php

use App\Events\UserFollowedEvent;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

test('UserFollowedEvent is dispatched when a user follows another user', function () {
    // Arrange
    $follower = User::factory()->create();
    $followed = User::factory()->create();

    $follower->givePermissionTo('follow-users');
    loginAsUser($follower);

    Event::fake();

    // Act
    $this->post(route('users.follow', $followed));

    // Assert
    Event::assertDispatched(UserFollowedEvent::class, function ($event) use ($follower, $followed) {
        return $event->follower->id === $follower->id && $event->followed->id === $followed->id;
    });
});
