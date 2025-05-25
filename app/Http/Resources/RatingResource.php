<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'post_id' => $this->post_id,
            'rating' => $this->rating,
            'user' => [
                'id' => $this->user->id ?? null,
                'name' => $this->user->name ?? 'Usuario eliminado',
            ],
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
