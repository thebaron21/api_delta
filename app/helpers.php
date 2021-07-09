<?php

use App\Models\Category;

function toJsonModel($data)
{
    
    return response([
        "status" => 200,
        "data" => $data
    ],200,[
        'Accept' => 'application/json'
    ]);
}