<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Pasteles', 'Tartas', 'Brownie', 'Cupcakes', 'Galletas',
            'Bizcochos', 'Desayunos', 'Panes Dulces', 'Postres Fritos', 'Postres Saludables',
            'Reposteria Internacional', 'Postres Sin Horno', 'Postres Fríos', 'Helado'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
