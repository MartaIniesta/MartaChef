<?php

use App\Events\PostCreatedEvent;
use App\Listeners\SendPostNotificationListener;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostCreatedNotification;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    Notification::fake();

    $this->author = User::factory()->create();
    $this->otherUsers = User::factory()->count(3)->create();

    $this->post = Post::factory()->for($this->author, 'user')->create();

    $this->listener = new SendPostNotificationListener();
});

it('sends a notification to all users except the author when a post is created', function () {
    $event = new PostCreatedEvent($this->post);

    $this->listener->handle($event);

    Notification::assertNotSentTo($this->author, PostCreatedNotification::class);

    foreach ($this->otherUsers as $user) {
        Notification::assertSentTo(
            $user,
            PostCreatedNotification::class,
            fn ($notification) => $notification->getPost()->id === $this->post->id
        );
    }
});
