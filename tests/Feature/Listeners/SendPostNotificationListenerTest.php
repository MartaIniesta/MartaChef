<?php

use App\Events\PostCreatedEvent;
use App\Listeners\SendPostNotificationListener;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    $this->author = User::factory()->create();

    $this->post = Post::factory()->create([
        'user_id' => $this->author->id,
        'title' => 'Post de prueba',
    ]);

    $this->listener = new SendPostNotificationListener();
});

test('SendPostNotificationListener logs a message for the author', function () {
    // Arrange
    Log::spy();

    $event = new PostCreatedEvent($this->post);

    // Act
    $this->listener->handle($event);

    // Assert
    Log::shouldHaveReceived('info')
        ->with("Notificación al autor: El usuario {$this->author->name} ha creado un nuevo post '{$this->post->title}'. ¡Gracias por compartirlo!")
        ->once();
});
