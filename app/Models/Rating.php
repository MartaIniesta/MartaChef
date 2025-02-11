<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $fillable = ['user_id', 'post_id', 'rating'];

    public function post(): belongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
