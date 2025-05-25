<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResource;
use App\Models\Post;
use App\Models\Rating;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $ratings = Rating::with(['user', 'post'])->get();
        return RatingResource::collection($ratings);
    }

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

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $post = Post::findOrFail($request->post_id);
        Auth::user()->loadMissing('following');

        $this->authorize('rate', $post);

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
        ]);
    }

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
