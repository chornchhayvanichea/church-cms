<?php

namespace App\Http\Requests\Series;

use Illuminate\Foundation\Http\FormRequest;

class SeriesUpdateRequest extends FormRequest
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
            'name' => ['string', 'sometimes', 'max:255'],
            'description' => ['sometimes', 'string', 'nullable'],
            'thumbnail' => ['sometimes', 'file', 'nullable', 'mimes:jpg,png,jpeg,gif,webp', 'max:5128'],
            'start_date' => ['sometimes', 'date', 'nullable'],
            'end_date' => ['sometimes', 'date', 'nullable'],
        ];
    }
}
