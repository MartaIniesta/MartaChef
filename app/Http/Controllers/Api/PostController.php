<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\{Post, Tag};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\{Auth, Storage};
use App\Http\Requests\{StorePostRequest, UpdatePostRequest};

class PostController extends Controller
{
    use AuthorizesRequests;

    /**
     * @group Publicación
     *
     * Obtiene una lista de posts públicos ordenados por ID.
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "title": "Post Title",
     *     "description": "Post Description",
     *     "ingredients": "ingredient1, ingredients2",
     *     "image": "image_url",
     *     "visibility": "public",
     *     "user": {
     *          "id": 1,
     *          "name": "Pepe"
     *     },
     *     "categories": [...],
     *     "tags": [...]
     *   },
     *   ...
     * ]
     */
    public function index()
    {
        return PostResource::collection(
            Post::with(['categories', 'tags'])
                ->visibilityPublic()
                ->orderBy('id', 'asc')
                ->get()
        );
    }

    /**
     * @group Publicación
     *
     * Muestra una publicación específica.
     * Solo se podrá ver si el usuario es propietario o el post es publico.
     *
     * @urlParam post integer Requiere el ID de la publicación. Example: 1
     * @response 200 [
     *    {
     *      "id": 1,
     *      "title": "Post Title",
     *      "description": "Post Description",
     *      "ingredients": "ingredient1, ingredients2",
     *      "image": "image_url",
     *      "visibility": "public",
     *      "user": {
     *           "id": 1,
     *           "name": "Pepe"
     *      },
     *      "categories": [...],
     *      "tags": [...]
     *    },
     *
     * @response 403 {
     *   "error": "No autorizado"
     * }
     */
    public function show(Post $post)
    {
        if ($post->visibility === 'private' && Auth::id() !== $post->user_id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        if ($post->visibility === 'shared' && !Post::visibilityShared(Auth::id())->find($post->id)) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        return new PostResource($post->load(['categories', 'tags']));
    }

    /**
     * @group Publicación
     *
     * Obtiene las publicaciones de un usuario autenticado, sin tener en cuenta su visibilidad.
     *
     * @response 200 [
     *     {
     *       "id": 1,
     *       "title": "Post Title",
     *       "description": "Post Description",
     *       "ingredients": "ingredient1, ingredients2",
     *       "image": "image_url",
     *       "visibility": "private",
     *       "user": {
     *            "id": 1,
     *            "name": "Pepe"
     *       },
     *       "categories": [...],
     *       "tags": [...]
     *     },
     *   ...
     * ]
     * @response 401 {
     *   "error": "No autenticado"
     * }
     */
    public function myPosts()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        $userPosts = Auth::user()->posts()
            ->whereIn('visibility', ['public', 'private', 'shared'])
            ->orderBy('id', 'asc')
            ->with(['categories', 'tags'])
            ->get();

        return PostResource::collection($userPosts);
    }

    /**
     * @group Publicación
     *
     * Obtiene las publicaciones compartidas de los usuarios seguidos.
     *
     * @response 200 [
     *     {
     *       "id": 1,
     *       "title": "Post Title",
     *       "description": "Post Description",
     *       "ingredients": "ingredient1, ingredients2",
     *       "image": "image_url",
     *       "visibility": "shared",
     *       "user": {
     *            "id": 1,
     *            "name": "Pepe"
     *       },
     *       "categories": [...],
     *       "tags": [...]
     *     },
     *   ...
     * ]
     * @response 401 {
     *   "error": "No autenticado"
     * }
     */
    public function sharedPosts()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        $followedUserIds = $user->following()->pluck('users.id');

        $sharedPosts = Post::visibilityShared($user->id)
            ->whereIn('user_id', $followedUserIds)
            ->with(['categories', 'tags'])
            ->latest()
            ->get();

