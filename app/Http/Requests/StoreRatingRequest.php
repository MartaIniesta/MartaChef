<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Post;

class StoreRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        $post = Post::find($this->post_id);
        if (!$post) {
            return false;
        }
        return $this->user()->can('rate', $post);
    }

    public function rules(): array
    {
        return [
            'post_id' => 'required|exists:posts,id',
            'rating'  => 'required|integer|min:1|max:5',
        ];
    }
}
