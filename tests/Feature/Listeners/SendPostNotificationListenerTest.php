<?php

use App\Events\PostCreatedEvent;
use App\Listeners\SendPostNotificationListener;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    $this->author = User::factory()->create();
    $this->follower1 = User::factory()->create();
    $this->follower2 = User::factory()->create();

    $this->author->refresh()->followers()->attach([$this->follower1->id, $this->follower2->id]);

    $this->post = Post::factory()->create([
        'user_id' => $this->author->id,
        'title' => 'Post de prueba',
    ]);

    $this->listener = new SendPostNotificationListener();
});

test('SendPostNotificationListener logs messages for each follower', function () {
    // Arrange
    Log::spy();

    $event = new PostCreatedEvent($this->post);

    // Act
    $this->listener->handle($event);

    // Assert
    Log::shouldHaveReceived('info')
        ->with("Notificación: El usuario {$this->author->name} ha publicado un nuevo post '{$this->post->title}'. Se notifica a: {$this->follower1->email}")
        ->once();

    Log::shouldHaveReceived('info')
        ->with("Notificación: El usuario {$this->author->name} ha publicado un nuevo post '{$this->post->title}'. Se notifica a: {$this->follower2->email}")
        ->once();

    Log::shouldHaveReceived('info')
        ->with("Agradecimiento: Gracias a {$this->author->name} ({$this->author->email}) por compartir su post '{$this->post->title}'.")
        ->once();
});
