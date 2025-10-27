<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Instractor\InstructorResource;
use App\Http\Resources\Lesson\LessonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'price' => $this->price,
            'status' => $this->status,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'instructor' => new InstructorResource($this->whenLoaded('instructor')),
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),
        ];
    }
}
