<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show($id)
    {
        $videos = Video::where("video_categories_id",$id)->get();
        return toJsonModel( $videos );
    }
}
