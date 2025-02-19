<?php

namespace App\Http\Controllers;

use App\Events\UserFollowedEvent;
use App\Events\UserUnfollowedEvent;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('users.index', ['users' => User::paginate(15)]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function follow(User $user): RedirectResponse
    {
        $authUser = auth()->user();

        $this->authorize('follow-users');

        if ($authUser->id === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        if (!$authUser->isFollowing($user)) {
            $authUser->follow($user);
            event(new UserFollowedEvent($authUser, $user));
        }

        return back()->with('success', "You are now following {$user->name}.");
    }

    public function unfollow(User $user): RedirectResponse
    {
        $authUser = auth()->user();

        $this->authorize('unfollow-users');

        if ($authUser->isFollowing($user)) {
            $authUser->unfollow($user);
            event(new UserUnfollowedEvent($authUser, $user));
        }

        return back()->with('success', "You have unfollowed {$user->name}.");
    }
}
