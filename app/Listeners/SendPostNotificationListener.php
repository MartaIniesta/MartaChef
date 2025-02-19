<?php

namespace App\Listeners;

use App\Events\PostCreatedEvent;
use Illuminate\Support\Facades\Log;

class SendPostNotificationListener
{
    public function handle(PostCreatedEvent $event)
    {
        $post = $event->post;
        $author = $post->user;

        $followers = $author->followers;

        foreach ($followers as $follower) {
            Log::info("Notificación: El usuario {$author->name} ha publicado un nuevo post '{$post->title}'. Se notifica a: {$follower->email}");
        }

        Log::info("Agradecimiento: Gracias a {$author->name} ({$author->email}) por compartir su post '{$post->title}'.");
    }
}
