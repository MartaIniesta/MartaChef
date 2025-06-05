<?php

namespace App\Listeners;

use App\Events\UserFollowedEvent;
use Illuminate\Support\Facades\Log;

class SendFollowNotificationListener
{
    public function handle(UserFollowedEvent $event)
    {
        Log::info("{$event->follower->name} ha seguido a {$event->followed->name}");
    }
}
