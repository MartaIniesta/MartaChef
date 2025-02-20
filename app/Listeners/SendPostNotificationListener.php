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

        Log::info("Notificación al autor: El usuario {$author->name} ha creado un nuevo post '{$post->title}'. ¡Gracias por compartirlo!");
    }
}
