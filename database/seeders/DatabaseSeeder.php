<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);

        $paqui = User::create([
            'name' => 'Paqui',
            'email' => 'paqui@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $paqui->assignRole('user');

        $antonio = User::create([
            'name' => 'Antonio',
            'email' => 'antonio@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $antonio->assignRole('user');

        $maria = User::create([
            'name' => 'Maria',
            'email' => 'maria@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $maria->assignRole('user');

        $david = User::create([
            'name' => 'David',
            'email' => 'david@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $david->assignRole('moderator');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $admin->assignRole('admin');

        $antonio->followers()->attach($paqui);

        $this->call(CategorySeeder::class);
        $this->call(PostSeeder::class);
    }
}
