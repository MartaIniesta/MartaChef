<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class AdminComments extends Component
{
    use WithPagination;

    public $editingCommentId = null;
    public $editingContent = '';
    public string $deleteMessage = '';

    protected $rules = [
        'editingContent' => 'required|max:300',
    ];

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
        $deletedCount = Comment::deleteOldComments();

        if ($deletedCount > 0) {
            $this->deleteMessage = __('Old comments have been deleted.');
        } else {
            $this->deleteMessage = __('There are no comments older than 3 months.');
        }
    }

    public function editComment($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);
        $this->editingCommentId = $comment->id;
        $this->editingContent = $comment->content;
    }

    public function updateComment()
    {
        $this->validate();

        $comment = Comment::withTrashed()->findOrFail($this->editingCommentId);
        $comment->update(['content' => $this->editingContent]);

        $this->editingCommentId = null;
        $this->editingContent = '';
    }

    public function cancelEdit()
    {
        $this->editingCommentId = null;
        $this->editingContent = '';
    }

    public function render()
    {
        return view('livewire.admin.admin-comments', [
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
                ])->paginate(10)
        ])->layout('layouts.app');
    }
}
