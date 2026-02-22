<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected string $type;

    public function __construct($resource, string $type = 'full')
    {
        parent::__construct($resource);
        $this->type = $type;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->type === 'brief') {
            return [
                'id' => $this->id,
                'image' => $this->image,
                'name' => $this->name,
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->image,
            'role' => $this->role,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
