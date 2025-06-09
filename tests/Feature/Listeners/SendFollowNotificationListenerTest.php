<?php

use App\Events\UserFollowedEvent;
use App\Listeners\SendFollowNotificationListener;
use App\Models\User;
use App\Notifications\UserFollowedNotification;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    Notification::fake();

    $this->follower = User::factory()->create();
    $this->followed = User::factory()->create();

    $this->listener = new SendFollowNotificationListener();
});

it('sends a notification to the followed user when the event is handled', function () {
    $event = new UserFollowedEvent($this->follower, $this->followed);

    $this->listener->handle($event);

    Notification::assertSentTo(
        $this->followed,
        UserFollowedNotification::class,
        function ($notification, $channels) {
            expect($notification->follower->id)->toBe($this->follower->id);
            return true;
        }
    );
});
