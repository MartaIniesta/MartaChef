<?php

use Database\Seeders\RolesSeeder;
use App\Models\{User, Post, Rating};

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

/* Devuelve todas las calificaciones con usuario y post */
it('returns all ratings with user and post', function () {
    Rating::factory()->count(3)->create();

    $user = User::factory()->create();
    loginAsUser($user);

    $response = $this->getJson(route('api.ratings.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'rating', 'user', 'post_id', 'created_at']
            ]
        ])
        ->assertJsonCount(3, 'data');
});

/* Devuelve las calificaciones de una publicación específica */
it('returns ratings for given post', function () {
    $post = Post::factory()->create();
    Rating::factory()->count(2)->for($post)->create();

    $user = User::factory()->create();
    loginAsUser($user);

    $response = $this->getJson(route('api.ratings.show', $post->id));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'rating', 'user']
            ]
        ])
        ->assertJsonCount(2, 'data');
});

/* Devuelve 404 si no hay calificaciones para la publicación */
it('returns 404 if no ratings for post', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();
    loginAsUser($user);

    $response = $this->getJson(route('api.ratings.show', $post->id));

    $response->assertStatus(404)
        ->assertJson(['message' => 'No se encontraron calificaciones para esta publicación']);
});

/* Crea una calificación exitosamente */
it('creates a rating successfully', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('rate-posts');

    $post = Post::factory()->create([
        'visibility' => 'public',
    ]);

    loginAsUser($user);

    $response = $this->postJson(route('api.ratings.store'), [
        'post_id' => $post->id,
        'rating'  => 4,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'data' => ['id', 'rating', 'user']
        ])
        ->assertJsonFragment(['message' => 'Calificación guardada correctamente']);

    $this->assertDatabaseHas('ratings', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'rating'  => 4,
    ]);
});

/* Retorna 409 si ya existe una calificación para el post y el usuario */
it('returns 409 if rating already exists', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('rate-posts');

    $postOwner = User::factory()->create();
    $post = Post::factory()->create([
        'user_id'    => $postOwner->id,
        'visibility' => 'public',
    ]);

    Rating::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'rating'  => 3,
    ]);

    loginAsUser($user);

    $response = $this->postJson(route('api.ratings.store'), [
        'post_id' => $post->id,
        'rating'  => 5,
    ]);

    $response->assertStatus(409)
        ->assertJson([
            'message' => 'Ya has calificado este post. Si deseas cambiar tu calificación, utiliza la ruta de actualización.'
        ]);
});

/* Falla validación al crear calificación si faltan campos */
it('fails validation if rating is missing but post_id is valid', function () {
    $author = User::factory()->create();
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $author->id,
        'visibility' => 'public',
    ]);

    $user->givePermissionTo('rate-posts');

    loginAsUser($user);

    $response = $this->postJson(route('api.ratings.store'), [
        'post_id' => $post->id,
        'rating' => null,
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['rating']);
});

/* Actualiza una calificación exitosamente */
it('updates rating successfully', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $rating = Rating::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'rating'  => 3,
    ]);

    loginAsUser($user);

    $response = $this->putJson(route('api.ratings.update', $post->id), [
        'rating' => 5,
    ]);

    $response->assertStatus(200)
        ->assertJsonFragment(['message' => 'Calificación actualizada'])
        ->assertJsonPath('data.rating', 5);

    $this->assertDatabaseHas('ratings', [
        'id'     => $rating->id,
        'rating' => 5,
    ]);
});

/* Devuelve 404 si no se encuentra calificación al actualizar */
it('returns 404 if rating not found on update', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();
    loginAsUser($user);

    $response = $this->putJson(route('api.ratings.update', $post->id), [
        'rating' => 4,
    ]);

    $response->assertStatus(404)
        ->assertJson(['message' => 'Calificación no encontrada']);
});

/* Falla validación al actualizar si no se proporciona calificación */
it('fails validation if rating missing on update', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    Rating::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    loginAsUser($user);

    $response = $this->putJson(route('api.ratings.update', $post->id), []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['rating']);
});

/* Elimina calificación exitosamente */
it('deletes rating successfully', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $rating = Rating::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    loginAsUser($user);

    $response = $this->deleteJson(route('api.ratings.destroy', $post->id));

    $response->assertStatus(200)
        ->assertJson(['message' => 'Calificación eliminada']);

    $this->assertDatabaseMissing('ratings', [
        'id' => $rating->id,
    ]);
});

/* Devuelve 404 si no encuentra la calificación al eliminar */
it('returns 404 if rating not found on delete', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    loginAsUser($user);

    $response = $this->deleteJson(route('api.ratings.destroy', $post->id));

    $response->assertStatus(404)
        ->assertJson(['message' => 'Calificación no encontrada']);
});
