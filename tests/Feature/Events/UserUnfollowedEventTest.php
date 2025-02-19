<?php

use App\Events\UserUnfollowedEvent;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

test('UserUnfollowedEvent is dispatched when a user unfollows another user', function () {
    // Arrange
    $follower = User::factory()->create();
    $followed = User::factory()->create();

    $follower->givePermissionTo('follow-users');
    $follower->givePermissionTo('unfollow-users');

    loginAsUser($follower);

    $follower->follow($followed);

    Event::fake();

    // Act:
    $this->post(route('users.unfollow', $followed));

    // Assert:
    Event::assertDispatched(UserUnfollowedEvent::class, function ($event) use ($follower, $followed) {
        return $event->follower->id === $follower->id && $event->followed->id === $followed->id;
    });
});
