<?php

use Database\Seeders\RolesSeeder;
use App\Jobs\SendWelcomeMailJob;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

it('registers a new user and redirects to blog', function () {
    Event::fake();
    Queue::fake();

    $formData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->post('/register', $formData);

    $user = User::where('email', 'test@example.com')->first();
    expect($user)->not()->toBeNull()
        ->and(Hash::check('password123', $user->password))->toBeTrue()
        ->and($user->hasRole('user'))->toBeTrue();

    $this->assertAuthenticatedAs($user);

    Queue::assertPushed(SendWelcomeMailJob::class, function ($job) use ($user) {
        return $job->user->is($user);
    });

    Event::assertDispatched(Registered::class, function ($event) use ($user) {
        return $event->user->is($user);
    });

    $response->assertRedirect(route('blog'));
});
