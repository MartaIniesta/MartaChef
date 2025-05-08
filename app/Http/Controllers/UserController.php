<?php

namespace App\Http\Controllers;

use App\Events\{UserFollowedEvent, UserUnfollowedEvent};
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $users = User::visibleProfiles()->paginate(8);

        return view('users.index', ['users' => $users]);
    }

    public function show(User $user)
    {
        $posts = $user->posts()->visibilityPublic()->paginate(6);

        return view('users.show', compact('user', 'posts'));
    }

    public function follow(User $user): RedirectResponse
    {
        $authUser = auth()->user();

        $this->authorize('follow', $user);

        event(new UserFollowedEvent($authUser, $user));

        return back()->with('success', "You are now following {$user->name}.");
    }

    public function unfollow(User $user): RedirectResponse
    {
        $authUser = auth()->user();

        $this->authorize('unfollow', $user);

        event(new UserUnfollowedEvent($authUser, $user));

        return back()->with('success', "You have unfollowed {$user->name}.");
    }

}
