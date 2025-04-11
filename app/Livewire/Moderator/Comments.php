<?php

namespace App\Livewire\Moderator;

use App\Models\Comment;
use Livewire\Component;

class Comments extends Component
{
    public function softDeleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        $comment->replies()->delete();
    }

    public function restoreComment($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);
        $comment->restore();

        $comment->replies()->withTrashed()->restore();
    }

    public function forceDeleteComment($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);

        $comment->replies()->withTrashed()->forceDelete();

        $comment->forceDelete();
    }

    public function render()
    {
        return view('livewire.moderator.comments', [
            'comments' => Comment::withTrashed()
                ->with(['parent' => function ($query) {
                    $query->withTrashed();
                }, 'replies' => function ($query) {
                    $query->withTrashed();
                }])->get()
        ])->layout('layouts.app');
    }
}
