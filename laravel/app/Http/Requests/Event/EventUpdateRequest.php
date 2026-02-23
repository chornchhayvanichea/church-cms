<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
            'title' => ['string', 'sometimes', 'max:255'],
            'description' => ['sometimes', 'nullable'],
            'event_date' => ['date', 'sometimes', 'nullable'],
            'event_time' => ['time', 'sometimes', 'nullable'],
            'end_date' => ['date', 'sometimes', 'nullable'],
            'end_time' => ['time', 'sometimes', 'nullable'],
            'location' => ['string', 'sometimes', 'nullable'],
            'image' => ['mimes:jpg,png,jpeg,gif,webp', 'max:5126', 'sometimes', 'nullable'],
            'registration_link' => ['nullable', 'string', 'sometimes', 'nullable'],
        ];

    }
}
