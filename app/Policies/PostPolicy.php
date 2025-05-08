<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(?User $user, Post $post): bool
    {
        if (!$user) {
            return $post->visibility === 'public';
        }

        return $post->visibility === 'public' ||
            $user->id === $post->user_id ||
            $user->hasRole('admin') ||
            $user->hasRole('moderator');
    }

    public function create(User $user): bool
    {
        return $user->can('create-posts');
    }

    public function update(User $user, Post $post): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->can('edit-posts') && $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('moderator')) {
            return true;
        }

        return $user->can('delete-posts') && $user->id === $post->user_id;
    }

    public function restore(User $user, Post $post): bool
    {
        return $user->can('restore-posts');
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return $user->can('force-delete-posts');
    }

    public function rate(User $user, Post $post): bool
    {
        return $user->can('rate-posts') && $user->id !== $post->user_id;
    }
}
