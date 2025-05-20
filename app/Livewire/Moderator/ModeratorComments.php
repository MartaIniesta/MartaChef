<?php

namespace App\Livewire\Moderator;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class ModeratorComments extends Component
{
    use WithPagination;

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

    public function deleteOldComments()
    {
        Comment::deleteOldComments();
    }

    public function render()
    {
        return view('livewire.moderator.moderator-comments', [
            'comments' => Comment::withTrashed()
                ->with([
                    'user' => function ($query) {
                        $query->withTrashed();
                    },
                    'parent' => function ($query) {
                        $query->withTrashed();
                    },
                    'replies' => function ($query) {
                        $query->withTrashed();
                    }
                ])
                ->paginate(10)
        ])->layout('layouts.app');
    }
}
