<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'post_id', 'user_id', 'parent_id'];

    public function post(): belongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): belongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): hasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
