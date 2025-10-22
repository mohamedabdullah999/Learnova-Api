<?php

namespace App\Http\Controllers\Lesson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Lesson\LessonRequest;
use App\Http\Requests\Lesson\UpdateLessonRequest;
use App\Http\Resources\Lesson\LessonResource;
use App\Models\Lesson;

class LessonController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonRequest $request)
    {
        $data = $request->validated();

        // Handle video upload
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('lessons/videos', 'public');
            $data['video_path'] = $videoPath;
        }

        $lesson = Lesson::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Lesson created successfully',
            'lesson' => new LessonResource($lesson->load('course'))
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

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos', 'public');
            $data['video_path'] = $videoPath;
        }

        $lesson->update($data);

        return new LessonResource($lesson->load('course'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($courseId, Lesson $lesson)
    {
        if ($lesson->course_id != $courseId) {
            return response()->json([
            'status' => false,
            'message' => 'Lesson does not belong to this course'
            ], 400);
        }

        $lesson->delete();

        return response()->json([
            'status' => true,
            'message' => 'Lesson deleted successfully'
        ]);
    }

}
