<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'content' => ['required'],
            'excerpt' => ['nullable'],
            'thumbnail' => ['nullable', 'mimes:jpg,jpeg,png,webp,gif'],
            'published_at' => ['nullable', 'date'],
            'status' => ['nullable', 'in:draft,published,archived'],
            'thumbnail_url' => ['nullable', 'url'],
        ];
    }
}
