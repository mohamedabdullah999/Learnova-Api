<?php

namespace App\Http\Resources\Instractor;

use App\Http\Resources\Course\CourseResource;
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
            'email' => $this->email,
            'expertises' => $this->expertises->pluck('name'),
            'bio' => $this->bio,
            'img' => $this->img,
            'linkedin' => $this->linkedin,
            'twitter' => $this->twitter,
            'courses' => CourseResource::collection($this->whenLoaded('courses')),
        ];
    }
}
