<?php

namespace App\Http\Resources\Lesson;

use App\Http\Resources\Course\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'video_url' => $this->video_path,
            'course_id' => $this->course_id,
            'duration' => $this->duration,
            'course' => new CourseResource($this->whenLoaded('course')),
        ];
    }
}
