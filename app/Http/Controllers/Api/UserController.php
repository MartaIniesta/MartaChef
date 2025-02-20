<?php

namespace App\Http\Controllers\Api;

use App\Events\UserFollowedEvent;
use App\Events\UserUnfollowedEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function follow(User $user)
    {
        $authUser = Auth::user();

        $this->authorize('follow-users');

        if ($authUser->id === $user->id) {
            return response()->json(['error' => 'You cannot follow yourself.'], 400);
        }

        if (!$authUser->isFollowing($user)) {
            $authUser->follow($user);
            event(new UserFollowedEvent($authUser, $user));
        }

        return response()->json([
            'success' => "You are now following {$user->name}."
        ]);
    }

    public function unfollow(User $user)
    {
        $authUser = Auth::user();

        $this->authorize('unfollow-users');

        if ($authUser->isFollowing($user)) {
            $authUser->unfollow($user);
            event(new UserUnfollowedEvent($authUser, $user));
        }

        return response()->json([
            'success' => "You have unfollowed {$user->name}."
        ]);
    }
}
