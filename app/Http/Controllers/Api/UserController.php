<?php

namespace App\Http\Controllers\Api;

use App\Events\{UserFollowedEvent, UserUnfollowedEvent};
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

    /**
     * @group Usuarios
     *
     * Obtiene una lista de todos los usuarios, excluyendo el usuario autenticado.
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "name": "Pepe",
     *     "email": "pepe@example.com"
     *   },
     *   ...
     * ]
     */
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        return UserResource::collection($users);
    }

    /**
     * @group Usuarios
     *
     * Muestra los detalles de un usuario específico.
     *
     * @urlParam user integer Requiere el ID del usuario. Example: 1
     * @response 200 {
     *   "id": 1,
     *   "name": "Pepe",
     *   "email": "pepe@example.com"
     * }
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * @group Seguimiento
     *
     * Permite al usuario autenticado seguir a otro usuario.
     *
     * @urlParam user integer Requiere el ID del usuario a seguir. Example: 2
     * @response 200 {
     *   "success": "You are now following John Doe."
     * }
     * @response 400 {
     *   "error": "You cannot follow yourself."
     * }
     */
    public function follow(User $user)
    {
        $authUser = Auth::user();

        $this->authorize('follow-users');

        if ($authUser->id === $user->id) {
            return response()->json(['error' => 'You cannot follow yourself.'], 400);
        }

        if (!$authUser->isFollowing($user)) {
            $authUser->follow($user);
        }

        return response()->json([
            'success' => "You are now following {$user->name}."
        ]);
    }

    /**
     * @group Seguimiento
     *
     * Permite al usuario autenticado dejar de seguir a otro usuario.
     *
     * @urlParam user integer Requiere el ID del usuario a dejar de seguir. Example: 2
     * @response 200 {
     *   "success": "You have unfollowed John Doe."
     * }
     */
    public function unfollow(User $user)
    {
        $authUser = Auth::user();

        $this->authorize('unfollow-users');

        if ($authUser->isFollowing($user)) {
            $authUser->unfollow($user);
        }

        return response()->json([
            'success' => "You have unfollowed {$user->name}."
        ]);
    }
}
