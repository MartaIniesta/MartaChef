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
     * @group Posts
     *
     * Devuelve una lista de Posts públicos ordenados por ID.
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
     * @group Posts
     * @authenticated
     *
     * Muestra un Post específico.
     *
     * Solo se podrán ver los Posts públicos, los compartidos de usuarios seguidos,
     * y los Posts privados o compartidos del propio usuario autenticado.
     *
     * @urlParam id integer required ID del post. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "title": "Post Title",
     *   "description": "Post Description",
     *   "ingredients": "ingredient1, ingredient2",
     *   "image": "image_url",
     *   "visibility": "public",
     *   "user": {
     *       "id": 1,
     *       "name": "Pepe"
     *   },
     *   "categories": [...],
     *   "tags": [...]
     * }
     *
     * @response 403 {
     *   "error": "No autorizado"
     * }
     *
     * @response 404 {
     *   "error": "El post no existe."
     * }
     */
    public function show($id)
    {
        $post = $this->findPostOrFail($id);

        $user = Auth::user();

        if (!\Gate::forUser($user)->allows('view', $post)) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        return new PostResource($post);
    }

    /**
     * @group Posts
     * @authenticated
     *
     * Devuelve todos los posts creados por el usuario autenticado, sin importar su visibilidad.
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "title": "Post Title",
     *     "description": "Post Description",
     *     "ingredients": "ingredient1, ingredient2",
     *     "image": "image_url",
     *     "visibility": "private",
     *     "user": {
     *       "id": 1,
     *       "name": "Pepe"
     *     },
     *     "categories": [...],
     *     "tags": [...]
     *   },
     *   ...
     * ]
     *
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
     * @group Posts
     * @authenticated
     *
     * Devuelve los Posts con visibilidad "shared" de los usuarios que el usuario autenticado sigue.
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "title": "Post Title",
     *     "description": "Post Description",
     *     "ingredients": "ingredient1, ingredient2",
     *     "image": "image_url",
     *     "visibility": "shared",
     *     "user": {
     *       "id": 1,
     *       "name": "Pepe"
     *     },
     *     "categories": [...],
     *     "tags": [...]
     *   },
     *   ...
     * ]
     *
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
     * @group Posts
     * @authenticated
     *
     * Crea un nuevo Post del usuario autenticado.
     *
     * @bodyParam title string required Título del Post. Example: Tarta de chocolate
     * @bodyParam description string required Descripción del Post. Example: Esta es una deliciosa tarta de chocolate.
     * @bodyParam ingredients string required Ingredientes separados por coma. Example: Harina, Huevos, Azucar
     * @bodyParam visibility string required Visibilidad del Post: public, private, o shared. Example: public
     * @bodyParam categories array required IDs de las categorías asociadas (máximo 4). Example: [1, 2, 3, 4]
     * @bodyParam tags string optional Etiquetas separadas por espacio. Example: #Tarta #Chocolate
     * @bodyParam image file required Imagen asociada al Post.
     *
     * @response 201 {
     *   "message": "Post creado con éxito.",
     *   "data": {
     *     "id": 1,
     *     "title": "Tarta de chocolate",
     *     ...
     *   }
     * }
     * @response 422 {
     *   "errors": {
     *     "image": ["La imagen es requerida."]
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

        return response()->json([
            'message' => 'Post creado con éxito.',
            'data' => new PostResource($post->load(['categories', 'tags']))
        ]);
    }

    /**
     * @group Posts
     * @authenticated
     *
     * Actualiza un Post existente del usuario autenticado.
     *
     * @bodyParam title string required Título actualizado. Example: Tarta actualizada
     * @bodyParam description string required Descripción actualizada. Example: Una mejor version de la tarta de chocolate.
     * @bodyParam ingredients string required Ingredientes actualizados. Example: Azucar, Mantequilla, Harina
     * @bodyParam visibility string required Visibilidad: public, private, o shared. Example: private
     * @bodyParam categories array required IDs de las nuevas categorías. Example: [1, 2]
     * @bodyParam tags string optional Nuevas etiquetas separadas por espacio. Example: #Actualizada #Deliciosa
     * @bodyParam image file optional Nueva imagen (requerida si no hay imagen previa).
     *
     * @response 200 {
     *   "message": "Post actualizado con éxito.",
     *   "data": {
     *     "id": 1,
     *     "title": "Tarta actualizada",
     *     ...
     *   }
     * }
     * @response 422 {
     *   "errors": {
     *     "title": ["El campo título es obligatorio."],
     *     "categories": ["Debe seleccionar entre 1 y 4 categorías."]
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
            'message' => 'Post actualizado con éxito.',
            'data' => new PostResource($post->load(['categories', 'tags']))
        ]);
    }

    /**
     * @group Posts
     * @authenticated
     *
     * Elimina un Post existente del usuario autenticado.
     *
     * @response 200 {
     *   "status": "Post eliminado correctamente"
     * }
     * @response 403 {
     *   "error": "No autorizado"
     * }
     * @response 404 {
     *   "error": "El post no existe."
     * }
     */
    public function destroy($id)
    {
        $post = $this->findPostOrFail($id);

        $this->authorize('delete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();

        return response()->json([
            'status' => 'Post eliminado correctamente'
        ]);
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

    private function findPostOrFail($id)
    {
        $post = Post::with(['categories', 'tags'])->find($id);

        if (!$post) {
            abort(response()->json(['error' => 'El post no existe.'], 404));
        }

        return $post;
    }
}
