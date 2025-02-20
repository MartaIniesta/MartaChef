<?php

use App\Jobs\SendPostNotificationJob;
use App\Mail\PostNotificationMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    $this->author = User::factory()->create();
    $this->follower1 = User::factory()->create();
    $this->follower2 = User::factory()->create();

    $this->author->followers()->attach([$this->follower1->id, $this->follower2->id]);

    $this->post = Post::factory()->create([
        'user_id' => $this->author->id,
        'title' => 'Post de prueba',
        'visibility' => 'public',
    ]);
});

test('SendPostNotificationJob sends emails to each follower when post is public or shared', function () {
    // Arrange
    Mail::fake();

    // Act
    $publicJob = new SendPostNotificationJob($this->post);
    $publicJob->handle();

    $sharedPost = Post::factory()->create([
        'user_id' => $this->author->id,
        'title' => 'Post compartido',
        'visibility' => 'shared',
    ]);
    $sharedJob = new SendPostNotificationJob($sharedPost);
    $sharedJob->handle();

    // Assert
    Mail::assertSent(PostNotificationMail::class, function ($mail) use ($sharedPost) {
        return $mail->hasTo($this->follower1->email) && $mail->post->title === $sharedPost->title;
    });

    Mail::assertSent(PostNotificationMail::class, function ($mail) use ($sharedPost) {
        return $mail->hasTo($this->follower2->email) && $mail->post->title === $sharedPost->title;
    });

    Mail::assertSent(PostNotificationMail::class, function ($mail) use ($publicJob) {
        return $mail->hasTo($this->follower1->email) && $mail->post->title === $this->post->title;
    });

    Mail::assertSent(PostNotificationMail::class, function ($mail) use ($publicJob) {
        return $mail->hasTo($this->follower2->email) && $mail->post->title === $this->post->title;
    });
});

test('SendPostNotificationJob does not send emails when post is private', function () {
    // Arrange
    Mail::fake();

    $privatePost = Post::factory()->create([
        'user_id' => $this->author->id,
        'title' => 'Post privado',
        'visibility' => 'private',
    ]);

    $job = new SendPostNotificationJob($privatePost);

    // Act
    $job->handle();

    // Assert
    Mail::assertNotSent(PostNotificationMail::class);
});
