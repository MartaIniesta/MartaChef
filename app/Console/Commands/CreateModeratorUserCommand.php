<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateModeratorUserCommand extends Command
{
    protected $signature = 'user:create-moderator
                            {--name= : El nombre del usuario}
                            {--email= : El email del usuario}
                            {--password= : La contraseña (opcional, se generará una si no se especifica)}';

    protected $description = 'Crea un nuevo usuario con rol de moderador';

    public function handle()
    {
        $name = $this->option('name') ?? $this->ask('Nombre del usuario');
        $email = $this->option('email') ?? $this->ask('Correo electrónico');
        $password = $this->option('password') ?? Str::random(12);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole('moderator');

        $this->info("✅ Usuario moderador creado:");
        $this->line("Email: $email");
        $this->line("Contraseña: $password");
        $this->line("Rol asignado: moderator");
    }
}
