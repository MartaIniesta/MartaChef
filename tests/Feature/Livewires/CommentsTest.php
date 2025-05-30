<?php

use App\Models\{User, Comment, Post};
use Database\Seeders\RolesSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesSeeder::class);

    $this->user = User::factory()->create();
    $this->admin = User::factory()->create();
    $this->moderator = User::factory()->create();
    $this->anotherUser = User::factory()->create();

    $this->admin->assignRole('admin');
    $this->moderator->assignRole('moderator');
    $this->user->assignRole('user');

    $this->post = Post::factory()->create();

    $this->comment = Comment::factory()->create([
        'post_id' => $this->post->id,
        'user_id' => $this->user->id,
    ]);
});

it('users with permission can create a comment', function () {
    expect($this->user->can('create-comments'))->toBeTrue()
        ->and($this->admin->can('create-comments'))->toBeTrue();

    Livewire::actingAs($this->user)
        ->test('App\Livewire\Comments', ['postId' => $this->post->id])
        ->set('content', 'Comentario de usuario.')
        ->call('addComment')
        ->assertOk();

    Livewire::actingAs($this->admin)
        ->test('App\Livewire\Comments', ['postId' => $this->post->id])
        ->set('content', 'Comentario de admin.')
        ->call('addComment')
        ->assertOk();
});

it('users with permission can reply to a comment', function () {
    expect($this->user->can('reply-comments'))->toBeTrue()
        ->and($this->admin->can('reply-comments'))->toBeTrue();

    Livewire::actingAs($this->admin)
        ->test('App\Livewire\Comments', ['postId' => $this->post->id])
        ->call('replyToComment', $this->comment->id)
        ->set('replyContent', 'This is a reply')
        ->call('addReply')
        ->assertOk();

    $this->assertDatabaseHas('comments', [
        'post_id' => $this->post->id,
        'parent_id' => $this->comment->id,
        'content' => 'This is a reply'
    ]);

    Livewire::actingAs($this->user)
        ->test('App\Livewire\Comments', ['postId' => $this->post->id])
        ->call('replyToComment', $this->comment->id)
        ->set('replyContent', 'This is my reply.')
        ->call('addReply')
        ->assertOk();

    $this->assertDatabaseHas('comments', [
        'post_id' => $this->post->id,
        'parent_id' => $this->comment->id,
        'content' => 'This is my reply.'
    ]);
});

it('loads more comments correctly', function () {
    Comment::factory(10)->create(['post_id' => $this->post->id]);

    Livewire::actingAs($this->user)
        ->test('App\Livewire\Comments', ['postId' => $this->post->id])
        ->call('loadMoreComments')
        ->assertOk();
});

it('loads more replies correctly', function () {
    $parentComment = Comment::factory()->create(['post_id' => $this->post->id]);
    Comment::factory(5)->create([
        'post_id' => $this->post->id,
        'parent_id' => $parentComment->id
    ]);

    Livewire::actingAs($this->user)
        ->test('App\Livewire\Comments', ['postId' => $this->post->id])
        ->call('loadMoreReplies', $parentComment->id)
        ->assertOk();
});
