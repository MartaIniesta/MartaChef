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
    $user->refresh();

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
    $response = $this->post(route('posts.store'), $postData);
    $response->assertRedirect();

    $createdPost = $user->posts()->latest()->first();

    // Assert
    Event::assertDispatched(PostCreatedEvent::class, function ($event) use ($createdPost) {
        return $event->post->id === $createdPost->id && $event->post->title === $createdPost->title;
    });
});
