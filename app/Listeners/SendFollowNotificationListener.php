<?php

namespace App\Listeners;

use App\Events\UserFollowedEvent;
use App\Events\UserUnfollowedEvent;
use Illuminate\Support\Facades\Log;

class SendFollowNotificationListener
{
    public function handle($event)
    {
        if ($event instanceof UserFollowedEvent) {
            Log::info("{$event->follower->name} ha seguido a {$event->followed->name}");
        } elseif ($event instanceof UserUnfollowedEvent) {
            Log::info("{$event->follower->name} ha dejado de seguir a {$event->followed->name}");
        }
    }
}
