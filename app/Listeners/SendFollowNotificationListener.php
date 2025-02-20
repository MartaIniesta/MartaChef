<?php

namespace App\Listeners;

use App\Events\UserFollowedEvent;
use Illuminate\Support\Facades\Log;

class SendFollowNotificationListener
{
    public function handle(UserFollowedEvent $event)
    {
        if (!$event->follower->isFollowing($event->followed)) {
            $event->follower->follow($event->followed);
            Log::info("{$event->follower->name} ha seguido a {$event->followed->name}");
        }
    }
}
