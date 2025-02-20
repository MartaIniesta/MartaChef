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

it('does not show a private post to anyone other than the author', function () {
    // Arrange
    $post = Post::factory()->create(['visibility' => 'private']);

    // Act
    $response = $this->getJson(route('api.posts.show', $post));

    // Assert
    $response->assertStatus(403)
        ->assertJson(['error' => 'No autorizado']);
});

it('does not show a shared post to anyone other than the author', function () {
    // Arrange
    $post = Post::factory()->create(['visibility' => 'shared']);

    // Act
    $response = $this->getJson(route('api.posts.show', $post));

    // Assert
    $response->assertStatus(403)
        ->assertJson(['error' => 'No autorizado']);
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

it('stores a new post', function () {
    // Arrange
    Storage::fake('public');

    $user = User::factory()->create();
    $user->givePermissionTo('create-posts');

    loginAsUser($user);

    $categoryIds = Category::pluck('id')->take(2)->toArray();

    $file = UploadedFile::fake()->image('post.jpg');

    $data = [
        'title'       => 'Test Post',
        'description' => 'Content of test post',
        'ingredients' => 'Ingredient 1, Ingredient 2',
        'visibility'  => 'public',
        'categories'  => $categoryIds,
        'tags'        => 'tag1 tag2',
        'image'       => $file,
    ];

    // Act
    $response = $this->postJson(route('api.posts.store'), $data);

    // Assert
    $response->assertCreated()
        ->assertJsonStructure([
            'data' => ['id', 'title', 'description', 'ingredients', 'image', 'visibility', 'user', 'categories', 'tags']
        ]);

    Storage::disk('public')->assertExists('images/' . $file->hashName());

    $this->assertDatabaseHas('posts', [
        'title'      => 'Test Post',
        'description'=> 'Content of test post',
        'user_id'    => $user->id,
    ]);
});

it('updates an existing post', function () {
    // Arrange
    Storage::fake('public');

    $user = User::factory()->create();
    $user->givePermissionTo('edit-posts');
    loginAsUser($user);

    $post = Post::factory()->create([
        'user_id'    => $user->id,
        'visibility' => 'public',
        'title'      => 'Old Title',
        'description'=> 'Old description'
    ]);

    $categoryIds = Category::pluck('id')->take(2)->toArray();
    $newFile = UploadedFile::fake()->image('new_post.jpg');

    $data = [
        'title'       => 'Updated Title',
        'description' => 'Updated content',
        'ingredients' => 'Updated ingredient 1, Updated ingredient 2',
        'visibility'  => 'public',
        'categories'  => $categoryIds,
        'tags'        => 'newtag',
        'image'       => $newFile,
    ];

    // Act
    $response = $this->putJson(route('api.posts.update', $post), $data);

    // Assert
    $response->assertStatus(200)
        ->assertJson(['message' => 'Post actualizado correctamente.']);

    $this->assertDatabaseHas('posts', [
        'id'         => $post->id,
        'title'      => 'Updated Title',
        'description'=> 'Updated content'
    ]);

    Storage::disk('public')->assertExists('images/' . $newFile->hashName());
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
