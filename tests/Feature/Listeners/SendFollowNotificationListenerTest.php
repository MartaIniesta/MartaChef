<?php

use App\Events\UserFollowedEvent;
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

    // Assert
    expect($this->follower->isFollowing($this->followed))->toBeTrue();
});

test('SendFollowNotificationListener does not log message if user already follows', function () {
    // Arrange
    $this->follower->follow($this->followed);

    Log::shouldReceive('info')->never();

    $event = new UserFollowedEvent($this->follower, $this->followed);

    // Act
    $this->listener->handle($event);

    // Assert
    expect($this->follower->isFollowing($this->followed))->toBeTrue();
});
