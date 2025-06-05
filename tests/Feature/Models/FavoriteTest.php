<?php

use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;

it('can create a favorite with a note', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $favorite = Favorite::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'note' => 'Esto es una nota',
    ]);

    expect($favorite)->toBeInstanceOf(Favorite::class)
        ->and($favorite->note)->toBe('Esto es una nota')
        ->and($favorite->user_id)->toBe($user->id)
        ->and($favorite->post_id)->toBe($post->id);
});

it('belongs to a user', function () {
    $user = User::factory()->create();
    $favorite = Favorite::factory()->create(['user_id' => $user->id]);

    expect($favorite->user)->toBeInstanceOf(User::class)
        ->and($favorite->user->is($user))->toBeTrue();
});

it('belongs to a post', function () {
    $post = Post::factory()->create();
    $favorite = Favorite::factory()->create(['post_id' => $post->id]);

    expect($favorite->post)->toBeInstanceOf(Post::class)
        ->and($favorite->post->is($post))->toBeTrue();
});

it('has fillable attributes', function () {
    $favorite = new Favorite();

    expect($favorite->getFillable())->toBe([
        'user_id', 'post_id', 'note',
    ]);
});
