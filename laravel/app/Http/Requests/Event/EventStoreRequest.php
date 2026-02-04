<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'description' => ['nullable'],
            'event_date' => ['date', 'required'],
            'event_time' => ['nullable', 'time'],
            'end_date' => ['nullable', 'date'],
            'end_time' => ['nullable', 'time'],
            'location' => ['nullable', 'string'],
            'image' => ['nullable', 'mimes:jpg,png,jpeg,gif,webp', 'max:5126'],
            'registration_link' => ['nullable', 'string'],
        ];

    }
}
