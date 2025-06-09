<?php

use App\Mail\PostDeletedMail;
use App\Models\Post;

it('builds the email with correct subject and view', function () {
    $post = Post::factory()->make();

    $mail = new PostDeletedMail($post);

    expect($mail->build()->subject)->toBe('Tu post ha sido eliminado')
        ->and($mail->build()->view)->toBe('emails.post_deleted');
});
