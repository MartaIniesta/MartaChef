<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $author;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->author = $post->user;
    }

    public function build()
    {
        return $this->subject("Nuevo Post de {$this->author->name}")
            ->view('emails.post-notification');
    }
}
