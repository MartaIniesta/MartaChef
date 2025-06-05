<?php

use App\Models\User;
use App\Events\UserFollowedEvent;
use Illuminate\Support\Facades\Log;
use App\Listeners\SendFollowNotificationListener;

it('logs a message when a user follows another', function () {
    $follower = User::factory()->create(['name' => 'Carlos']);
    $followed = User::factory()->create(['name' => 'María']);

    Log::shouldReceive('info')
        ->once()
        ->with('Carlos ha seguido a María');

    $event = new UserFollowedEvent($follower, $followed);
    $listener = new SendFollowNotificationListener();
    $listener->handle($event);
});
