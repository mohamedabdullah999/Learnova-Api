<?php

namespace App\Http\Controllers\Lesson;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lesson\LessonRequest;
use App\Http\Requests\Lesson\UpdateLessonRequest;
use App\Http\Resources\Lesson\LessonResource;
use App\Models\Lesson;
use App\Services\CloudinaryService;

class LessonController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonRequest $request)
    {
        $data = $request->validated();

        // Handle video upload via Cloudinary
        if ($request->hasFile('video')) {
            $filePath = $request->file('video')->getRealPath();

            $cloudinary = new CloudinaryService;
            $uploaded = $cloudinary->store($filePath, 'lessons');

            $data['video_public_id'] = $uploaded['public_id'];
            $data['video_path'] = $uploaded['secure_url'];
        }

        $lesson = Lesson::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Lesson created successfully',
            'lesson' => new LessonResource($lesson->load('course')),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $data = $request->validated();

        // Handle video upload to Cloudinary
        if ($request->hasFile('video')) {
            $filePath = $request->file('video')->getRealPath();

            $cloudinary = new CloudinaryService;

            // رفع الفيديو الجديد وحذف القديم لو موجود
            $uploaded = $cloudinary->update(
                $filePath,
                $lesson->video_public_id ?? null,
                'lessons'
            );

            $data['video_path'] = $uploaded['secure_url'];
            $data['video_public_id'] = $uploaded['public_id'];
        }

        $lesson->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Lesson updated successfully',
            'lesson' => new LessonResource($lesson->load('course')),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($courseId, Lesson $lesson)
    {
        if ($lesson->course_id != $courseId) {
            return response()->json([
                'status' => false,
                'message' => 'Lesson does not belong to this course',
            ], 400);
        }

        if ($lesson->video_public_id) {
            $cloudinary = new CloudinaryService;
            $cloudinary->delete($lesson->video_public_id);
        }

        $lesson->delete();

        return response()->json([
            'status' => true,
            'message' => 'Lesson deleted successfully',
        ]);
    }
}
