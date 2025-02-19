<?php

use App\Models\User;
use App\Policies\UserPolicy;
use Database\Seeders\RolesSeeder;

beforeEach(function () {
    $this->seed(RolesSeeder::class);

    $this->userWithPermission = User::factory()->create();
    $this->userWithoutPermission = User::factory()->create();

    $this->userWithPermission->givePermissionTo('follow-users', 'unfollow-users');
});

/* Verificar que el usuario con permiso pueda seguir */
test('User can follow if they have permission', function () {
    // Arrange
    $policy = new UserPolicy();

    // Act
    $canFollow = $policy->follow($this->userWithPermission);

    // Assert
    expect($canFollow)->toBeTrue();
});

/* Verificar que el usuario sin permiso no pueda seguir */
test('User cannot follow if they do not have permission', function () {
    // Arrange
    $policy = new UserPolicy();

    // Act
    $canFollow = $policy->follow($this->userWithoutPermission);

    // Assert
    expect($canFollow)->toBeFalse();
});

/* Verificar que el usuario con permiso pueda dejar de seguir */
test('User can unfollow if they have permission', function () {
    // Arrange
    $policy = new UserPolicy();

    // Act
    $canUnfollow = $policy->unfollow($this->userWithPermission);

    // Assert
    expect($canUnfollow)->toBeTrue();
});

/* Verificar que el usuario sin permiso no pueda dejar de seguir */
test('User cannot unfollow if they do not have permission', function () {
    // Arrange
    $policy = new UserPolicy();

    // Act
    $canUnfollow = $policy->unfollow($this->userWithoutPermission);

    // Assert
    expect($canUnfollow)->toBeFalse();
});
