<?php

namespace App\Http\Requests\Sermon;

use Illuminate\Foundation\Http\FormRequest;

class SermonStoreRequest extends FormRequest
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
            'title' => ['string', 'required', 'max:255'],
            'speaker' => ['string', 'required', 'max:255'],
            'sermon_date' => ['date', 'required'],
            'description' => ['string', 'nullable'],
            'notes' => ['string', 'nullable'],
            'scripture_reference' => ['string', 'nullable'],
            'video_url' => ['string', 'nullable'],
            'pdf_url' => ['string', 'nullable'],
            'thumbnail' => ['nullable', 'mimes:jpg,jpeg,png,gif,webp', 'max:5126'],
            'published_at' => ['date', 'nullable'],
        ];
    }
}
