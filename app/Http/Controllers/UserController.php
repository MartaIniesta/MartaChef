<?php

namespace App\Http\Controllers;

use App\Events\{UserFollowedEvent, UserUnfollowedEvent};
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index()
    {
        return view('users.index', ['users' => User::paginate(8)]);
    }

    public function show(User $user)
    {
        $posts = $user->posts()->visibilityPublic()->paginate(6);

        return view('users.show', compact('user', 'posts'));
    }

    public function follow(User $user): RedirectResponse
    {
        $authUser = auth()->user();

        $this->authorize('follow', $authUser);

        if ($authUser->id === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        event(new UserFollowedEvent($authUser, $user));

        return back()->with('success', "You are now following {$user->name}.");
    }

    public function unfollow(User $user): RedirectResponse
    {
        $authUser = auth()->user();

        $this->authorize('unfollow', $authUser);

        event(new UserUnfollowedEvent($authUser, $user));

        return back()->with('success', "You have unfollowed {$user->name}.");
    }
}
