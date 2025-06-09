<?php

namespace App\Listeners;

use App\Events\PostCreatedEvent;
use App\Models\User;
use App\Notifications\PostCreatedNotification;

class SendPostNotificationListener
{
    public function handle(PostCreatedEvent $event)
    {
        $post = $event->post;
        $author = $post->user;

        $usersToNotify = User::where('id', '!=', $author->id)->get();

        foreach ($usersToNotify as $user) {
            $user->notify(new PostCreatedNotification($post));
        }
    }
}
