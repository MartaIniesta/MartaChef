<?php

use App\Mail\PostNotificationMail;
use App\Models\Post;
use App\Models\User;

it('builds the email with correct subject and view', function () {
    $author = User::factory()->create(['name' => 'Juan Pérez']);
    $post = Post::factory()->for($author)->create();

    $mail = new PostNotificationMail($post);

    $builtMail = $mail->build();

    expect($builtMail->subject)->toBe("Nuevo Post de {$author->name}")
        ->and($builtMail->view)->toBe('emails.post-notification');
});
