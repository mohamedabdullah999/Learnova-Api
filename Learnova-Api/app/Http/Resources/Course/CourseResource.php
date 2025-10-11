<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Instractor\InstructorResource;
use App\Http\Resources\Category\CategoryResource;

class CourseResource extends JsonResource
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
            'description' => $this->description,
            'image' => $this->image,
            'status' => $this->status,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'instructor' => new InstructorResource($this->whenLoaded('instructor')),
        ];
    }

}
