<?php

namespace App\Http\Controllers;

use App\Events\PostCreatedEvent;
use App\Jobs\SendPostNotificationJob;
use App\Http\Requests\{StorePostRequest, UpdatePostRequest};
use App\Models\{Category, Comment, Post, Tag};
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function recipes()
    {
        $publicPosts = Post::visibilityPublic()->paginate(12);

        return view('posts.recipes', compact('publicPosts'));
    }

    public function myPosts(Request $request)
    {
        $visibility = $request->query('visibility', 'all');

        $userPosts = Post::where('user_id', auth()->id())
            ->when($visibility !== 'all', function ($query) use ($visibility) {
                if ($visibility === 'public' || $visibility === 'private') {
                    $query->where('visibility', $visibility);
                } elseif ($visibility === 'shared') {
                    $query->where('visibility', 'shared');
                }
            })
            ->latest()
            ->paginate(6)
            ->appends(['visibility' => $visibility]);

        return view('posts.myPosts', compact('userPosts', 'visibility'));
    }

    public function sharedPosts()
    {
        $userId = auth()->id();

        $sharedPosts = Post::visibilityShared($userId)
            ->latest()
            ->paginate(12);

        return view('posts.sharedPosts', compact('sharedPosts'));
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);

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

        $data['image'] = $this->handleImageUpload($request);

        $post = auth()->user()->posts()->create($data);

        $post->categories()->sync($request->categories);

        if ($request->tags) {
            $tags = $this->saveTags($request->tags);
            $post->tags()->attach($tags);
        }

        $post->load('user');

        event(new PostCreatedEvent($post));
        SendPostNotificationJob::dispatch($post);

        return to_route('blog')->with('status', 'Receta creada correctamente');
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
        $this->authorize('update', $post);

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
        $post->delete();

        return to_route('blog')->with('status', 'Receta eliminada correctamente');
    }

    private function handleImageUpload($request, Post $post = null)
    {
        if (!$request->hasFile('image')) {
            return $post ? $post->image : null;
        }

        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $image->storeAs('images', $imageName, 'public');

        return 'images/' . $imageName;
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
