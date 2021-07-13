<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show()
    {
        $news = News::all();
        return toJsonModel( $news );
    }
    
}
