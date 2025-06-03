<?php

use App\Livewire\Moderator\ModeratorPosts;
use App\Models\{Post, User};
use App\Mail\PostDeletedMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

/* Elimina suavemente una publicación y envía un correo electrónico al propietario de la publicación si existe */
it('soft deletes a post and sends email to post owner if exists', function () {
    Mail::fake();

    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    Livewire::test(ModeratorPosts::class)
        ->call('softDeletePost', $post->id);

    Mail::assertSent(PostDeletedMail::class, function ($mail) use ($post) {
        return $mail->post->id === $post->id &&
            $mail->hasTo($post->user->email);
    });

    $this->assertSoftDeleted('posts', ['id' => $post->id]);
});

/* Restaura una publicación eliminada temporalmente */
it('restores a soft-deleted post', function () {
    $post = Post::factory()->create();
    $post->delete();

    Livewire::test(ModeratorPosts::class)
        ->call('restorePost', $post->id);

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'deleted_at' => null,
    ]);
});

/* Eliminación forzada de una publicación eliminada temporalmente */
it('force deletes a soft-deleted post', function () {
    $post = Post::factory()->create();
    $post->delete();

    Livewire::test(ModeratorPosts::class)
        ->call('forceDeletePost', $post->id);

    $this->assertDatabaseMissing('posts', [
        'id' => $post->id,
    ]);
});

/* Representa la vista de publicaciones del moderador con paginación */
it('renders the moderator posts view with pagination', function () {
    Post::factory()->count(15)->create();

    Livewire::test(ModeratorPosts::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.moderator.moderator-posts')
        ->assertViewHas('posts');
});
