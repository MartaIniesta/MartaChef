<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function follow(User $user)
    {
        $authUser = auth()->user();

        if ($authUser->cannot('follow-users')) {
            return back()->with('error', 'You do not have permission to follow users.');
        }

        if ($authUser->id === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        $authUser->following()->attach($user);

        return back()->with('success', 'You are now following ' . $user->name);
    }

    public function unfollow(User $user)
    {
        $authUser = auth()->user();

        if ($authUser->cannot('unfollow-users')) {
            return back()->with('error', 'You do not have permission to unfollow users.');
        }

        $authUser->following()->detach($user);

        return back()->with('success', 'You have unfollowed ' . $user->name);
    }
}
