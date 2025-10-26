<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instractor\StoreInstructorRequest;
use App\Http\Requests\Instractor\UpdateInstructorRequest;
use App\Http\Resources\Instractor\InstructorResource;
use App\Models\Instructor;
use App\Services\CloudinaryService;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructors = Instructor::with('courses.category')->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Instructors retrieved successfully',
            'instructors' => InstructorResource::collection($instructors),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstructorRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->getRealPath();

            $cloudinary = new CloudinaryService;
            $uploaded = $cloudinary->update($filePath, null, 'instructors');

            $data['img_public_id'] = $uploaded['public_id'];
            $data['image'] = $uploaded['secure_url'];
        }
        $instructor = Instructor::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Instructor created successfully',
            'instructor' => new InstructorResource($instructor),
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Instructor $instructor)
    {
        return response()->json([
            'status' => true,
            'message' => 'Instructor retrieved successfully',
            'instructor' => new InstructorResource($instructor->load('courses.category')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstructorRequest $request, Instructor $instructor)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->getRealPath();

            $cloudinary = new CloudinaryService;
            $uploaded = $cloudinary->update($filePath, $instructor->img_public_id, 'instructors');

            $data['img_public_id'] = $uploaded['public_id'];
            $data['image'] = $uploaded['secure_url'];
        }

        $instructor->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Instructor updated successfully',
            'instructor' => new InstructorResource($instructor),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        // Delete image if exists
        if ($instructor->image) {
            Storage::disk('public')->delete($instructor->image);
        }

        $instructor->delete();

        return response()->json([
            'status' => true,
            'message' => 'Instructor deleted successfully',
        ]);
    }
}
