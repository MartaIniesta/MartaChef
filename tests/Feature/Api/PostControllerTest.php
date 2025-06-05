<?php

use App\Models\{Post, User};
use Database\Seeders\{CategorySeeder, RolesSeeder};
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
    $this->seed(CategorySeeder::class);
});

/* Devuelve una lista de publicaciones públicas */
it('returns a list of public posts', function () {
    Post::factory()->count(3)->create(['visibility' => 'public']);

    $response = $this->getJson(route('api.posts.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'description', 'image', 'visibility', 'user', 'categories', 'tags']
            ]
        ]);

    $data = $response->json('data');
    expect(count($data))->toBe(3);
});

/* Permite al usuario autorizado ver la publicación */
it('allows authorized user to view the post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['visibility' => 'private', 'user_id' => $user->id]);

    $this->actingAs($user);

    $response = $this->getJson(route('api.posts.show', $post->id));

    $response->assertStatus(200)
        ->assertJsonPath('data.id', $post->id);
});

/* Devuelve 404 cuando la publicación no existe */
it('returns 404 when post does not exist', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->getJson(route('api.posts.show', 999999));

    $response->assertStatus(404)
        ->assertJson(['error' => 'El post no existe.']);
});

/* Devuelve las publicaciones del usuario autenticado */
it('returns my posts for the authenticated user', function () {
    $user = User::factory()->create();

    Post::factory()->create(['user_id' => $user->id, 'visibility' => 'public']);
    Post::factory()->create(['user_id' => $user->id, 'visibility' => 'private']);
    Post::factory()->create(['user_id' => $user->id, 'visibility' => 'shared']);
    Post::factory()->create(['visibility' => 'public']);

    loginAsUser($user);

    $response = $this->getJson(route('api.myPosts'));

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

/* Devuelve publicaciones compartidas de usuarios seguidos */
it('returns shared posts from followed users', function () {
    $authUser = User::factory()->create();
    $followedUser = User::factory()->create();
    $authUser->following()->attach($followedUser->id);

    $post = Post::factory()->create([
        'user_id'    => $followedUser->id,
        'visibility' => 'shared'
    ]);

    loginAsUser($authUser);

    $response = $this->getJson(route('api.sharedPosts'));

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

/* Crea una publicación exitosamente con datos válidos */
it('creates a post successfully with valid data', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $user->givePermissionTo('create-posts');
    $this->actingAs($user);

    $data = [
        'title'       => 'Test Post',
        'description' => 'Test description',
        'ingredients' => 'Ingredient1, Ingredient2',
        'visibility'  => 'public',
        'categories'  => [1, 2],
        'tags'        => '#test #post',
        'image'       => UploadedFile::fake()->image('post.jpg'),
    ];

    $response = $this->postJson(route('api.posts.store'), $data);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'title',
                'description',
                'ingredients',
                'image',
                'visibility',
                'user',
                'categories',
                'tags',
            ]
        ])
        ->assertJsonFragment(['message' => 'Post creado con éxito.']);

    $this->assertDatabaseHas('posts', [
        'title' => 'Test Post',
        'user_id' => $user->id,
    ]);

    $imageUrl = $response->json('data.image');
    $path = parse_url($imageUrl, PHP_URL_PATH);
    $relativePath = ltrim(str_replace('/storage/', '', $path), '/');

    Storage::disk('public')->assertExists($relativePath);
});

/* Devuelve errores de validación cuando faltan datos */
it('returns validation errors when data is missing', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('create-posts');
    $this->actingAs($user);

    $response = $this->postJson(route('api.posts.store'), []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['title', 'description', 'ingredients', 'visibility', 'categories', 'image']);
});

/* Devoluciones no autorizadas si el usuario no está autenticado */
it('returns unauthorized if user is not authenticated', function () {
    $response = $this->postJson(route('api.posts.store'), []);

    $response->assertStatus(401);
});

/* Actualiza una publicación exitosamente con datos válidos */
it('updates a post successfully with valid data', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $user->givePermissionTo('edit-posts');
    $this->actingAs($user);

    $post = Post::factory()->for($user)->create();

    $data = [
        'title'       => 'Updated Post Title',
        'description' => 'Updated description',
        'ingredients' => 'Updated Ingredient1, Ingredient2',
        'visibility'  => 'private',
        'categories'  => [1, 3],
        'tags'        => '#updated #post',
        'image'       => UploadedFile::fake()->image('updated.jpg'),
    ];

    $response = $this->putJson(route('api.posts.update', $post), $data);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'title',
                'description',
                'ingredients',
                'image',
                'visibility',
                'user',
                'categories',
                'tags',
            ]
        ])
        ->assertJsonFragment(['message' => 'Post actualizado con éxito.']);

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Updated Post Title',
        'user_id' => $user->id,
    ]);

    $imageUrl = $response->json('data.image');
    $imagePath = ltrim(parse_url($imageUrl, PHP_URL_PATH), '/storage/');

    Storage::disk('public')->assertExists($imagePath);
});

/* Destruye una publicación */
it('destroys a post', function () {
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

    $response = $this->deleteJson(route('api.posts.destroy', $post));

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'Post eliminado correctamente'
        ]);

    $this->assertSoftDeleted('posts', [
        'id' => $post->id,
    ]);

    Storage::disk('public')->assertMissing('images/post.jpg');
});
