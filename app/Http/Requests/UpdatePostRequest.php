<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'visibility' => 'required|in:public,private,shared',
            'image' => 'nullable|image',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ];
    }
}
