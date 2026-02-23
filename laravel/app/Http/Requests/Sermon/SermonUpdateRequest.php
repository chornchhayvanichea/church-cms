<?php

namespace App\Http\Requests\Sermon;

use Illuminate\Foundation\Http\FormRequest;

class SermonUpdateRequest extends FormRequest
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
            'speaker' => ['string', 'sometimes', 'max:255'],
            'sermon_date' => ['date', 'sometimes'],
            'description' => ['string', 'nullable', 'sometimes'],
            'notes' => ['string', 'nullable', 'sometimes'],
            'scripture_reference' => ['string', 'nullable', 'sometimes'],
            'video_url' => ['string', 'nullable', 'sometimes'],
            'pdf_url' => ['string', 'nullable', 'sometimes'],
            'thumbnail' => ['nullable', 'mimes:jpg,jpeg,png,gif,webp', 'max:5126', 'sometimes'],
            'published_at' => ['date', 'nullable', 'sometimes'],
        ];

        // Table sermons {
        //  id bigint [pk, increment]
        //  title varchar [not null]
        //  slug varchar [unique, not null]
        //  speaker varchar [not null]
        //  sermon_date date [not null]
        //  series_id bigint
        //  description text
        //  notes longtext [note: 'HTML content']
        //  scripture_reference varchar
        //  video_url varchar
        //  audio_url varchar
        //  pdf_url varchar
        //  thumbnail varchar
        //  status varchar [default: 'draft', note: 'draft, published, archived']
        //  view_count int [default: 0]
        //  created_by bigint [not null]
        //  published_at timestamp
        //  created_at timestamp
        //  updated_at timestamp
        // }
    }
}
