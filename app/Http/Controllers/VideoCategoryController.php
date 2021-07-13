<?php

namespace App\Http\Controllers;

use App\Models\VideoCategory;
use Illuminate\Http\Request;

class VideoCategoryController extends Controller
{
    public function show()
    {
        $videoCategories = VideoCategory::all();
        return toJsonModel( $videoCategories );
    }
    public function showAndVideo()
    {
        return toJsonModel( VideoCategory::with("videos")->get() );
    }
}
