<?php

use App\Livewire\Moderator\ModeratorComments;
use App\Models\Comment;
use Livewire\Livewire;

use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\assertDatabaseMissing;

/* Elimina suavemente un comentario y sus respuestas */
it('soft deletes a comment and its replies', function () {
    $parent = Comment::factory()->create();
    $reply1 = Comment::factory()->create(['parent_id' => $parent->id]);
    $reply2 = Comment::factory()->create(['parent_id' => $parent->id]);

    Livewire::test(ModeratorComments::class)
        ->call('softDeleteComment', $parent->id);

    assertSoftDeleted('comments', ['id' => $parent->id]);
    assertSoftDeleted('comments', ['id' => $reply1->id]);
    assertSoftDeleted('comments', ['id' => $reply2->id]);
});

/* Restaura un comentario eliminado temporalmente y sus respuestas */
it('restores a soft-deleted comment and its replies', function () {
    $parent = Comment::factory()->create();
    $reply = Comment::factory()->create(['parent_id' => $parent->id]);

    $parent->delete();
    $reply->delete();

    Livewire::test(ModeratorComments::class)
        ->call('restoreComment', $parent->id);

    expect(Comment::find($parent->id))->not->toBeNull()
        ->and(Comment::find($reply->id))->not->toBeNull();
});

/* Elimina permanentemente un comentario y sus respuestas */
it('permanently deletes a comment and its replies', function () {
    $parent = Comment::factory()->create();
    $reply = Comment::factory()->create(['parent_id' => $parent->id]);

    $parent->delete();
    $reply->delete();

    Livewire::test(ModeratorComments::class)
        ->call('forceDeleteComment', $parent->id);

    assertDatabaseMissing('comments', ['id' => $parent->id]);
    assertDatabaseMissing('comments', ['id' => $reply->id]);
});

/* Elimina comentarios con más de 3 meses de antigüedad */
it('deletes comments older than 3 months', function () {
    $old = Comment::factory()->create(['created_at' => now()->subMonths(4)]);
    $recent = Comment::factory()->create(['created_at' => now()->subWeek()]);

    Livewire::test(ModeratorComments::class)
        ->call('deleteOldComments');

    expect(Comment::find($old->id))->toBeNull()
        ->and(Comment::find($recent->id))->not->toBeNull();
});


/* Representa la vista de comentarios del moderador con paginación */
it('renders the moderator comments view with pagination', function () {
    Comment::factory()->count(15)->create();

    Livewire::test(ModeratorComments::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.moderator.moderator-comments')
        ->assertViewHas('comments');
});
