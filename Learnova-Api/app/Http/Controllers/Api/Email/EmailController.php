<?php

namespace App\Http\Controllers\Api\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\WelcomeToDevelopers;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function welcomeToDevelopers()
    {

        Mail::to("ahmedalinaguib33@gmail.com")->send(new WelcomeToDevelopers());

        return response()->json([
            'message' => 'Welcome email sent successfully'
        ]);
    }
}
