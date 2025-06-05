<?php

namespace App\Livewire\Moderator;

use App\Events\PostDeletedEvent;
use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class ModeratorPosts extends Component
{
    use WithPagination;

    public function softDeletePost($id)
    {
        $post = Post::findOrFail($id);

        event(new PostDeletedEvent($post));

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
        return view('livewire.moderator.moderator-posts', [
            'posts' => Post::withTrashed()->paginate(10)
        ])->layout('layouts.app');
    }
}
