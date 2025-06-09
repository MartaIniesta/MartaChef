<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Notifications\DatabaseNotification;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
    actingAs($this->user);
});

it('returns notifications index view with notifications and unread count', function () {
    $user = User::factory()->create();
    actingAs($user);

    DatabaseNotification::create([
        'id' => (string) Str::uuid(),
        'type' => 'App\Notifications\DummyNotification',
        'notifiable_type' => get_class($user),
        'notifiable_id' => $user->id,
        'data' => ['message' => 'Test notification 1'],
        'read_at' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DatabaseNotification::create([
        'id' => (string) Str::uuid(),
        'type' => 'App\Notifications\DummyNotification',
        'notifiable_type' => get_class($user),
        'notifiable_id' => $user->id,
        'data' => ['message' => 'Test notification 2'],
        'read_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $response = $this->get(route('notifications.index'));

    $response->assertStatus(200);
    $response->assertViewIs('notifications.index');

    $response->assertViewHas('notifications', function ($notifications) use ($user) {
        return $notifications->first()->notifiable_id === $user->id;
    });

    $response->assertViewHas('unreadCount', 1);
});

it('deletes a user notification successfully', function () {
    $notification = DatabaseNotification::create([
        'id' => (string) Str::uuid(),
        'type' => 'App\Notifications\SomeNotification',
        'notifiable_type' => get_class($this->user),
        'notifiable_id' => $this->user->id,
        'data' => ['message' => 'Test notification'],
        'read_at' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $response = $this->delete(route('notifications.destroy', $notification->id));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'Notificación eliminada');
    $this->assertDatabaseMissing('notifications', ['id' => $notification->id]);
});

it('does not delete notification if it does not belong to user', function () {
    $otherUser = User::factory()->create();

    $notification = DatabaseNotification::create([
        'id' => (string) Str::uuid(),
        'type' => 'App\Notifications\SomeNotification',
        'notifiable_type' => get_class($otherUser),
        'notifiable_id' => $otherUser->id,
        'data' => ['message' => 'Test notification'],
        'read_at' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $response = $this->delete(route('notifications.destroy', $notification->id));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'Notificación eliminada');

    $this->assertDatabaseHas('notifications', ['id' => $notification->id]);
});
