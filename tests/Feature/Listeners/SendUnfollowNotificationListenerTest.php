<?php

use App\Events\UserUnfollowedEvent;
use App\Listeners\SendUnfollowNotificationListener;
use App\Models\User;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    $this->follower = User::factory()->create();
    $this->followed = User::factory()->create();
    $this->listener = new SendUnfollowNotificationListener();
});

test('SendUnfollowNotificationListener logs message when a user unfollows another user', function () {
    // Arrange
    $this->follower->follow($this->followed);

    Log::shouldReceive('info')
        ->once()
        ->withArgs(function ($message) {
            return str_contains($message, "{$this->follower->name} ha dejado de seguir a {$this->followed->name}");
        });

    $event = new UserUnfollowedEvent($this->follower, $this->followed);

    // Act
    $this->listener->handle($event);

    // Assert
    expect($this->follower->isFollowing($this->followed))->toBeFalse();
});

test('SendUnfollowNotificationListener does not log message if user is not following', function () {
    // Arrange
    Log::shouldReceive('info')->never();

    $event = new UserUnfollowedEvent($this->follower, $this->followed);

    // Act
    $this->listener->handle($event);

    // Assert
    expect($this->follower->isFollowing($this->followed))->toBeFalse();
});
