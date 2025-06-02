<?php

use Livewire\Livewire;
use App\Livewire\Admin\AdminPosts;
use App\Models\{Post, User};
use App\Mail\PostDeletedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

/* Representa el componente de publicaciones de administración */
it('renders the admin posts component', function () {
    Livewire::test(AdminPosts::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.admin.admin-posts');
});

/* Elimina suavemente una publicación y envía un correo electrónico si el usuario existe */
it('soft deletes a post and sends email if user exists', function () {
    Mail::fake();

    $user = User::factory()->create(['email' => 'test@example.com']);
    $post = Post::factory()->create(['user_id' => $user->id]);

    Livewire::test(AdminPosts::class)
        ->call('softDeletePost', $post->id);

    expect(Post::withTrashed()->find($post->id)->trashed())->toBeTrue();

    Mail::assertSent(PostDeletedMail::class, fn ($mail) =>
    $mail->hasTo($user->email)
    );
});

/* Elimina suavemente una publicación sin enviar correo electrónico si el usuario no existe */
it('soft deletes a post without sending email if user does not exist', function () {
    Mail::fake();

    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $user->delete();

    Livewire::test(AdminPosts::class)
        ->call('softDeletePost', $post->id);

    expect(Post::withTrashed()->find($post->id)->trashed())->toBeTrue();

    Mail::assertNothingSent();
});

/* Restaura una publicación eliminada temporalmente */
it('restores a soft deleted post', function () {
    $post = Post::factory()->create();
    $post->delete();

    expect($post->fresh()->trashed())->toBeTrue();

    Livewire::test(AdminPosts::class)
        ->call('restorePost', $post->id);

    expect(Post::find($post->id))->not->toBeNull()
        ->and(Post::find($post->id)->trashed())->toBeFalse();
});

/* Elimina un post permanentemente */
it('permanently deletes a post', function () {
    $post = Post::factory()->create();
    $post->delete();

    Livewire::test(AdminPosts::class)
        ->call('forceDeletePost', $post->id);

    expect(Post::withTrashed()->find($post->id))->toBeNull();
});
