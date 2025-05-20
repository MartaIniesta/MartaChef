<?php

namespace App\Livewire\Admin;

use App\Mail\PostDeletedMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class AdminPosts extends Component
{
    use WithPagination;

    public function softDeletePost($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user) {
            Mail::to($post->user->email)->send(new PostDeletedMail($post));
        }

        $post->delete();
    }

    public function restorePost($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
    }

    public function forceDeletePost($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete();
    }

    public function render()
    {
        return view('livewire.admin.admin-posts', [
            'posts' => Post::withTrashed()
                ->with([
                    'user' => function ($query) {
                        $query->withTrashed();
                    }
                ])->paginate(10)
        ])->layout('layouts.app');
    }
}
