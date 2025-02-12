<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('post'));
    }

    public function rules(): array
    {
        $post = $this->route('post');

        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'visibility' => 'required|in:public,private,shared',
            'categories' => 'required|array|min:1|max:4',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|string',
            'image' => $post && $post->image ? 'sometimes|image' : 'required|image',
        ];
    }
}
