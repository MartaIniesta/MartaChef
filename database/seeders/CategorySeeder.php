<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Postres', 'Pasteles', 'Galletas', 'Cupcakes', 'Tartas',
            'Muffins', 'Brownies', 'Helados', 'Bocadillos', 'Panes',
            'Bizcochos', 'Magdalenas', 'Croissants', 'Dulces', 'Chocolates',
            'Galletas de arroz', 'Tartaletas', 'Mermeladas', 'Salsas', 'Barras de cereal'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
