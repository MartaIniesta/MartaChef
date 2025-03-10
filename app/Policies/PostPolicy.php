<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
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

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-posts');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->hasPermissionTo('edit-posts') && $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('moderator')) {
            return true;
        }

        return $user->hasPermissionTo('delete-posts') && $user->id === $post->user_id;
    }

    public function rate(User $user, Post $post): bool
    {
        return $user->can('rate-posts') && $user->id !== $post->user_id;
    }
}
