<?php

use App\Jobs\SendPostNotificationJob;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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

test('SendPostNotificationJob logs messages for each follower when post is public or shared', function () {
    // Arrange
    Log::spy();

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
    foreach ([$this->post, $sharedPost] as $post) {
        Log::shouldHaveReceived('info')
            ->with("Notificación: El usuario {$this->author->name} ha publicado un nuevo post '{$post->title}'. Se notifica a: {$this->follower1->email}")
            ->once();

        Log::shouldHaveReceived('info')
            ->with("Notificación: El usuario {$this->author->name} ha publicado un nuevo post '{$post->title}'. Se notifica a: {$this->follower2->email}")
            ->once();
    }
});

test('SendPostNotificationJob does not log messages when post is private', function () {
    // Arrange
    Log::spy();

    $privatePost = Post::factory()->create([
        'user_id' => $this->author->id,
        'title' => 'Post privado',
        'visibility' => 'private',
    ]);

    $job = new SendPostNotificationJob($privatePost);

    // Act
    $job->handle();

    // Assert
    Log::shouldNotHaveReceived('info');
});
