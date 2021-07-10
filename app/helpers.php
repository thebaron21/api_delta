<?php

use App\Models\Category;

function toJsonModel($data)
{

    return response([
        "status" => 200,
        "data" => $data
    ], 200, [
        'Accept' => 'application/json'
    ]);
}
function toJsonErrorModel($data)
{

    return response([
        "status" => 200,
        "data" => $data
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
