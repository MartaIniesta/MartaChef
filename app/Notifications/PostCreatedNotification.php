<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostCreatedNotification extends Notification
{
    use Queueable;

    protected $post;
    protected $author;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->author = $post->user;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "{$this->author->name} ha creado una nueva receta llamada: '{$this->post->title}'. ¡Gracias por compartirla!",
            'post_id' => $this->post->id,
            'author_id' => $this->author->id,
        ];
    }
}
