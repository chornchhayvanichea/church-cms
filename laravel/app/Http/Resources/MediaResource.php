<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'uuid' => $this->uuid,
            'collection_name' => $this->collection_name,
            'name' => $this->name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'disk' => $this->disk,
            'size' => $this->size,
            'original_url' => app()->environment('local')
                ? str_replace('http://localhost:8000', 'http://localhost:3000', $this->original_url)
                : $this->original_url,
            'preview_url' => $this->preview_url,
        ];
    }
}
