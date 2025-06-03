<?php

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use function Pest\Laravel\actingAs;

uses(LazilyRefreshDatabase::class);

it('redirects to dashboard if email is already verified', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    actingAs($user);

    $response = $this->post(route('verification.send'));

    $response->assertRedirect(route('dashboard'));
});
