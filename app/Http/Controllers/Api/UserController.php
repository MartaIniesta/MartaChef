<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use AuthorizesRequests;

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
        $users = User::visibleProfiles()->get();

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
        $this->userIsVisible($user);

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
            return response()->json(['error' => 'No puedes seguirte a ti mismo.'], 400);
        }

        $this->userIsVisible($user);

        if (!$authUser->isFollowing($user)) {
            $authUser->follow($user);
        }

        return response()->json([
            'success' => "Ahora estás siguiendo a {$user->name}."
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

        $this->userIsVisible($user);

        if ($authUser->isFollowing($user)) {
            $authUser->unfollow($user);
        }

        return response()->json([
            'success' => "Has dejado de seguir a {$user->name}."
        ]);
    }

    private function userIsVisible(User $user)
    {
        if (!User::visibleProfiles()->where('id', $user->id)->exists()) {
            abort(response()->json(['error' => 'Usuario no visible o no existe.'], 404));
        }
    }
}
