<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;
class HomeController extends Controller
{
    public function resend(Request $request)
    {
        sendOTP('83b6da4cb4@firemailbox.club','thebaron',550545);
        // $to_name = "RECEIVER_NAME";
        // $to_email = "83b6da4cb4@firemailbox.club";
        // $data = array("name"=> "Ogbonna Vitalis(sender_name)", "body" => "A test mail");
        // Mail::send("test", $data, function($message) use ($to_name, $to_email) {
        // $message->to($to_email, $to_name)
        // ->subject("Laravel Test Mail");
        // $message->from("ahmedmhmedkhllil@gmail.com","Test Mail");
        // });
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return response()->json(["message" => __("auth.user_verified_successfully")], Response::HTTP_RESET_CONTENT);
    }
}
