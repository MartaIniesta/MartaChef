<?php

use App\Events\PostCreatedEvent;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

test('PostCreatedEvent is dispatched when a post is created', function () {
    // Arrange
    $user = User::factory()->create();
    $user->givePermissionTo('create-posts');
    loginAsUser($user);

    $category = Category::factory()->create();

    $postData = [
        'title' => 'Post de Prueba',
        'description' => 'Descripción del post de prueba',
        'ingredients' => 'Ingredientes del post de prueba',
        'visibility' => 'public',
        'categories' => [$category->id],
        'tags' => 'tag1, tag2',
        'image' => UploadedFile::fake()->image('post.jpg'),
    ];

    Event::fake();

    // Act
    $this->post(route('posts.store'), $postData);

    // Assert
    Event::assertDispatched(PostCreatedEvent::class, function ($event) use ($user, $postData) {
        return $event->post->user_id === $user->id && $event->post->title === $postData['title'];
    });
});
