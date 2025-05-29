<?php

use App\Models\Post;
use App\Models\User;
use Database\Seeders\RolesSeeder;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

it('prevents non-admin users from accessing post actions', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $response = $this->actingAs($user)->get(route('admin.posts'));

    $response->assertStatus(403);
});
