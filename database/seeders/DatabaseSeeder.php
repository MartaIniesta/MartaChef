<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategorySeeder::class);
        Tag::factory(10)->create();

        User::factory()->create([
            'name' => 'Paqui',
            'email' => 'paqui@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $user = User::first();

        if (!$user) {
            $user = User::factory()->create(['name' => 'Usuario Admin']);
        }

        Post::factory(5)->create()->each(function ($post) {
            $categories = Category::all()->random(rand(1, 4))->pluck('id');
            $post->categories()->attach($categories);

            $tags = Tag::all()->random(rand(2, 5))->pluck('id');
            $post->tags()->attach($tags);

            $comments = Comment::factory(rand(1, 3))->create(['post_id' => $post->id]);

            $comments->each(function ($comment) {
                Comment::factory(rand(1, 2))->asReply($comment->id)->create(['post_id' => $comment->post_id]);
            });
        });
    }
}
