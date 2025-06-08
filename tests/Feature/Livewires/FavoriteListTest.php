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

    $user->favoritePosts()->attach($post1->id, ['note' => 'Mi nota']);
    $otherUser->favoritePosts()->attach($post2->id, ['note' => 'No debería cargarse']);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->assertViewHas('favorites', function ($favorites) use ($post1) {
            return $favorites->count() === 1 && $favorites->first()->id === $post1->id;
        });
});

/* Puede empezar a crear una nueva nota */
it('can start creating a new note', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $user->favoritePosts()->attach($post->id, ['note' => null]);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->call('startCreating', $post->id)
        ->assertSet('creatingNoteForPostId', $post->id)
        ->assertSet('note', '')
        ->assertSet('editingNoteForPostId', null);
});

/* Puede crear una nota */
it('can create a note', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $user->favoritePosts()->attach($post->id, ['note' => null]);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->set('creatingNoteForPostId', $post->id)
        ->set('note', 'Nueva nota')
        ->call('createNote')
        ->assertSet('creatingNoteForPostId', null)
        ->assertSet('note', '');

    $this->assertDatabaseHas('favorites', [
        'user_id' => $user->id,
        'post_id' => $post->id,
        'note' => 'Nueva nota',
    ]);
});

/* No crea una nota si está vacía */
it('does not create a note if empty', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $user->favoritePosts()->attach($post->id, ['note' => null]);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->set('creatingNoteForPostId', $post->id)
        ->set('note', '')
        ->call('createNote')
        ->assertHasErrors(['note' => 'required']);

    $this->assertDatabaseHas('favorites', [
        'user_id' => $user->id,
        'post_id' => $post->id,
        'note' => null,
    ]);
});

/* Puede editar una nota existente */
it('can edit an existing note', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $user->favoritePosts()->attach($post->id, ['note' => 'Nota existente']);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->call('editNote', $post->id)
        ->assertSet('note', 'Nota existente')
        ->assertSet('editingNoteForPostId', $post->id)
        ->assertSet('creatingNoteForPostId', null);
});

/* Puede actualizar una nota */
it('can update a note', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $user->favoritePosts()->attach($post->id, ['note' => 'Anterior']);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->set('editingNoteForPostId', $post->id)
        ->set('note', 'Nota actualizada')
        ->call('updateNote')
        ->assertSet('editingNoteForPostId', null)
        ->assertSet('creatingNoteForPostId', null)
        ->assertSet('note', '');

    $this->assertDatabaseHas('favorites', [
        'user_id' => $user->id,
        'post_id' => $post->id,
        'note' => 'Nota actualizada',
    ]);
});

/* Puede borrar una nota */
it('can delete a note', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $user->favoritePosts()->attach($post->id, ['note' => 'Nota a borrar']);

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->call('deleteNote', $post->id);

    $this->assertDatabaseHas('favorites', [
        'user_id' => $user->id,
        'post_id' => $post->id,
        'note' => null,
    ]);
});

/* Puede cancelar la edición y restablecer campos */
it('can cancel edit and reset fields', function () {
    $user = User::factory()->create();

    actingAs($user);

    Livewire::test(FavoriteList::class)
        ->set('note', 'algo')
        ->set('editingNoteForPostId', 123)
        ->call('cancelEdit')
        ->assertSet('note', '')
        ->assertSet('editingNoteForPostId', null)
        ->assertSet('creatingNoteForPostId', null);
});
