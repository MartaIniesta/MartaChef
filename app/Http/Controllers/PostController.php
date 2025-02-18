<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Http\Requests\{StorePostRequest, UpdatePostRequest};
use App\Models\{Category, Comment, Post, Tag, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index()
    {
        $latestPosts = Post::visibilityPublic()
            ->reorder('created_at', 'desc')
            ->take(3)
            ->get();

        $categoriesToShow = ['Tartas', 'Bizcochos', 'Galletas'];
        $categories = Category::whereIn('name', $categoriesToShow)->get();
        $categoryPosts = $categories->mapWithKeys(function($category) {
            $post = $category->posts()
                ->visibilityPublic()
                ->withAvg('ratings', 'rating')
                ->orderByDesc('ratings_avg_rating')
                ->first();

            return [$category->name => $post];
        });

        $topUsers = User::withCount('followers')
            ->orderByDesc('followers_count')
            ->take(3)
            ->get();

        return view('posts.index', compact('latestPosts', 'categoryPosts', 'topUsers'));
    }

    public function recipes()
    {
        $publicPosts = Post::visibilityPublic()->paginate(12);

        return view('posts.recipes', compact('publicPosts'));
    }

    public function myPosts(Request $request)
    {
        $userId = auth()->id();
        $visibility = $request->query('visibility', 'all');

        $userPosts = Post::where('user_id', $userId)
            ->when($visibility !== 'all', function ($query) use ($visibility, $userId) {
                if ($visibility === 'public' || $visibility === 'private') {
                    $query->where('visibility', $visibility);
                } elseif ($visibility === 'shared') {
                    $query->where('visibility', 'shared');
                }
            })
            ->latest()
            ->paginate(12);

        return view('posts.myPosts', compact('userPosts', 'visibility'));
    }

    public function sharedPosts()
    {
        $userId = auth()->id();

        $followedUserIds = User::whereHas('followers', function ($query) use ($userId) {
            $query->where('follower_id', $userId);
        })->pluck('id');

        $sharedPosts = Post::whereIn('user_id', $followedUserIds)
            ->where('visibility', 'shared')
            ->latest()
            ->paginate(12);

        return view('posts.sharedPosts', compact('sharedPosts'));
    }

    public function show(Post $post)
    {
        $post->load('tags');
        $comments = Comment::where('post_id', $post->id)
            ->whereNull('parent_id')
            ->with('replies.user')
            ->get();

        return view('posts.show', compact('post', 'comments'));
    }

    public function create()
    {
        $this->authorize('create', Post::class);
        $categories = Category::all();

        return view('posts.create', ['post' => new Post(), 'categories' => $categories]);
    }

    public function store(StorePostRequest $request)
    {
        $this->authorize('create', Post::class);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->storeAs('images', $imageName, 'public');
            $data['image'] = 'images/' . $imageName;
        }

        $post = auth()->user()->posts()->create($data);
        $post->categories()->sync($request->categories);

        if ($request->tags) {
            $tags = $this->saveTags($request->tags);
            $post->tags()->attach($tags);
        }

        $post->load('user');
        event(new PostCreated($post));

        return to_route('posts.index')->with('status', 'Receta creada correctamente');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $categories = Category::all();
        $selectedCategories = $post->categories->pluck('id')->toArray();

        return view('posts.edit', compact('post', 'categories', 'selectedCategories'));
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

        return redirect()->route('posts.show', $post)->with('status', 'Post actualizado correctamente.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return to_route('posts.index')->with('status', 'Receta eliminada correctamente');
    }

    protected function handleImageUpload($request, Post $post)
    {
        if (!$request->hasFile('image')) {
            return $post->image;
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $image->storeAs('images', $imageName, 'public');

        return 'images/' . $imageName;
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('restore', $post);
        $post->restore();

        return redirect()->route('posts.index')->with('status', 'Receta restaurada correctamente');
    }

    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->forceDelete();
        return redirect()->route('posts.index')->with('status', 'Receta eliminada permanentemente');
    }

    private function saveTags($tagsString)
    {
        $tagsArray = array_map('trim', explode(' ', $tagsString));

        $tags = [];
        foreach ($tagsArray as $tag) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            $tags[] = $tag->id;
        }

        return $tags;
    }
}
