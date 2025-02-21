<?php

use App\Events\PostCreatedEvent;
use App\Listeners\SendPostNotificationListener;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Log;

test('SendPostNotificationListener logs a message for the author', function () {
    // Arrange
    $author = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $author->id,
        'title' => 'Post de prueba',
    ]);

    $listener = new SendPostNotificationListener();

    Log::spy();

    $event = new PostCreatedEvent($post);

    // Act
    $listener->handle($event);

    // Assert
    Log::shouldHaveReceived('info')
        ->with("Usuario {$author->name} ha creado un nuevo post '{$post->title}'. ¡Gracias por compartirlo!")
        ->once();
});
