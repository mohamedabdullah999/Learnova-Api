<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AvatarUserRequest;
use App\Http\Requests\User\ProfileUserRequest;
use App\Http\Resources\User\UserProfileResource;
use App\Services\CloudinaryService;

class ProfileController extends Controller
{
    public function updateProfile(ProfileUserRequest $request)
    {
        $user = auth()->user();

        $validated = $request->validated();

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => new UserProfileResource($user),
        ]);
    }

    public function updateAvatar(AvatarUserRequest $request)
    {
        $user = auth()->user();

        if ($request->hasFile('img')) {
            $filePath = $request->file('img')->getRealPath();

            $cloudinary = new CloudinaryService;
            $uploaded = $cloudinary->update($filePath, $user->img_public_id, 'users');

            $user->update([
                'img' => $uploaded['secure_url'],
                'img_public_id' => $uploaded['public_id'],
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Avatar updated successfully',
                'url' => $uploaded['secure_url'],
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'No Avatar Passed',
        ], 400);
    }

    public function enrollments()
    {
        $user = auth()->user();
        $enrollments = $user->courses()->with('category', 'instructor', 'lessons')->get();

        return response()->json([
            'message' => 'Enrollments retrieved successfully',
            'enrollments' => $enrollments,
        ]);
    }
}
