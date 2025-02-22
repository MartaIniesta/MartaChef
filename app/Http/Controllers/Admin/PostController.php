<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        return $this->middleware('role:admin');
    }

    public function index()
    {
        $posts = Post::withTrashed()->get();
        return view('admin.admin-posts-index', compact('posts'));
    }

    public function softDeletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts')->with('success', 'Post eliminado temporalmente.');
    }

    public function restorePost($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('admin.posts')->with('success', 'Post restaurado correctamente.');
    }

    public function forceDeletePost($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete();

        return redirect()->route('admin.posts')->with('success', 'Post eliminado permanentemente.');
    }
}
