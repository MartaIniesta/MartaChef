<?php

use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

it('creates a moderator user with provided name, email and password', function () {
    $name = 'Moderator User';
    $email = 'moderator@example.com';
    $password = 'secureModerator123';

    $this->artisan('user:create-moderator', [
        '--name' => $name,
        '--email' => $email,
        '--password' => $password,
    ])
        ->expectsOutputToContain('✅ Usuario moderador creado:')
        ->expectsOutputToContain("Email: $email")
        ->expectsOutputToContain("Rol asignado: moderator")
        ->assertExitCode(0);

    $user = User::where('email', $email)->first();

    expect($user)->not->toBeNull()
        ->and($user->name)->toBe($name)
        ->and(Hash::check($password, $user->password))->toBeTrue()
        ->and($user->hasRole('moderator'))->toBeTrue();
});

it('creates a moderator user with generated password if none provided', function () {
    $name = 'AutoPass Moderator';
    $email = 'autopass@example.com';

    $this->artisan('user:create-moderator', [
        '--name' => $name,
        '--email' => $email,
    ])
        ->expectsOutputToContain('✅ Usuario moderador creado:')
        ->expectsOutputToContain("Email: $email")
        ->expectsOutputToContain("Rol asignado: moderator")
        ->assertExitCode(0);

    $user = User::where('email', $email)->first();
    expect($user)->not->toBeNull()
        ->and($user->hasRole('moderator'))->toBeTrue();
});

it('asks for name, email and generates password when no options are passed', function () {
    $name = 'Prompted Moderator';
    $email = 'promptedmod@example.com';

    $this->artisan('user:create-moderator')
        ->expectsQuestion('Nombre del usuario', $name)
        ->expectsQuestion('Correo electrónico', $email)
        ->expectsOutputToContain('✅ Usuario moderador creado:')
        ->expectsOutputToContain("Email: $email")
        ->expectsOutputToContain("Rol asignado: moderator")
        ->assertExitCode(0);

    $user = User::where('email', $email)->first();
    expect($user)->not->toBeNull()
        ->and($user->name)->toBe($name)
        ->and($user->hasRole('moderator'))->toBeTrue();
});
