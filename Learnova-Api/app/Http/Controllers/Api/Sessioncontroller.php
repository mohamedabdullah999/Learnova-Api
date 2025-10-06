<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\StoreUserRequest;

class Sessioncontroller extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $imgPath = null;

        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('users', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password'=> $validated['password'],
            'phone' => $validated['phone'],
            'img' => $imgPath,
            'role' => $validated['role'] ?? 'user',
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => new UserResource($user)
        ], 200);
    }

    public function login(Request $request){

        $validated = $request->validate([
            'email' => 'required|email',
            'password'=> ['required' , Password::min(5)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        $token = auth()->attempt($validated);

        if(!$token){
            return response()->json([
                'status' => false,
                'message' => 'invalid Email or Password'
            ]);
        }
        else{
            return response()->json([
                'status' => true,
                'message' => 'User logged in',
                'token' => $token
            ]);
        }
    }

    public function logout(){
        auth()->logout();

        return response()->json([
            'status' => 'true',
            'message' => 'user logged out'
        ]);
    }

    public function profile(){
        $userData = auth()->user();

        return response()->json([
            'status' => true,
            'user' => new UserResource($userData)
        ]);
    }

    public function refresh(){
        $newtoken = auth()->refresh();

        return response()->json([
            'status' => true ,
            'message' => 'token updated' ,
            'newToken' => $newtoken
        ]);
    }

}
