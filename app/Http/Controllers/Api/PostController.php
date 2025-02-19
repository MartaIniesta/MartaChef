<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\{StorePostRequest, UpdatePostRequest};
use App\Models\{User, Tag};

class PostController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
    }

    public function index()
    {
        return PostResource::collection(
            Post::visibilityPublic()->orderBy('id', 'asc')->get()
        );
    }

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

    public function sharedPosts()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        $followedUserIds = $user->following()->pluck('users.id');

        $sharedPosts = Post::visibilityShared($user->id)
            ->whereIn('user_id', $followedUserIds)
            ->latest()
            ->get();

        return PostResource::collection($sharedPosts);
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->handleImageUpload($request);

        $post = Auth::user()->posts()->create($data);
        $post->categories()->sync($request->categories ?? []);
        $post->tags()->sync($this->saveTags($request->tags));

        return new PostResource($post->load(['categories', 'tags']));
    }

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
