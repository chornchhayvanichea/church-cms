<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SermonResource extends JsonResource
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
            'speaker' => $this->speaker,
            'sermon_date' => $this->sermon_date,
            'series_id' => SeriesResource::make($this->whenLoaded('series')),
            'description' => $this->description,
            'notes' => $this->notes,
            'scripture_reference' => $this->scripture_reference,
            'video_url' => $this->video_url,
            'audio_url' => $this->audio_url,
            'pdf_url' => $this->pdf_url,
            'thumbnail' => $this->thumbnail,
            'status' => $this->status,
            'view_count' => $this->view_count,
            'created_by' => UserResource::make($this->whenLoaded('user')),
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
