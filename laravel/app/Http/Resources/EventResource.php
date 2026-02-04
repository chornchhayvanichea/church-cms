<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'event_time' => $this->event_time,
            'location' => $this->location,
            'image' => $this->image ? Storage::url($this->image) : null,
            'registration_link' => $this->registration_link,
            'status' => $this->status,
            'created_by' => UserResource::make($this->whenLoaded('creator', $this->creator)),
        ];
    }
}
