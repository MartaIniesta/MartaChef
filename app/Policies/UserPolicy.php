<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function follow(User $authUser, User $user): bool
    {
        if ($authUser->id === $user->id) {
            return false;
        }

        return $authUser->can('follow-users');
    }

    public function unfollow(User $authUser, User $user): bool
    {
        if ($authUser->id === $user->id) {
            return false;
        }

        return $authUser->can('unfollow-users');
    }
}
