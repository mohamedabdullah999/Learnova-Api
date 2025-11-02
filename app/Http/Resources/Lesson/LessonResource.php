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
        $isLoggedIn = auth()->check();

        $isEnrolled = $isLoggedIn
            ? auth()->user()->isEnrolledInCourse($this->course_id)
            : false;

        $canAccessVideo = $isLoggedIn && $isEnrolled;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'video_url' => $canAccessVideo ? $this->video_path : 'You need to be logged in and buy this course to access the video URL',
            'course_id' => $this->course_id,
            'duration' => $this->duration,
            'course' => new CourseResource($this->whenLoaded('course')),
        ];
    }
}
