<?php

namespace App\Livewire;

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

    protected $rules = [
        'content' => 'nullable|max:255',
        'replyContent' => 'nullable|max:255'
    ];

    public function mount($postId)
    {
        $this->postId = $postId;
    }

    public function addComment()
    {
        $this->validate();

        $this->authorize('create', Comment::class);

        try {
            Comment::create([
                'post_id' => $this->postId,
                'user_id' => Auth::id(),
                'content' => $this->content,
            ]);
            $this->resetForm();
            $this->dispatch('comment-updated');
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un problema al agregar el comentario.');
        }
    }

    public function replyToComment($commentId)
    {
        $this->replyingToId = $commentId;
    }

    public function addReply()
    {
        $this->validate();

        $this->authorize('create', Comment::class);

        try {
            Comment::create([
                'post_id' => $this->postId,
                'user_id' => Auth::id(),
                'content' => $this->replyContent,
                'parent_id' => $this->replyingToId,
            ]);
            $this->resetForm();
            $this->dispatch('comment-updated');
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un problema al agregar la respuesta.');
        }
    }

    public function editComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $this->editingCommentId = $comment->id;
        $this->editingContent = $comment->content;
    }

    public function updateComment()
    {
        $this->validate();

        $comment = Comment::findOrFail($this->editingCommentId);

        $this->authorize('update', $comment);

        try {
            $comment->update(['content' => $this->editingContent]);
            $this->resetForm();
            $this->dispatch('comment-updated');
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un problema al actualizar el comentario.');
        }
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        $this->authorize('delete', $comment);

        try {
            $comment->delete();
            $this->dispatch('comment-updated');
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un problema al eliminar el comentario.');
        }
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

    public function render()
    {
        $comments = Comment::where('post_id', $this->postId)
            ->whereNull('parent_id')
            ->with(['replies' => function ($query) {
                $query->latest();
            }])
            ->latest()
            ->take($this->commentsToShow)
            ->get();

        return view('livewire.comments', [
            'comments' => $comments
        ]);
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
}
