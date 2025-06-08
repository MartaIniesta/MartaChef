<?php

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
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

it('sends verification email if user is not verified', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    actingAs($user);

    Notification::fake();

    $response = $this->post(route('verification.send'));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'verification-link-sent');

    Notification::assertSentTo(
        $user, VerifyEmail::class
    );
});

it('does not send verification email if already verified', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    actingAs($user);

    Notification::fake();

    $response = $this->post(route('verification.send'));

    $response->assertRedirect(route('dashboard'));

    Notification::assertNothingSent();
});
