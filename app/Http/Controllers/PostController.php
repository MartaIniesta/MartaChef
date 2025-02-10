<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index()
    {
        $publicPosts = Post::visibilityPublic()->paginate(12);

        return view('posts.index', compact('publicPosts'));
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

        $sharedPosts = Post::where('visibility', 'shared')
            ->whereHas('user.followers', function ($query) use ($userId) {
                $query->where('follower_id', $userId);
            })
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
        $categories = Category::all();

        return view('posts.create', [
            'post' => new Post(),
            'categories' => $categories,
        ]);
    }

    public function store(StorePostRequest $request)
    {
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

        return to_route('posts.index')->with('status', 'Receta creada correctamente');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::all();
        $selectedCategories = $post->categories->pluck('id')->toArray();

        return view('posts.edit', compact('post', 'categories', 'selectedCategories'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'visibility' => 'required|in:public,private,shared',
            'categories' => 'required|array|min:1|max:4',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|string',
            'image' => $post->image ? 'nullable|image' : 'required|image',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->storeAs('images', $imageName, 'public');

            $data['image'] = 'images/' . $imageName;
        }

        $post->update($data);

        $post->categories()->sync($data['categories']);

        if ($request->tags) {
            $tags = $this->saveTags($request->tags);
            $post->tags()->sync($tags);
        }

        return redirect()->route('posts.show', ['post' => $post])->with('status', 'Post actualizado correctamente.');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return to_route('posts.index')->with('status', 'Receta eliminada correctamente');
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
