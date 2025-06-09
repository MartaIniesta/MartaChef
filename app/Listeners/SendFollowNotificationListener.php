<?php

namespace App\Listeners;

use App\Events\UserFollowedEvent;
use App\Notifications\UserFollowedNotification;

class  SendFollowNotificationListener
{
    public function handle(UserFollowedEvent $event)
    {
        $event->followed->notify(new UserFollowedNotification($event->follower));
    }
}
