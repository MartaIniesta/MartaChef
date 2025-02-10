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
        $paqui = User::create([
            'name' => 'Paqui',
            'email' => 'paqui@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $antonio = User::create([
            'name' => 'Antonio',
            'email' => 'antonio@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $maria = User::create([
            'name' => 'Maria',
            'email' => 'maria@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $david = User::create([
            'name' => 'David',
            'email' => 'david@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $antonio->followers()->attach($paqui);

        $this->call(CategorySeeder::class);
        $this->call(PostSeeder::class);
    }
}
