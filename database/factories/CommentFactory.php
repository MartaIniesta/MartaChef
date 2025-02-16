<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'content' => $this->faker->paragraph,
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Estado para crear respuestas a un comentario.
     */
    public function asReply($parentId)
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => $parentId,
        ]);
    }
}
