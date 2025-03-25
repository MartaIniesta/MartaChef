<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::withTrashed()->get();
        return view('moderator.moderator-posts-index', compact('posts'));
    }

    public function softDeletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('moderator.posts')->with('success', 'Post eliminado temporalmente.');
    }

    public function restorePost($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('moderator.posts')->with('success', 'Post restaurado correctamente.');
    }

    public function forceDeletePost($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete();

        return redirect()->route('moderator.posts')->with('success', 'Post eliminado permanentemente.');
    }
}
