<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;
class HomeController extends Controller
{

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return response()->json(["message" => __("auth.user_verified_successfully")], Response::HTTP_RESET_CONTENT);
    }
}
