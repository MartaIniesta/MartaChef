<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph(),
            'ingredients' => $this->faker->paragraph(),
            'image' => $this->faker->imageUrl(640, 480, 'food', true, 'dessert'),
        ];
    }
}
