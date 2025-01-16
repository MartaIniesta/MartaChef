<?php

namespace Database\Seeders;

use App\Models\Category;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Paqui',
            'email' => 'paqui@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $user = User::first();

        if (!$user) {
            $user = User::factory()->create(['name' => 'Usuario Admin']);
        }

        $tags = Tag::factory(10)->create();
        // Crear los posts
        $post1 = Post::create([
            'title' => 'Tarta de Chocolate',
            'description' => 'Receta perfecta para una tarta de chocolate cremosa y húmeda.',
            'ingredients' => 'Harina, cacao en polvo, huevos, azúcar, leche, mantequilla',
            'image' => 'pastel-chocolate.jpg',
            'user_id' => $user->id,
        ]);

        $post2 = Post::create([
            'title' => 'Cupcakes de Vainilla',
            'description' => 'Estos cupcakes son ideales para cualquier celebración.',
            'ingredients' => 'Harina, azúcar, mantequilla, esencia de vainilla, huevos, leche',
            'image' => 'cupcakes-vainilla.jpg',
            'user_id' => $user->id,
        ]);

        $chocolateCategory = Category::where('name', 'Chocolates')->first();
        $postreCategory = Category::where('name', 'Postres')->first();

        if ($chocolateCategory && $postreCategory) {
            $post1->categories()->attach([$chocolateCategory->id, $postreCategory->id]);
            $post2->categories()->attach($postreCategory->id);
        }

        $post1->tags()->attach(
            $tags->random(rand(2, 5))->pluck('id')->toArray()
        );

        $post2->tags()->attach(
            $tags->random(rand(2, 5))->pluck('id')->toArray()
        );
    }
}
