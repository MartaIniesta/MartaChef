<?php

use App\Livewire\FavoriteList;
use App\Models\{Favorite, Post, User};
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

/* Carga solo los favoritos del usuario autenticado */
it('loads only the favorites of the authenticated user', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $post1 = Post::factory()->create();
    $post2 = Post::factory()->create();

    $fav1 = Favorite::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post1->id,
        'note' => 'Mi nota',
    ]);

    $fav2 = Favorite::factory()->create([
        'user_id' => $otherUser->id,
        'post_id' => $post2->id,
        'note' => 'No debería cargarse',
    ]);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->assertViewHas('favorites', fn ($favorites) =>
            $favorites->count() === 1 &&
            $favorites->first()->id === $fav1->id
        );
});

/* Puede empezar a crear una nueva nota */
it('can start creating a new note', function () {
    $user = User::factory()->create();
    $favorite = Favorite::factory()->create(['user_id' => $user->id]);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->call('startCreating', $favorite->id)
        ->assertSet('favoriteId', $favorite->id)
        ->assertSet('note', '')
        ->assertSet('isCreating', true)
        ->assertSet('isEditing', false);
});

/* Puede crear una nota */
it('can create a note', function () {
    $user = User::factory()->create();
    $favorite = Favorite::factory()->create([
        'user_id' => $user->id,
        'note' => null,
    ]);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->set('favoriteId', $favorite->id)
        ->set('note', 'Nueva nota')
        ->call('createNote')
        ->assertSet('isCreating', false)
        ->assertSet('note', '')
        ->assertSet('favoriteId', null);

    assertDatabaseHas('favorites', [
        'id' => $favorite->id,
        'note' => 'Nueva nota',
    ]);
});

/* No crea una nota si está vacía */
it('does not create a note if empty', function () {
    $user = User::factory()->create();
    $favorite = Favorite::factory()->create([
        'user_id' => $user->id,
        'note' => null,
    ]);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->set('favoriteId', $favorite->id)
        ->set('note', '')
        ->call('createNote');

    expect(Favorite::find($favorite->id)->note)->toBeNull();
});

/* Puede editar una nota existente */
it('can edit an existing note', function () {
    $user = User::factory()->create();
    $favorite = Favorite::factory()->create([
        'user_id' => $user->id,
        'note' => 'Nota existente',
    ]);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->call('editNote', $favorite->id)
        ->assertSet('note', 'Nota existente')
        ->assertSet('favoriteId', $favorite->id)
        ->assertSet('isEditing', true)
        ->assertSet('isCreating', false);
});

/* Puede actualizar una nota */
it('can update a note', function () {
    $user = User::factory()->create();
    $favorite = Favorite::factory()->create([
        'user_id' => $user->id,
        'note' => 'Anterior',
    ]);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->set('favoriteId', $favorite->id)
        ->set('note', 'Nota actualizada')
        ->call('updateNote')
        ->assertSet('isEditing', false)
        ->assertSet('favoriteId', null)
        ->assertSet('note', '');

    assertDatabaseHas('favorites', [
        'id' => $favorite->id,
        'note' => 'Nota actualizada',
    ]);
});

/* Puede borrar una nota */
it('can delete a note', function () {
    $user = User::factory()->create();
    $favorite = Favorite::factory()->create([
        'user_id' => $user->id,
        'note' => 'Nota a borrar',
    ]);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->call('deleteNote', $favorite->id);

    assertDatabaseHas('favorites', [
        'id' => $favorite->id,
        'note' => null,
    ]);
});

/* Puede cancelar la edición y restablecer campos */
it('can cancel edit and reset fields', function () {
    $user = User::factory()->create();

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->set('note', 'algo')
        ->set('favoriteId', 123)
        ->set('isEditing', true)
        ->call('cancelEdit')
        ->assertSet('note', '')
        ->assertSet('favoriteId', null)
        ->assertSet('isEditing', false)
        ->assertSet('isCreating', false);
});
