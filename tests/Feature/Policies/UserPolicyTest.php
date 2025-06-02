<?php

use App\Models\User;
use App\Policies\UserPolicy;

beforeEach(function () {
    $this->policy = new UserPolicy();
});

it('prevents a user from following themselves', function () {
    $user = new User();
    $user->id = 1;

    expect($this->policy->follow($user, $user))->toBeFalse();
});

it('prevents a user from unfollowing themselves', function () {
    $user = new User();
    $user->id = 1;

    expect($this->policy->unfollow($user, $user))->toBeFalse();
});
/*
it('allows a user with permission to follow another user', function () {
    $authUser = Mockery::mock(User::class)->makePartial();
    $authUser->id = 1;
    $authUser->shouldReceive('can')->with('follow-users')->andReturnTrue();

    $targetUser = new User();
    $targetUser->id = 2;

    expect($this->policy->follow($authUser, $targetUser))->toBeTrue();
});

it('prevents a user without permission from following another user', function () {
    $authUser = Mockery::mock(User::class)->makePartial();
    $authUser->id = 1;
    $authUser->shouldReceive('can')->with('follow-users')->andReturnFalse();

    $targetUser = new User();
    $targetUser->id = 2;

    expect($this->policy->follow($authUser, $targetUser))->toBeFalse();
});

it('allows a user with permission to unfollow another user', function () {
    $authUser = Mockery::mock(User::class)->makePartial();
    $authUser->id = 1;
    $authUser->shouldReceive('can')->with('unfollow-users')->andReturnTrue();

    $targetUser = new User();
    $targetUser->id = 2;

    expect($this->policy->unfollow($authUser, $targetUser))->toBeTrue();
});

it('prevents a user without permission from unfollowing another user', function () {
    $authUser = Mockery::mock(User::class)->makePartial();
    $authUser->id = 1;
    $authUser->shouldReceive('can')->with('unfollow-users')->andReturnFalse();

    $targetUser = new User();
    $targetUser->id = 2;

    expect($this->policy->unfollow($authUser, $targetUser))->toBeFalse();
});
*/
