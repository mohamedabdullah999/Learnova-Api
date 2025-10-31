<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();

        return response()->json([
            'status' => true,
            'users' => $users,
        ], 200);
    }
}
