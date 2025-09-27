<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\User\UserAvatarResource;
use App\Http\Requests\User\AvatarUserRequest;
use App\Http\Requests\User\ProfileUserRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;



class ProfileController extends Controller
{
    public function updateProfile(ProfileUserRequest $request)
    {
        $user = auth()->user();

        $validated = $request->validated();

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => new UserProfileResource($user)
        ]);
    }

    public function updateAvatar(AvatarUserRequest $request)
    {
        $user = auth()->user();

        $validated = $request->validated();

        if ($request->hasFile('img')) {

            if ($user->img) {
                \Storage::disk('public')->delete($user->img);
            }

            $imgPath = $request->file('img')->store('users', 'public');
            $user->img = $imgPath;
            $user->save();
        }

        return response()->json([
            'message' => 'Avatar updated successfully',
            'user' => new UserAvatarResource($user)
        ]);
    }
}
