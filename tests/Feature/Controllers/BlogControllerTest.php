<?php

use App\Models\{Category, Post, Rating, User};

/* Asigna cada categoría a la publicación pública con la calificación más alta */
it('maps each category to the highest rated public post', function () {
    $categories = Category::factory()->count(3)->create([
        'name' => 'Tartas',
    ]);
    $categories[1]->update(['name' => 'Bizcochos']);
    $categories[2]->update(['name' => 'Galletas']);

    $user = User::factory()->create();

    foreach ($categories as $category) {
        $post1 = Post::factory()->create(['visibility' => 'public']);
        $post2 = Post::factory()->create(['visibility' => 'public']);

        $category->posts()->attach([$post1->id, $post2->id]);

        Rating::factory()->create(['post_id' => $post1->id, 'user_id' => $user->id, 'rating' => 3]);
        Rating::factory()->create(['post_id' => $post2->id, 'user_id' => $user->id, 'rating' => 5]);
    }

    $response = $this->get(route('blog'));

    $response->assertStatus(200);

    $categoryPosts = $response->viewData('categoryPosts');

    foreach ($categories as $category) {
        $post = $categoryPosts[$category->name];
        expect($post)->not->toBeNull()
            ->and($post->ratings_avg_rating)->toEqualWithDelta(5, 0.01)
            ->and($post->categories->contains($category->id))->toBeTrue();
    }
});
