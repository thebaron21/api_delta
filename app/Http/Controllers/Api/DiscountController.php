<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


  

    public function store(Request $request)
    {
        $discount = new Discount;
        $data = Validator::make(
            $request->all(),
            [
                "name"                => 'required|string|max:255',
                "description"         => 'required',
                "discount_percentage" => 'required|integer',
            ]
        );

        if($data->fails()){
            return toJsonErrorModel( $data->errors()->all() );
        }else{
            $discount->name                = $request->name;
            $discount->description         = $request->description;
            $discount->discount_percentage = $request->discount_percentage;
            $discount->active              = 1;
            $discount->save();
            return toJsonModel($discount);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discounts = Discount::all();
        return toJsonModel($discounts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
