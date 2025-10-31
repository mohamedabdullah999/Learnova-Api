<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\Course\CourseResource;
use App\Models\Course;
use App\Services\CloudinaryService;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function allCourses()
    {
        $courses = Course::with(['category', 'instructor'])->latest()->get();

        return response()->json([
            'courses' => CourseResource::collection($courses),
        ], 200);
    }

    public function index()
    {
        $courses = Course::with(['category', 'instructor', 'lessons'])->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Courses retrieved successfully',
            'courses' => CourseResource::collection($courses),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('img')) {
            $filePath = $request->file('img')->getRealPath();

            $cloudinary = new CloudinaryService;
            $uploaded = $cloudinary->store($filePath, 'courses');

            $data['img'] = $uploaded['secure_url'];
            $data['img_public_id'] = $uploaded['public_id'];
        }

        $course = Course::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Course created successfully',
            'course' => new CourseResource($course),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return response()->json([
            'status' => true,
            'message' => 'Course retrieved successfully',
            'course' => new CourseResource($course->load(['category', 'instructor', 'lessons'])),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $data = $request->validated();

        if ($request->hasFile('img')) {
            $filePath = $request->file('img')->getRealPath();

            $cloudinary = new CloudinaryService;
            $uploaded = $cloudinary->update($filePath, $course->img_public_id, 'courses');

            $data['img'] = $uploaded['secure_url'];
            $data['img_public_id'] = $uploaded['public_id'];
        }

        $course->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Course updated successfully',
            'course' => new CourseResource($course->load(['category', 'instructor'])),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        foreach ($course->lessons as $lesson) {
            if ($lesson->video_public_id) {
                $cloudinary = new CloudinaryService;
                $cloudinary->delete($lesson->video_public_id);
            }
        }

        $course->delete();

        return response()->json([
            'status' => true,
            'message' => 'Course deleted successfully',
        ]);
    }
}
