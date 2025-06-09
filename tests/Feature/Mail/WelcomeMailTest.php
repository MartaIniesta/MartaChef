<?php

use App\Mail\WelcomeMail;
use App\Models\User;

it('builds the welcome mail correctly', function () {
    $user = User::factory()->make([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    $mailable = new WelcomeMail($user);
    $built = $mailable->build();

    expect($built->subject)->toBe('¡Bienvenido a MartaChef!')
        ->and($built->view)->toBe('emails.welcome')
        ->and($mailable->user->is($user))->toBeTrue();
});