        return PostResource::collection($sharedPosts);
    }

    /**
     * @group Publicación
     *
     * Crea una nueva publicación para el usuario autenticado.
     *
     * @bodyParam title string El título de la publicación. Example: "Delicious Cake"
     * @bodyParam description string La descripción de la publicación. Example: "This is a recipe for a delicious cake."
     * @bodyParam ingredients string Los ingredientes necesarios. Example: "Flour, Eggs, Sugar"
     * @bodyParam visibility string La visibilidad de la publicación. Example: "public"
     * @bodyParam categories array Los IDs de las categorías asociadas a la publicación. Example: [1, 2]
     * @bodyParam tags string Etiquetas separadas por espacio. Example: "dessert cake"
     * @bodyParam image file La imagen asociada a la publicación.
     *
     * @response 201 {
     *   "id": 1,
     *   "title": "New Post",
     *   "description": "Description of new post",
     *   "ingredients": "ingredient1, ingredients2",
     *   "visibility": "public",
     *   "categories": [...],
     *   "tags": [...],
     *   "image": "image_url"
     * }
     * @response 422 {
     *   "errors": {
     *     "image": ["The image field is required."]
     *   }
     * }
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->handleImageUpload($request);

        $post = Auth::user()->posts()->create($data);
        $post->categories()->sync($request->categories ?? []);
        $post->tags()->sync($this->saveTags($request->tags));

        return new PostResource($post->load(['categories', 'tags']));
    }

    /**
     * @group Publicación
     *
     * Actualiza una publicación existente.
     *
     * @urlParam post integer Requiere el ID de la publicación. Example: 1
     * @bodyParam title string El título de la publicación. Example: "Updated Post"
     * @bodyParam description string La descripción actualizada. Example: "Updated description"
     * @bodyParam ingredients string Los ingredientes actualizados. Example: "Updated ingredients"
     * @bodyParam visibility string La visibilidad actualizada. Example: "private"
     * @bodyParam categories array Los IDs de las categorías actualizadas. Example: [1, 3]
     * @bodyParam tags string Etiquetas separadas por espacio. Example: "updated tag"
     * @bodyParam image file La nueva imagen de la publicación.
     *
     * @response 200 {
     *   "message": "Post actualizado correctamente.",
     *   "post": {
     *     "id": 1,
     *     "title": "Updated Post",
     *     "description": "Updated description",
     *     "ingredients": "ingredient1, ingredients2",
     *     "visibility": "private",
     *     "categories": [...],
     *     "tags": [...],
     *     "image": "new_image_url"
     *   }
     * }
     * @response 422 {
     *   "errors": {
     *     "image": ["The image field is required."]
     *   }
     * }
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        $data['image'] = $this->handleImageUpload($request, $post);

        $post->update($data);

        $post->categories()->sync($data['categories'] ?? []);

        if ($request->filled('tags')) {
            $tags = $this->saveTags($request->tags);
            $post->tags()->sync($tags);
        }

        return response()->json([
            'message' => 'Post actualizado correctamente.',
            'post' => new PostResource($post->load('categories', 'tags'))
        ], 200);
    }

    /**
     * @group Publicación
     *
     * Elimina una publicación.
     *
     * @urlParam post integer Requiere el ID de la publicación a eliminar. Example: 1
     *
     * @response 200 {
     *   "status": "Post eliminado correctamente"
     * }
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();

        return response()->json([
            'status' => 'Post eliminado correctamente'
        ], 200);
    }

    private function handleImageUpload($request, Post $post = null)
    {
        if (!$request->hasFile('image')) {
            return $post ? $post->image : null;
        }

        if ($post && $post->image) {
            Storage::disk('public')->delete($post->image);
        }

        return $request->file('image')->store('images', 'public');
    }

    private function saveTags($tagsString)
    {
        if (!$tagsString) return [];

        return collect(explode(' ', trim($tagsString)))
            ->map(fn($tag) => Tag::firstOrCreate(['name' => $tag])->id)
            ->toArray();
    }
}
