<?php

namespace App\Livewire;

use App\Rules\NoBadWords;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class Comments extends Component
{
    use AuthorizesRequests;

    public $postId;
    public $content;
    public $editingCommentId;
    public $editingContent;
    public $replyingToId;
    public $replyContent;
    public $resetKey;
    public $commentsToShow = 4;
    public $repliesToShow = [];

    public function mount($postId)
    {
        $this->postId = $postId;
    }

    public function addComment()
    {
        $this->resetValidation();
        $this->validate([
            'content' => ['required', 'min:4', 'max:300', new NoBadWords],
        ], [
            'content.required' => 'Debes escribir algo para comentar.',
        ]);

        $this->authorize('create', Comment::class);

        Comment::create([
            'post_id' => $this->postId,
            'user_id' => Auth::id(),
            'content' => $this->content,
        ]);

        $this->resetForm();
    }

    public function replyToComment($commentId)
    {
        $this->replyingToId = $commentId;
    }

    public function addReply()
    {
        $this->resetValidation();
        $this->validate([
            'replyContent' => ['required', 'min:4', 'max:300', new NoBadWords],
        ], [
            'replyContent.required' => 'Debes escribir algo para responder.',
        ]);

        $this->authorize('create', Comment::class);

        Comment::create([
            'post_id' => $this->postId,
            'user_id' => Auth::id(),
            'content' => $this->replyContent,
            'parent_id' => $this->replyingToId,
        ]);

        $this->resetForm();
    }

    public function editComment(Comment $comment)
    {
        $this->editingCommentId = $comment->id;
        $this->editingContent = $comment->content;
    }

    public function updateComment()
    {
        $this->resetValidation();
        $this->validate([
            'editingContent' => ['required', 'min:4', 'max:300', new NoBadWords],
        ], [
            'editingContent.required' => 'El contenido es obligatorio al actualizar.',
        ]);

        $comment = Comment::findOrFail($this->editingCommentId);
        $this->authorize('update', $comment);

        $comment->update(['content' => $this->editingContent]);

        $this->resetForm();
    }

    public function deleteComment(Comment $comment)
    {
        $this->authorize('delete', $comment);
        Comment::where('parent_id', $comment->id)->delete();
        $comment->delete();
    }

    public function loadMoreComments()
    {
        $this->commentsToShow += 4;
    }

    public function loadLessComments()
    {
        if ($this->commentsToShow > 4) {
            $this->commentsToShow -= 4;
        }
    }

    public function loadMoreReplies($commentId)
    {
        if (!isset($this->repliesToShow[$commentId])) {
            $this->repliesToShow[$commentId] = 1;
        }

        $this->repliesToShow[$commentId] += 4;
    }

    public function loadLessReplies($commentId)
    {
        if (isset($this->repliesToShow[$commentId]) && $this->repliesToShow[$commentId] > 1) {
            $this->repliesToShow[$commentId] -= 4;
        }
    }

    public function cancelEdit()
    {
        $this->editingCommentId = null;
        $this->editingContent = '';
    }

    public function cancelReply()
    {
        $this->replyingToId = null;
        $this->replyContent = '';
    }

    private function resetForm()
    {
        $this->content = '';
        $this->replyContent = '';
        $this->editingCommentId = null;
        $this->editingContent = '';
        $this->replyingToId = null;
        $this->resetKey = uniqid();
    }

    public function render()
    {
        $comments = Comment::where('post_id', $this->postId)
            ->whereNull('parent_id')
            ->whereDoesntHave('parent', function ($query) {
                $query->onlyTrashed();
            })
            ->with(['replies' => function ($query) {
                $query->whereDoesntHave('parent', function ($subQuery) {
                    $subQuery->onlyTrashed();
                })->latest();
            }])
            ->latest()
            ->take($this->commentsToShow)
            ->get();

        return view('livewire.comments.comments', [
            'comments' => $comments
        ]);
    }
}


