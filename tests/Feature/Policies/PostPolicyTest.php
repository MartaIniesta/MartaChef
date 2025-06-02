<?php

use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Database\Seeders\RolesSeeder;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
    $this->policy = new PostPolicy();
});

it('can view any post', function () {
    // Arrange
    $user = User::factory()->create();

    // Act & Assert
    expect(Gate::forUser($user)->allows('viewAny', Post::class))->toBeTrue();
});

it('can view a public post', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['visibility' => 'public']);

    // Act & Assert
    expect(Gate::forUser($user)->allows('view', $post))->toBeTrue();
});

/* No puedo ver una publicación privada a menos que el usuario sea el propietario */
it('cannot view a private post unless the user is the owner', function () {
    // Arrange
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['visibility' => 'private', 'user_id' => $otherUser->id]);

    // Act & Assert
    expect(Gate::forUser($user)->denies('view', $post))->toBeTrue()
        ->and(Gate::forUser($otherUser)->allows('view', $post))->toBeTrue();
});

/* Se puede crear una publicación si el usuario tiene permiso */
it('can create a post if user has permission', function () {
    // Arrange
    $user = User::factory()->create();
    $user->givePermissionTo('create-posts');

    // Act & Assert
    expect(Gate::forUser($user)->allows('create', Post::class))->toBeTrue();
});

/* No se puede crear una publicación si el usuario no tiene permiso */
it('cannot create a post if user does not have permission', function () {
    // Arrange
    $user = User::factory()->create();

    // Act & Assert
    expect(Gate::forUser($user)->denies('create', Post::class))->toBeTrue();
});

/* Puede actualizar una publicación si el usuario tiene permiso o es el propietario */
it('can update a post if the user has permission or is the owner', function () {
    // Arrange
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $user->givePermissionTo('edit-posts');

    // Act & Assert
    expect(Gate::forUser($user)->allows('update', $post))->toBeTrue()
        ->and(Gate::forUser($otherUser)->denies('update', $post))->toBeTrue();
});

/* No puede actualizar si el usuario tiene permiso pero no es el propietario */
it('cannot update if the user has permission but is not the owner', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $otherUser->id]);

    $user->givePermissionTo('edit-posts');

    expect(Gate::forUser($user)->denies('update', $post))->toBeTrue();
});

/* Permite al administrador actualizar cualquier publicación */
it('allows admin to update any post', function () {
    $admin = Mockery::mock(User::class)->makePartial();
    $admin->id = 1;
    $admin->shouldReceive('hasRole')->with('admin')->andReturnTrue();

    $post = new Post();
    $post->user_id = 2;

    expect($this->policy->update($admin, $post))->toBeTrue();
});

/* Puede eliminar una publicación si el usuario tiene permiso o es el propietario */
it('can delete a post if user has permission or is the owner', function () {
    // Arrange
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $user->givePermissionTo('delete-posts');

    // Act & Assert
    expect(Gate::forUser($user)->allows('delete', $post))->toBeTrue()
        ->and(Gate::forUser($otherUser)->denies('delete', $post))->toBeTrue();
});

/* Permite al administrador o moderador eliminar cualquier publicación */
it('allows admin or moderator to delete any post', function () {
    $post = Post::factory()->create();

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $moderator = User::factory()->create();
    $moderator->assignRole('moderator');

    expect($this->policy->delete($admin, $post))->toBeTrue()
        ->and($this->policy->delete($moderator, $post))->toBeTrue();
});

/* No se puede restaurar una publicación si el usuario no tiene el permiso */
it('cannot restore a post if the user does not have the permission', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $post->delete();

    // Act & Assert
    expect(Gate::forUser($user)->denies('restore', $post))->toBeTrue();
});

/* Permite al usuario forzar la eliminación de una publicación si tiene permiso */
it('allows user to force delete a post if they have permission', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $user->givePermissionTo('force-delete-posts');

    expect(Gate::forUser($user)->allows('forceDelete', $post))->toBeTrue();
});

/* El usuario no puede forzar la eliminación de una publicación si no tiene permiso */
it('the user cannot force delete a post if they do not have permission', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    expect(Gate::forUser($user)->denies('forceDelete', $post))->toBeTrue();
});

/* No puede calificar su propio post */
it('cannot rate their own post', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $user->givePermissionTo('rate-posts');

    // Act & Assert
    expect(Gate::forUser($user)->denies('rate', $post))->toBeTrue();
});

/* No se pueden calificar posts sin el permiso */
it('cannot rate posts without permission', function () {
    // Arrange
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $post = Post::factory()->create(['user_id' => $otherUser->id]);
    $ownPost = Post::factory()->create(['user_id' => $user->id]);

    // Act & Assert
    expect(Gate::forUser($user)->denies('rate', $post))->toBeTrue()
        ->and(Gate::forUser($user)->denies('rate', $ownPost))->toBeTrue();
});
