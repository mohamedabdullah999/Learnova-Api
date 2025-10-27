<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Traits\RoleHelper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class Sessioncontroller extends Controller
{
    use RoleHelper;

    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $imgPath = null;

        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('users', 'public');
        }

        $role = $this->getUserRole($validated['email']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'phone' => $validated['phone'],
            'img' => $imgPath,
            'role' => $role,
        ]);

        $token = auth()->login($user);

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => new UserResource($user),
        ], 200);
    }

    public function login(Request $request)
    {

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => ['required', Password::min(5)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        $token = auth()->attempt($validated);

        $user = auth()->user();

        if (! $token) {
            return response()->json([
                'status' => false,
                'message' => 'invalid Email or Password',
            ], 401);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'User logged in',
                'token' => $token,
                'user' => new UserResource($user),
            ]);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 'true',
            'message' => 'user logged out',
        ]);
    }

    public function profile()
    {
        $userData = auth()->user();

        return response()->json([
            'status' => true,
            'user' => new UserResource($userData),
        ]);
    }

    public function refresh()
    {
        $newtoken = auth()->refresh();

        return response()->json([
            'status' => true,
            'message' => 'token updated',
            'newToken' => $newtoken,
        ]);
    }
}
