<?php

namespace App\Jobs;

use App\Models\Comment;

class DeleteOldCommentsJob
{
    public function handle(): int
    {
        return Comment::where('created_at', '<', now()->subMonths(3))->delete();
    }
}
