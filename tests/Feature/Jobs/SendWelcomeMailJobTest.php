<?php

use App\Jobs\SendWelcomeMailJob;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

it('sends welcome mail to the user', function () {
    Mail::fake();

    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    (new SendWelcomeMailJob($user))->handle();

    Mail::assertSent(WelcomeMail::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email) && $mail->user->is($user);
    });
});
