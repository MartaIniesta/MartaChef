<?php

namespace App\Listeners;

use App\Events\PostDeletedEvent;
use App\Mail\PostDeletedMail;
use Illuminate\Support\Facades\Mail;

class SendPostDeletedMailListener
{
    public function handle(PostDeletedEvent $event)
    {
        $post = $event->post;

        if ($post->user) {
            Mail::to($post->user->email)->send(new PostDeletedMail($post));
        }
    }
}
