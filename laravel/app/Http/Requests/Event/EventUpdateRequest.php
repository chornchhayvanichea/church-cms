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
            'description' => ['sometimes'],
            'event_date' => ['date', 'sometimes'],
            'event_time' => ['time', 'sometimes'],
            'end_date' => ['date', 'sometimes'],
            'end_time' => ['time', 'sometimes'],
            'location' => ['string', 'sometimes'],
            'image' => ['mimes:jpg,png,jpeg,gif,webp', 'max:5126', 'sometimes'],
            'registration_link' => ['nullable', 'string', 'sometimes'],
        ];

    }
}
