<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function create(Request $request)
    {
        $req = Validator::make($request->all(),[
            'name'      => $request->name,
            'quantity'  => $request->quantity,
            'price'     => $request->price,
        ]);
    }
}
/*

$table->string('name');
$table->integer('order_id');
$table->integer('user_id');
$table->integer('quantity');
$table->integer('price');

*/