<?php

use App\Events\UserFollowedEvent;
use App\Events\UserUnfollowedEvent;
use App\Listeners\SendFollowNotificationListener;
use App\Models\User;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    $this->follower = User::factory()->create();
    $this->followed = User::factory()->create();
    $this->listener = new SendFollowNotificationListener();
});

test('SendFollowNotificationListener logs message when a user follows another user', function () {
    // Arrange
    Log::shouldReceive('info')
        ->once()
        ->withArgs(function ($message) {
            return str_contains($message, "{$this->follower->name} ha seguido a {$this->followed->name}");
        });

    $event = new UserFollowedEvent($this->follower, $this->followed);

    // Act
    $this->listener->handle($event);
});

test('SendFollowNotificationListener logs message when a user unfollows another user', function () {
    // Arrange
    Log::shouldReceive('info')
        ->once()
        ->withArgs(function ($message) {
            return str_contains($message, "{$this->follower->name} ha dejado de seguir a {$this->followed->name}");
        });

    $event = new UserUnfollowedEvent($this->follower, $this->followed);

    // Act
    $this->listener->handle($event);
});
