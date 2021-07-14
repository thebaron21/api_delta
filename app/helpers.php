<?php

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

function toJsonModel($data)
{

    return response([
        "status" => 200,
        "data" => $data
    ], 200, [
        'Accept' => 'application/json'
    ]);
}
function toJsonErrorModel($datas)
{
    return response([
        "status" => 200,
        "data" => $datas
    ], 500, [
        'Accept' => 'application/json'
    ]);
}

function toArrayCategory($request)
{
    return [
        'status' => 200,
        'data' => [
            "id" => $request->id,
            "name" => $request->name,
            "image" => $request->image,
            "products" => $request->products
        ]
    ];
}


function uploadImage($bytes,$nameFile,$exe)
{
    $data = base64_decode($bytes);
   $handle = fopen( "upload/image/{$nameFile}.{$exe}" , 'wb' );
}


 
// Function to generate OTP
function generateNumericOTP($n) {
    $generator = "1357902468";

    $result = "";
  
    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand()%(strlen($generator))), 1);
    }
  
    // Return result
    return $result;
}


function uploadimg(Request $request)
{
       $file = $request->file('avatar');
       $filename = "image". '_' . date('D_d_M_Y_H_i_s') . '_' . $file->getClientOriginalName();
       $url = url('/'). '/storage/images/' . $filename;
       Storage::disk('public')
       ->putFileAs(
           "/",
           $file,
           $filename
       );
       return $url;
}
function uploadimg2(Request $request)
{
       $file = $request->file('image');
       $name = str_replace(' ', '_', $file->getClientOriginalName()); 
       $filename = "image". '_' . date('D_d_M_Y_H_i_s') . '_' .$name;
       $url = url('/'). '/storage/images/' . $filename;
       Storage::disk('public')
       ->putFileAs(
           "/",
           $file,
           $filename
       );
       return $url;
}


function sendOTP($to_email,$to_name,$otp)
{
    $data = array("OTP" => $otp);

    Mail::send("test", $data, function($message) use ($to_name, $to_email) {
    
        $message->to($to_email, $to_name)->subject("OTP");

        $message->from("ahmedmhmedkhllil@gmail.com","The Baron");

    });    
}