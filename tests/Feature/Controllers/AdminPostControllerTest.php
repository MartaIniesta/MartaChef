<?php

use App\Models\Post;
use App\Models\User;
use Database\Seeders\RolesSeeder;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

it('allows admin to view all posts, including soft deleted posts', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $post = Post::factory()->create();
    $softDeletedPost = Post::factory()->create();
    $softDeletedPost->delete();

    $response = $this->actingAs($admin)->get(route('admin.posts'));

    $response->assertStatus(200);
    $response->assertViewIs('admin.admin-posts-index');
    $response->assertSee($post->title);
    $response->assertSee($softDeletedPost->title);
});

it('allows admin to soft delete a post', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $post = Post::factory()->create();

    $response = $this->actingAs($admin)->delete(route('admin.posts.softDelete', $post->id));

    $response->assertRedirect(route('admin.posts'));
    $response->assertSessionHas('success', 'Post eliminado temporalmente.');

    $this->assertSoftDeleted($post);
});

it('allows admin to restore a soft deleted post', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $post = Post::factory()->create();
    $post->delete();

    $response = $this->actingAs($admin)->patch(route('admin.posts.restore', $post->id));

    $response->assertRedirect(route('admin.posts'));
    $response->assertSessionHas('success', 'Post restaurado correctamente.');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'deleted_at' => null
    ]);
});

it('allows admin to permanently delete a post', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $post = Post::factory()->create();
    $post->delete();  // Soft delete

    $response = $this->actingAs($admin)->delete(route('admin.posts.forceDelete', $post->id));

    $response->assertRedirect(route('admin.posts'));
    $response->assertSessionHas('success', 'Post eliminado permanentemente.');

    $this->assertDatabaseMissing('posts', [
        'id' => $post->id,
    ]);
});

it('prevents non-admin users from accessing post actions', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $response = $this->actingAs($user)->get(route('admin.posts'));

    $response->assertStatus(403);
});
