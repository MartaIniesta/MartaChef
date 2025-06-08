<?php

use App\Models\{Comment, Post, User, Category, Tag};
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\{Event, Storage};
use App\Jobs\SendPostNotificationJob;
use App\Events\PostCreatedEvent;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\{delete, get, post, put};

uses(LazilyRefreshDatabase::class);

it('show public posts correctly', function () {
    Post::factory()->count(15)->create(['visibility' => 'public']);
    $response = get(route('posts.recipes'));
    $response->assertStatus(200)
        ->assertViewHas('publicPosts', fn($p) => $p->count() === 12);
});

it('show posts individually', function () {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();
    $post->tags()->attach(Tag::factory()->create());
    Comment::factory()->for($post)->create(['parent_id' => null])
        ->each(fn($c) => Comment::factory()->for($post)->create(['parent_id' => $c->id]));

    actingAs($user);
    $response = get(route('posts.show', $post));
    $response->assertStatus(200)
        ->assertViewHasAll(['post', 'comments']);
});

it('filter my posts by visibility', function () {
    $user = User::factory()->create();
    actingAs($user);

    Post::factory()->for($user)->create(['visibility' => 'public']);
    Post::factory()->for($user)->create(['visibility' => 'private']);

    $response = get(route('posts.myPosts', ['visibility' => 'public']));

    $response->assertViewHas('userPosts', function ($paginator) {
        return $paginator->getCollection()->every(fn($post) => $post->visibility === 'public');
    })->assertViewHas('visibility', 'public');
});

it('shows shared posts', function () {
    $user = User::factory()->create();
    actingAs($user);
    Post::factory()->count(2)->create(['visibility' => 'shared']);
    $response = get(route('posts.shared'));
    $response->assertStatus(200)
        ->assertViewHas('sharedPosts');
});

it('create posts and trigger events/jobs', function () {
    Bus::fake();
    Event::fake();
    Storage::fake('public');

    $user = User::factory()->create();

    $permission = Permission::firstOrCreate(['name' => 'create-posts']);
    $user->givePermissionTo($permission);

    $cats = Category::factory()->count(2)->create();
    actingAs($user);

    $file = UploadedFile::fake()->image('receta.jpg');
    $payload = [
        'title' => 'Titulo',
        'description' => 'Desc',
        'ingredients' => 'Ing',
        'visibility' => 'public',
        'image' => $file,
        'categories' => $cats->pluck('id')->toArray(),
        'tags' => 'uno dos'
    ];

    $response = post(route('posts.store'), $payload);
    $response->assertRedirect(route('blog'))
        ->assertSessionHas('status');

    $this->assertDatabaseHas('posts', ['title' => 'Titulo']);
    $this->assertDatabaseCount('post_tag', 2);
    Storage::disk('public')->assertExists('images/receta.jpg');
    Event::assertDispatched(PostCreatedEvent::class);
    Bus::assertDispatched(SendPostNotificationJob::class);
});

it('edit posts', function () {
    $user = User::factory()->create();

    $permission = Permission::firstOrCreate(['name' => 'edit-posts']);
    $user->givePermissionTo($permission);

    $post = Post::factory()->for($user)->create();
    Category::factory()->count(2)->create();
    actingAs($user);

    $response = get(route('posts.edit', $post));
    $response->assertStatus(200)
        ->assertViewHasAll(['post', 'categories', 'selectedCategories']);
});

it('update posts', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $permission = Permission::firstOrCreate(['name' => 'edit-posts']);
    $user->givePermissionTo($permission);

    $post = Post::factory()->for($user)->create(['image' => 'images/existing.jpg']);
    $cats = Category::factory()->count(2)->create();
    actingAs($user);

    $file = UploadedFile::fake()->image('nuevo.jpg');
    $payload = [
        'title' => 'Nuevo',
        'description' => 'Desc2',
        'ingredients' => 'Ing2',
        'visibility' => 'private',
        'categories' => $cats->pluck('id')->toArray(),
        'tags' => 'tres cuatro',
        'image' => $file,
    ];

    $response = put(route('posts.update', $post), $payload);
    $response->assertRedirect(route('posts.show', $post))
        ->assertSessionHas('status');

    $post->refresh();

    expect($post->title)->toBe('Nuevo');
    Storage::disk('public')->assertExists('images/nuevo.jpg');
    expect($post->tags()->count())->toBe(2);
});

it('delete a post and redirect', function () {
    $user = User::factory()->create();
    $permission = Permission::firstOrCreate(['name' => 'delete-posts']);
    $user->givePermissionTo($permission);

    $post = Post::factory()->for($user)->create();
    actingAs($user);

    $response = delete(route('posts.destroy', $post));
    $response->assertRedirect(route('blog'))
        ->assertSessionHas('status');

    $this->assertSoftDeleted($post);
});
