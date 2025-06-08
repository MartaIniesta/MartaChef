<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens, SoftDeletes;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'follower_id');
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followed_id');
    }

    public function follow(User $user): void
    {
        if ($this->id !== $user->id && !$this->isFollowing($user)) {
            $this->following()->attach($user);
        }
    }

    public function unfollow(User $user): void
    {
        if ($this->isFollowing($user)) {
            $this->following()->detach($user);
        }
    }

    public function isFollowing(User $user): bool
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }

    public function scopeIsFollowing($query, User $user)
    {
        return $query->whereHas('following', function ($q) use ($user) {
            $q->where('followed_id', $user->id);
        });
    }

    public function favoritePosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'favorites')
            ->withPivot('note')
            ->withTimestamps();
    }

    public function scopeVisibleProfiles(Builder $query)
    {
        if (auth()->check()) {
            $authUser = auth()->user();

            if ($authUser->hasRole('user')) {
                return $query->where('id', '!=', $authUser->id)
                ->whereDoesntHave('roles', function ($q) {
                    $q->whereIn('name', ['admin', 'moderator']);
                });
            }

            if ($authUser->hasRole('admin')) {
                return $query->where('id', '!=', $authUser->id);
            }

            if ($authUser->hasRole('moderator')) {
                return $query->where('id', '!=', $authUser->id)
                ->whereDoesntHave('roles', function ($q) {
                    $q->where('name', ['admin', 'moderator']);
                });
            }
        }

        return $query->whereHas('roles', function ($q) {
            $q->where('name', 'user');
        });
    }
}
