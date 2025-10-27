<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class ForgetPaswordController extends Controller
{
    public function sendResetLink(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Generate a unique token
        $token = bin2hex(random_bytes(16));

        // Store the token in the database (you may want to create a separate table for this)
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );

        // Send the reset link via email
        \App\Jobs\SendResetPasswordEmail::dispatch($request->email, $token);

        return response()->json([
            'status' => true,
            'message' => 'Password reset link sent to your email.',
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        // validate
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(5)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
        ]
        );

        // Check if the token is valid and email

        $user = DB::table('password_reset_tokens')->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid token or email.',
            ], 400);
        }

        // Update the user's password

        $user = User::where('email', $request->email)->first();
        $user->password = $request->password;
        $user->save();

        // Delete the token after successful password reset
        DB::table('password_reset_tokens')->where('email', $request->email)->where('token', $request->token)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Password has been reset successfully.',
        ], 200);
    }
}
