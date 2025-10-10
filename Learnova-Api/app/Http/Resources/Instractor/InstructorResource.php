<?php

namespace App\Http\Resources\Instractor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
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
            'name' => $this->name,
            'bio' => $this->bio,
            'expertise' => $this->expertise,
            'img' => $this->image ? asset('storage/' . $this->image) : null,
            'linkedin' => $this->linkedin,
            'twitter' => $this->twitter,
        ];
    }
}
