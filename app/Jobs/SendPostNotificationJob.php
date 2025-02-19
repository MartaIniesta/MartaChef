<?php

namespace App\Jobs;

use App\Mail\PostNotificationMail;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

        foreach ($followers as $follower) {
            try {
                Mail::to($follower->email)->send(new PostNotificationMail($post));

                Log::info("Correo enviado a {$follower->email} por la creacion de una nueva receta ('{$post->title}') de '{$post->user->name}'.");

            } catch (\Exception $e) {
                Log::error("No se pudo enviar el correo a {$follower->email} por la creacion de una nueva receta ('{$post->title}') de '{$post->user->name}'. Error: " . $e->getMessage());
            }
        }
    }
}
