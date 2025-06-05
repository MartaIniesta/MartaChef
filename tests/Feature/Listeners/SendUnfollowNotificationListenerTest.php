<?php

use App\Models\User;
use App\Events\UserUnfollowedEvent;
use Illuminate\Support\Facades\Log;
use App\Listeners\SendUnfollowNotificationListener;

it('logs a message when a user unfollows another', function () {
    $follower = User::factory()->create(['name' => 'Ana']);
    $followed = User::factory()->create(['name' => 'Luis']);

    Log::shouldReceive('info')
        ->once()
        ->with('Ana ha dejado de seguir a Luis');

    $event = new UserUnfollowedEvent($follower, $followed);
    $listener = new SendUnfollowNotificationListener();

    $listener->handle($event);
});
