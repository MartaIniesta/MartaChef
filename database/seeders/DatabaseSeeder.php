<?php

namespace Database\Seeders;

use App\Models\Post;
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

        Post::create([
            'title' => 'Tarta de Chocolate',
            'description' => 'Receta perfecta para una tarta de chocolate cremosa y húmeda.',
            'ingredients' => 'Harina, cacao en polvo, huevos, azúcar, leche, mantequilla',
            'image' => 'pastel-chocolate.jpg',
            'user_id' => $user->id,
        ]);

        Post::create([
            'title' => 'Cupcakes de Vainilla',
            'description' => 'Estos cupcakes son ideales para cualquier celebración.',
            'ingredients' => 'Harina, azúcar, mantequilla, esencia de vainilla, huevos, leche',
            'image' => 'cupcakes-vainilla.jpg',
            'user_id' => $user->id,
        ]);
    }
}
