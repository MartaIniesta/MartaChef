<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'ingredients', 'image', 'user_id', 'visibility'];

    protected $casts = ['deleted_at' => 'datetime',];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc');
    }

    public function sharedWith(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'follower_id');
    }

    public function scopeVisibilityPublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeVisibilityPrivate($query, $userId)
    {
        return $query->where('visibility', 'private')->where('user_id', $userId);
    }

    public function scopeVisibilityShared($query, $userId)
    {
        return $query->where('visibility', 'shared')
            ->whereHas('sharedWith', function ($q) use ($userId) {
                $q->where('follower_id', $userId);
            });
    }
}
