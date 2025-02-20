<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPostNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post->load('user.followers');
    }

    public function handle()
    {
        $post = $this->post;
        $author = $post->user;
        $followers = $author->followers;

        if ($post->visibility === 'public' || $post->visibility === 'shared') {
            foreach ($followers as $follower) {
                Log::info("Notificación: El usuario {$author->name} ha publicado un nuevo post '{$post->title}'. Se notifica a: {$follower->email}");
            }
        }
    }
}
