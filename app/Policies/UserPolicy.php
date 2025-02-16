<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function follow(User $user): bool
    {
        return $user->can('follow-users');
    }

    public function unfollow(User $user): bool
    {
        return $user->can('unfollow-users');
    }
}
