<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index($id)
    {
        $product = Product::find($id);
        if ($product->count() >= 1) {
            return toJsonModel($product);
        }
        return toJsonModel([]);
    }
    public function create(Request $request)
    { // Validator
        $data = Validator::make(
            $request->all(),
            [
                "name" => "required",
                "price" => "required|integer",
                "desc" => "required",
                "quantity" => "required|integer",
                "size" => "required",
                "category_id" => "required|integer",
                "shop_id" => "required|integer",
            ]
        );
        $product = new Product;
        if ($data->fails()) {
            return toJsonModel($data->errors()->all());
        } else {
            if($request->has( 'image' )){
                $product->image = $request->image;
            }

            $product->name = $request->name;
            $product->price = intval( $request->price );
            $product->desc = $request->desc;
            $product->quantity = intval( $request->quantity );
            $product->size = $request->size;
            $product->category_id = intval($request->category_id );
            $product->shop_id = intval($request->shop_id );
            $product->save();

            return toJsonModel($product);
        }
    }

    public function show()
    {
        $products = Product::all();
        return toJsonModel($products);
    }
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if($request->has( 'name' )){
            $product->name = $request->name;
        }
        if($request->has( 'price' )){
            $product->price = intval( $request->price );
        }
        if($request->has( 'desc' )){
            $product->desc = $request->desc;
        }
        if($request->has( 'quantity' )){
            $product->quantity = intval( $request->quantity );
        }
        if($request->has( 'size' )){
            $product->size = $request->size;
        }
        if($request->has( 'category_id' )){
            $product->category_id = intval($request->category_id );
        }

        $product->save();
        return toJsonModel( $product );
    }
    public function destroy(Request $request)
    {
        $product = Product::find($request->id);
        if ($product->count() >= 1) {
            $product->delete();
            return toJsonModel(["status" => "ok"]);
        }
        return toJsonModel(["status" => "no"]);
    }
    public function showShop(Request $request)
    {
        $products = Product::where( ["shop_id" => $request->id] )->get();
        return toJsonModel( $products );
    }
    public function showCate(Request $request)
    {   
        $products = Product::where( ["category_id" => $request->id] )->get();
        return toJsonModel( $products );
    }

    public function search(Request $request)
    {
        $product = Product::query()
                   ->where( 'name' , 'LIKE' , '%'. $request->q . '%' )
                   ->first();
        return toJsonModel( $product );
    }
}