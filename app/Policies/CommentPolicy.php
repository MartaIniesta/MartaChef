<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Comment $comment): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('create-comments');
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->can('edit-comments') && ($user->id === $comment->user_id);
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->can('delete-comments') && (
            $user->id === $comment->user_id ||
            ($user->hasRole('moderator') && !$comment->user->hasRole('admin'))
        );
    }
}
