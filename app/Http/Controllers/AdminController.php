<?php

namespace App\Http\Controllers;

use App\Models\{Post, User};

class AdminController extends Controller
{
    public function __construct()
    {
        return $this->middleware('role:admin');
    }

    public function index()
    {
        return view('admin.admin-dashboard');
    }

    public function users()
    {
        $users = User::withTrashed()->get();
        return view('admin.admin-users-index', compact('users'));
    }

    public function softDeleteUser($id)
    {
        $user = User::findOrFail($id);

        $user->posts()->delete();
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Usuario y sus posts han sido eliminados temporalmente.');
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->restore();
        $user->posts()->withTrashed()->restore();

        return redirect()->route('admin.users')->with('success', 'Usuario y sus posts han sido restaurados.');
    }

    public function forceDeleteUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->posts()->withTrashed()->forceDelete();
        $user->forceDelete();

        return redirect()->route('admin.users')->with('success', 'Usuario y sus posts han sido eliminados permanentemente.');
    }

    // 📌 Administrar Posts
    public function posts()
    {
        $posts = Post::withTrashed()->get(); // Traer posts normales y eliminados
        return view('admin.admin-posts-index', compact('posts'));
    }

    public function softDeletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete(); // Elimina el post temporalmente

        return redirect()->route('admin.posts')->with('success', 'Post eliminado temporalmente.');
    }

    public function restorePost($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore(); // Restaura el post

        return redirect()->route('admin.posts')->with('success', 'Post restaurado correctamente.');
    }

    public function forceDeletePost($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete(); // Elimina permanentemente el post

        return redirect()->route('admin.posts')->with('success', 'Post eliminado permanentemente.');
    }
}
