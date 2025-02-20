<?php

use App\Models\Post;

it('deletes permanently all soft deleted posts', function () {
    $post1 = Post::factory()->create();
    $post2 = Post::factory()->create();

    $post1->delete();
    $post2->delete();

    expect($post1->fresh()->deleted_at)->not()->toBeNull()
        ->and($post2->fresh()->deleted_at)->not()->toBeNull();

    $exitCode = Artisan::call('posts:cleanup-deleted');

    expect($exitCode)->toEqual(0)
        ->and(Artisan::output())->toContain("Se han eliminado permanentemente 2 recetas.")
        ->and(Post::find($post1->id))->toBeNull()
        ->and(Post::find($post2->id))->toBeNull();
});

it('reports no deleted posts when none exist', function () {
    Post::onlyTrashed()->delete();

    $exitCode = Artisan::call('posts:cleanup-deleted');

    $output = Artisan::output();

    expect($exitCode)->toEqual(0)
        ->and($output)->toContain("No se encontraron recetas eliminadas para eliminarlas permanentemente.");
});

it('does not delete posts that are not soft deleted', function () {
    $post = Post::factory()->create();

    $exitCode = Artisan::call('posts:cleanup-deleted');

    expect($exitCode)->toEqual(0)
        ->and(Post::find($post->id))->not()->toBeNull();
});
