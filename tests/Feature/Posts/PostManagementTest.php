<?php
use Illuminate\Http\UploadedFile;
use App\Models\{User, Post};
use function Pest\Laravel\actingAs;

/* Verifica que un usuario autenticado puede crear un post */
it('allows a user to create a post', function () {
    // Arrange
    $user = User::factory()->create();
    $image = UploadedFile::fake()->image('imagen_ejemplo.jpg', 600, 400);

    $postData = [
        'title' => 'Nuevo post',
        'description' => 'Descripción del post',
        'ingredients' => 'Ingredientes del post',
        'visibility' => 'public',
        'image' => $image,
    ];

    // Act & Assert
    actingAs($user)
        ->post(route('posts.store'), $postData)
        ->assertRedirect(route('posts.index'))
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('posts', [
        'title' => 'Nuevo post',
        'user_id' => $user->id,
        'description' => 'Descripción del post',
        'ingredients' => 'Ingredientes del post',
        'image' => $image,
    ]);
});

/* Asegura que un usuario solo puede editar sus propios posts */
it('does not allow a non-owner user to edit a post', function () {
    // Arrange
    $user = User::factory()->create();
    $nonOwner = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $image = UploadedFile::fake()->image('imagen_ejemplo.jpg', 600, 400);

    $updatedData = [
        'title' => 'Título actualizado',
        'description' => 'Descripción actualizada',
        'ingredients' => 'Ingredientes actualizados',
        'visibility' => 'public',
        'image' => $image,
    ];

    // Act & Assert
    actingAs($nonOwner)
        ->put(route('posts.update', $post), $updatedData)
        ->assertForbidden();
});

/* Asegura que un usuario puede eliminar solo sus propios posts */
it('allows a user to delete their own post', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    // Act & Assert
    actingAs($user)
        ->delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.index'))
        ->assertSessionHasNoErrors();

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});
