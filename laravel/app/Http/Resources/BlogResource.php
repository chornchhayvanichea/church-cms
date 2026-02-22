<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'thumbnail' => $this->thumbnail,
            'status' => $this->status,
            'author_id' => $this->author_id,
            'author' => new UserResource($this->whenLoaded('author')),
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // Table blogs {
        //  id bigint [pk, increment]
        //  title varchar [not null]
        //  slug varchar [unique, not null]
        //  content longtext [not null, note: 'HTML content']
        //  excerpt text
        //  thumbnail varchar
        //  status varchar [default: 'draft', note: 'draft, published, archived']
        //  author_id bigint [not null]
        //  published_at timestamp
        //  created_at timestamp
        //  updated_at timestamp
        // }
    }
}
