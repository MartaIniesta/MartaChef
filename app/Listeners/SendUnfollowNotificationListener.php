<?php

namespace App\Listeners;

use App\Events\UserUnfollowedEvent;
use Illuminate\Support\Facades\Log;

class SendUnfollowNotificationListener
{
    public function handle(UserUnfollowedEvent $event)
    {
        Log::info("{$event->follower->name} ha dejado de seguir a {$event->followed->name}");
    }
}
