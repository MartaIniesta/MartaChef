<?php

use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

it('creates an admin user with provided name, email and password', function () {
    $name = 'Admin User';
    $email = 'admin@example.com';
    $password = 'securePassword123';

    $this->artisan('user:create-admin', [
        '--name' => $name,
        '--email' => $email,
        '--password' => $password,
    ])
        ->expectsOutputToContain('✅ Usuario administrador creado:')
        ->expectsOutputToContain("Email: $email")
        ->expectsOutputToContain("Rol asignado: admin")
        ->assertExitCode(0);

    $this->assertDatabaseHas('users', [
        'email' => $email,
        'name' => $name,
    ]);

    $user = User::where('email', $email)->first();
    expect(Hash::check($password, $user->password))->toBeTrue()
        ->and($user->hasRole('admin'))->toBeTrue();
});

it('creates an admin user with generated password if none provided', function () {
    $email = 'generated@example.com';
    $name = 'Generated User';

    $this->artisan('user:create-admin', [
        '--name' => $name,
        '--email' => $email,
    ])
        ->expectsOutputToContain('✅ Usuario administrador creado:')
        ->expectsOutputToContain("Email: $email")
        ->expectsOutputToContain("Rol asignado: admin")
        ->assertExitCode(0);

    $user = User::where('email', $email)->first();
    expect($user)->not->toBeNull()
        ->and($user->hasRole('admin'))->toBeTrue();
});

it('asks for name, email, and generates password when no options are passed', function () {
    $name = 'Prompted Admin';
    $email = 'prompted@example.com';

    $this->artisan('user:create-admin')
        ->expectsQuestion('Nombre del usuario', $name)
        ->expectsQuestion('Correo electrónico', $email)
        ->expectsOutputToContain('✅ Usuario administrador creado:')
        ->expectsOutputToContain("Email: $email")
        ->expectsOutputToContain("Rol asignado: admin")
        ->assertExitCode(0);

    $user = User::where('email', $email)->first();
    expect($user)->not->toBeNull()
        ->and($user->name)->toBe($name)
        ->and($user->hasRole('admin'))->toBeTrue();
});
