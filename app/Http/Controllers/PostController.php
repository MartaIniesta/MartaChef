<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index()
    {
        $publicPosts = Post::visibilityPublic()->get();

        return view('posts.index', compact('publicPosts'));
    }

    public function myPosts()
    {
        $userId = auth()->id();

        $userPosts = Post::where('user_id', $userId)
            ->where(function ($query) {
                $query->where('visibility', 'public')
                    ->orWhere('visibility', 'private');
            })
            ->latest()
            ->paginate(10);

        return view('posts.myPosts', compact('userPosts'));
    }

    public function sharedPosts()
    {
        $userId = auth()->id();

        $sharedPosts = Post::visibilityShared($userId)->latest()->paginate(10);

        return view('posts.sharedPosts', compact('sharedPosts'));
    }

    public function show(Post $post)
    {
        $post->load('user.followers');

        if ($post->visibility === 'private' && auth()->id() !== $post->user_id) {
            abort(404);
        }

        if ($post->visibility === 'shared') {
            if (!auth()->check() || !$post->user->followers->contains(auth()->id())) {
                return redirect()->route('login');
            }
        }

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create', ['post' => new Post()]);
    }

    public function store(StorePostRequest $request)
    {
        auth()->user()->posts()->create($request->validated());

        return to_route('posts.index')->with('status', 'Receta creada correctamente');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {

        $data = $request->validated([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'visibility' => 'required|in:public,private,shared,saved',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->update($data);

        return redirect()->route('posts.show', ['post' => $post])->with('status', 'Post actualizado correctamente.');
    }


    public function destroy(Post $post)
    {
        $post->delete();

        return to_route('posts.index')->with('status', 'Receta eliminada correctamente');
    }
}
