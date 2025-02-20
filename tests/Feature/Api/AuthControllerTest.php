<?php

use App\Models\User;

it('registers a new user successfully', function () {
    // Arrange
    $data = [
        'name' => 'test',
        'email' => 'test@example.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ];

    // Act
    $response = $this->postJson(route('api.register', $data));

    // Assert
    $response->assertStatus(200)
        ->assertJsonStructure(['message', 'token']);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});

it('returns validation errors when registering with invalid data', function () {
    // Arrange
    $data = [
        'name'  => 'test',
        'email' => 'testexample',
        'password' => '12345678',
        'password_confirmation' => '87654321',
    ];

    // Act
    $response = $this->postJson(route('api.register', $data));

    // Assert
    $response->assertStatus(422)
        ->assertJsonStructure(['message', 'errors']);
});

it('login successfully', function () {
    // Arrange
    $password = '12345678';
    $user = User::factory()->create([
        'password' => bcrypt($password),
    ]);

    $data = [
        'email' => $user->email,
        'password' => $password,
    ];

    // Act
    $response = $this->postJson(route('api.login', $data));

    // Assert
    $response->assertStatus(200)
        ->assertJsonStructure(['access_token', 'token_type']);
});

it('fails to login with invalid credentials', function () {
    // Arrange
    $password = '12345678';
    $user = User::factory()->create([
        'password' => bcrypt($password),
    ]);

    $data = [
        'email' => $user->email,
        'password' => '87654321',
    ];

    // Act
    $response = $this->postJson(route('api.login', $data));

    // Assert
    $response->assertStatus(401)
        ->assertJson(['message' => 'Credenciales incorrectas']);
});
