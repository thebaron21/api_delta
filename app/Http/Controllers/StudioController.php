<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Studio;

class StudioController extends Controller
{
    public function show()
    {
        $studio = Studio::all();
        return toJsonModel( $studio );
    }
}
