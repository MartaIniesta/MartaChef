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
