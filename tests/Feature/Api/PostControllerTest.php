<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\RolesSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
    $this->seed(CategorySeeder::class);
});

it('returns a list of public posts', function () {
    // Arrange
    Post::factory()->count(3)->create(['visibility' => 'public']);

    // Act
    $response = $this->getJson(route('api.posts.index'));

    // Assert
    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'description', 'image', 'visibility', 'user', 'categories', 'tags']
            ]
        ]);

    $data = $response->json('data');
    expect(count($data))->toBe(3);
});

it('shows a public post', function () {
    // Arrange
    $post = Post::factory()->create(['visibility' => 'public']);

    // Act
    $response = $this->getJson(route('api.posts.show', $post));

    // Assert
    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => ['id', 'title', 'description', 'image', 'visibility', 'user', 'categories', 'tags']
        ]);
});

it('returns my posts for the authenticated user', function () {
    // Arrange
    $user = User::factory()->create();

    Post::factory()->create(['user_id' => $user->id, 'visibility' => 'public']);
    Post::factory()->create(['user_id' => $user->id, 'visibility' => 'private']);
    Post::factory()->create(['user_id' => $user->id, 'visibility' => 'shared']);
    Post::factory()->create(['visibility' => 'public']);

    loginAsUser($user);

    // Act
    $response = $this->getJson(route('api.myPosts'));

    // Assert
    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'description', 'image', 'visibility', 'user', 'categories', 'tags']
            ]
        ]);

    foreach ($response->json('data') as $postData) {
        expect($postData['user']['id'])->toBe($user->id);
    }
});

it('returns shared posts from followed users', function () {
    // Arrange
    $authUser = User::factory()->create();
    $followedUser = User::factory()->create();
    $authUser->following()->attach($followedUser->id);

    $post = Post::factory()->create([
        'user_id'    => $followedUser->id,
        'visibility' => 'shared'
    ]);

    loginAsUser($authUser);

    // Act
    $response = $this->getJson(route('api.sharedPosts'));

    // Assert
    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'description', 'image', 'visibility', 'user', 'categories', 'tags']
            ]
        ]);

    $posts = $response->json('data');
    expect(count($posts))->toBeGreaterThan(0)
        ->and($posts[0]['id'])->toBe($post->id);
});

it('destroys a post', function () {
    // Arrange
    Storage::fake('public');

    $user = User::factory()->create();
    $user->givePermissionTo('delete-posts');
    loginAsUser($user);

    $post = Post::factory()->create([
        'user_id'    => $user->id,
        'visibility' => 'public',
        'image'      => 'images/post.jpg'
    ]);

    Storage::disk('public')->put('images/post.jpg', 'fake content');

    // Act
    $response = $this->deleteJson(route('api.posts.destroy', $post));

    // Assert
    $response->assertStatus(200)
        ->assertJson([
            'status' => 'Post eliminado correctamente'
        ]);

    $this->assertSoftDeleted('posts', [
        'id' => $post->id,
    ]);

    Storage::disk('public')->assertMissing('images/post.jpg');
});
