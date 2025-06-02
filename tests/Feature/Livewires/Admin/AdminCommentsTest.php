<?php

use App\Livewire\Admin\AdminComments;
use App\Models\Comment;
use Livewire\Livewire;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

/* Elimina suavemente un comentario y sus respuestas. */
it('soft deletes a comment and its replies', function () {
    $parent = Comment::factory()->create();
    $reply = Comment::factory()->create(['parent_id' => $parent->id]);

    Livewire::test(AdminComments::class)
        ->call('softDeleteComment', $parent->id);

    expect(Comment::withTrashed()->find($parent->id)->trashed())->toBeTrue()
        ->and(Comment::withTrashed()->find($reply->id)->trashed())->toBeTrue();
});

/* Restaura un comentario eliminado temporalmente y sus respuestas. */
it('restores a soft deleted comment and its replies', function () {
    $parent = Comment::factory()->create();
    $reply = Comment::factory()->create(['parent_id' => $parent->id]);

    $parent->delete();
    $reply->delete();

    Livewire::test(AdminComments::class)
        ->call('restoreComment', $parent->id);

    expect(Comment::find($parent->id))->not->toBeNull()
        ->and(Comment::find($reply->id))->not->toBeNull();
});

/* Elimina definitivamente un comentario y sus respuestas. */
it('force deletes a comment and its replies', function () {
    $parent = Comment::factory()->create();
    $reply = Comment::factory()->create(['parent_id' => $parent->id]);

    $parent->delete();
    $reply->delete();

    Livewire::test(AdminComments::class)
        ->call('forceDeleteComment', $parent->id);

    expect(Comment::withTrashed()->find($parent->id))->toBeNull()
        ->and(Comment::withTrashed()->find($reply->id))->toBeNull();
});

/* Edita y actualiza el contenido de un comentario */
it('edits and updates a comment content', function () {
    $comment = Comment::factory()->create(['content' => 'Old content']);

    Livewire::test(AdminComments::class)
        ->call('editComment', $comment->id)
        ->set('editingContent', 'Updated content')
        ->call('updateComment');

    expect(Comment::find($comment->id)->content)->toBe('Updated content');
});

/* Valida el contenido del comentario antes de actualizar */
it('validates comment content before update', function () {
    $comment = Comment::factory()->create();

    Livewire::test(AdminComments::class)
        ->call('editComment', $comment->id)
        ->set('editingContent', '') // invalid
        ->call('updateComment')
        ->assertHasErrors(['editingContent' => 'required']);
});

/* Cancela la edición del comentario correctamente */
it('cancels comment edit properly', function () {
    Livewire::test(AdminComments::class)
        ->set('editingCommentId', 5)
        ->set('editingContent', 'test')
        ->call('cancelEdit')
        ->assertSet('editingCommentId', null)
        ->assertSet('editingContent', '');
});

/* Muestra un mensaje cuando se eliminan los comentarios antiguos */
it('shows message when old comments are deleted', function () {
    Comment::factory()->count(3)->create([
        'created_at' => Carbon::now()->subMonths(4),
    ]);

    Livewire::test(AdminComments::class)
        ->call('deleteOldComments')
        ->assertSet('deleteMessage', __('Old comments have been deleted.'));

    expect(Comment::count())->toBe(0);
});

/* Muestra un mensaje cuando no hay comentarios antiguos */
it('shows message when there are no old comments', function () {
    Comment::factory()->count(3)->create([
        'created_at' => Carbon::now()->subMonth(),
    ]);

    Livewire::test(AdminComments::class)
        ->call('deleteOldComments')
        ->assertSet('deleteMessage', __('There are no comments older than 3 months.'));

    expect(Comment::count())->toBe(3);
});
