<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Fácil',
                'Rápido',
                'Chocolate',
                'Frutas',
                'Sin Gluten',
                'Vegano',
                'Clásico'
            ]),
        ];
    }
}
