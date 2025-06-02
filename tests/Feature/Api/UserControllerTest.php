<?php

use App\Models\User;
use Database\Seeders\RolesSeeder;

beforeEach(function () {
    $this->seed(RolesSeeder::class);
});

/* Obtiene lista de usuarios visibles con estructura correcta */
it('returns a list of visible users', function () {
    User::factory()->count(3)->create();

    $response = $this->getJson(route('api.users.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'email', 'followers_count', 'following_count']
            ]
        ]);
});

/* Muestra detalles de un usuario visible con estructura correcta */
it('shows details of a visible user', function () {
    $authUser = User::factory()->create()->assignRole('user');
    loginAsUser($authUser);

    $user = User::factory()->create()->assignRole('user');

    $response = $this->getJson(route('api.users.show', $user));

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ])
        ->assertJsonStructure([
            'data' => [
                'followers_count',
                'following_count',
            ]
        ]);
});

/* Usuario no visible retorna 404 */
it('returns 404 when showing a non-visible user', function () {
    $user = User::factory()->create();

    $this->mock(User::class, function ($mock) use ($user) {
        $mock->shouldReceive('visibleProfiles')->andReturn(collect());
        $mock->shouldReceive('resolveRouteBinding')->andReturn($user);
    });

    $response = $this->getJson(route('api.users.show', $user));

    $response->assertStatus(404)
        ->assertJson(['error' => 'Usuario no visible o no existe.']);
});

/* Usuario autenticado con permiso sigue a otro usuario */
it('allows authenticated user with permission to follow another user', function () {
    $authUser = User::factory()->create()->givePermissionTo('follow-users');
    $userToFollow = User::factory()->create()->assignRole('user');

    loginAsUser($authUser);

    $response = $this->postJson(route('api.users.follow', $userToFollow));

    $response->assertStatus(200)
        ->assertJson(['success' => "Ahora estás siguiendo a {$userToFollow->name}."]);

    expect($authUser->fresh()->isFollowing($userToFollow))->toBeTrue();
});

/* No permite seguirse a uno mismo */
it('does not allow user to follow themselves', function () {
    $user = User::factory()->create()->givePermissionTo('follow-users');

    loginAsUser($user);

    $response = $this->postJson(route('api.users.follow', $user));

    $response->assertStatus(400)
        ->assertJson(['error' => 'No puedes seguirte a ti mismo.']);
});

/* Usuario sin permiso recibe 403 */
it('does not allow user without permission to follow others', function () {
    $authUser = User::factory()->create();
    $userToFollow = User::factory()->create();

    loginAsUser($authUser);

    $response = $this->postJson(route('api.users.follow', $userToFollow));

    $response->assertStatus(403);
});

/* Usuario deja de seguir a otro usuario con permiso */
it('allows authenticated user with permission to unfollow another user', function () {
    $authUser = User::factory()->create()->givePermissionTo('unfollow-users');
    $userToUnfollow = User::factory()->create()->assignRole('user');

    loginAsUser($authUser);

    $authUser->follow($userToUnfollow);
    expect($authUser->fresh()->isFollowing($userToUnfollow))->toBeTrue();

    $response = $this->postJson(route('api.users.unfollow', $userToUnfollow));

    $response->assertStatus(200)
        ->assertJson(['success' => "Has dejado de seguir a {$userToUnfollow->name}."]);

    expect($authUser->fresh()->isFollowing($userToUnfollow))->toBeFalse();
});

/* Usuario sin permiso recibe 403 */
it('does not allow user without permission to unfollow others', function () {
    $authUser = User::factory()->create();
    $userToUnfollow = User::factory()->create();

    loginAsUser($authUser);

    $response = $this->postJson(route('api.users.unfollow', $userToUnfollow));

    $response->assertStatus(403);
});
