<?php

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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