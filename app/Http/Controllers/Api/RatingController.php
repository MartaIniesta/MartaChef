<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    use AuthorizesRequests;

    /**
     * @group Calificación
     * @authenticated
     *
     * Obtiene todas las calificaciones existentes junto con los datos de usuario y post relacionados.
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "rating": 4,
     *     "user": {
     *       "id": 2,
     *       "name": "Pepe"
     *     },
     *     "post": {
     *       "id": 10,
     *       "title": "Tarta de chocolate"
     *     }
     *   },
     *   ...
     * ]
     */
    public function index()
    {
        $ratings = Rating::with(['user', 'post'])->get();
        return RatingResource::collection($ratings);
    }

    /**
     * @group Calificación
     * @authenticated
     *
     * Obtiene todas las calificaciones de un post identificado por su ID.
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "rating": 5,
     *     "user": {
     *       "id": 3,
     *       "name": "Pepe"
     *     }
     *   },
     *   ...
     * ]
     * @response 404 {
     *   "message": "No se encontraron calificaciones para esta publicación"
     * }
     */
    public function show($post_id)
    {
        $ratings = Rating::with('user')
            ->where('post_id', $post_id)
            ->get();

        if ($ratings->isEmpty()) {
            return response()->json(['message' => 'No se encontraron calificaciones para esta publicación'], 404);
        }

        return RatingResource::collection($ratings);
    }

    /**
     * @group Calificación
     * @authenticated
     *
     * Crea una nueva calificación para un post específico por parte del usuario autenticado.
     *
     * @bodyParam post_id integer required ID del post a calificar. Example: 10
     * @bodyParam rating integer required Valor de la calificación entre 1 y 5. Example: 4
     *
     * @response 201 {
     *   "message": "Calificación guardada correctamente",
     *   "data": {
     *     "id": 7,
     *     "rating": 4,
     *     "user": {
     *       "id": 1,
     *       "name": "Pepe"
     *     }
     *   }
     * }
     * @response 409 {
     *   "message": "Ya has calificado este post. Si deseas cambiar tu calificación, utiliza la ruta de actualización."
     * }
     * @response 422 {
     *   "errors": {
     *     "post_id": ["El campo post_id es obligatorio."],
     *     "rating": ["El campo rating es obligatorio y debe ser un entero entre 1 y 5."]
     *   }
     * }
     */
    public function store(StoreRatingRequest $request)
    {
        $existingRating = Rating::where('user_id', Auth::id())
            ->where('post_id', $request->post_id)
            ->first();

        if ($existingRating) {
            return response()->json([
                'message' => 'Ya has calificado este post. Si deseas cambiar tu calificación, utiliza la ruta de actualización.'
            ], 409);
        }

        $rating = Rating::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
            'rating' => $request->rating,
        ]);

        $rating->load('user');

        return response()->json([
            'message' => 'Calificación guardada correctamente',
            'data' => new RatingResource($rating),
        ], 201);
    }

    /**
     * @group Calificación
     * @authenticated
     *
     * Actualiza la calificación del usuario autenticado para un post específico.
     *
     * @bodyParam rating integer required Nuevo valor de la calificación entre 1 y 5. Example: 5
     *
     * @response 200 {
     *   "message": "Calificación actualizada",
     *   "data": {
     *     "id": 7,
     *     "rating": 5,
     *     "user": {
     *       "id": 1,
     *       "name": "Pepe"
     *     }
     *   }
     * }
     * @response 404 {
     *   "message": "Calificación no encontrada"
     * }
     * @response 422 {
     *   "errors": {
     *     "rating": ["El campo rating es obligatorio y debe ser un entero entre 1 y 5."]
     *   }
     * }
     */
    public function update(Request $request, $post_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rating::where('post_id', $post_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$rating) {
            return response()->json(['message' => 'Calificación no encontrada'], 404);
        }

        $rating->update(['rating' => $request->rating]);
        $rating->load('user');

        return response()->json([
            'message' => 'Calificación actualizada',
            'data' => new RatingResource($rating),
        ]);
    }

    /**
     * @group Calificación
     * @authenticated
     *
     * Elimina la calificación del usuario autenticado para un post específico.
     *
     * @response 200 {
     *   "message": "Calificación eliminada"
     * }
     * @response 404 {
     *   "message": "Calificación no encontrada"
     * }
     */
    public function destroy($post_id)
    {
        $rating = Rating::where('user_id', Auth::id())
            ->where('post_id', $post_id)
            ->first();

        if (!$rating) {
            return response()->json(['message' => 'Calificación no encontrada'], 404);
        }

        $rating->delete();

        return response()->json(['message' => 'Calificación eliminada']);
    }
}
