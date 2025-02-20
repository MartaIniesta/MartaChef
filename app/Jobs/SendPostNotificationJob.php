<?php

namespace App\Jobs;

use App\Mail\PostNotificationMail;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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
                Mail::to($follower->email)->send(new PostNotificationMail($post));
            }
        }
    }
}
