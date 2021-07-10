<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;

class OrderController extends Controller
{
    public function show(Request $request)
    {
        $orders = Order::all();
        return toJsonModel($orders);
    }

    public function create(Request $request)
    {
        $data =  $request->all();
        $order =  Order::create($data);
        // $cart =  Cart::create($data);
        return ["order" => $order];
        // $data = Validator::make($request->all(),
        // [
        //     'products'  => 'required',
        //     'tax'       => 'required|integer',
        //     'price'     => 'required|integer',
        //     'location'  => 'required',
        //     'lat'       => 'required',
        //     'long'      => 'required',
        //     'quantity'  => 'required|integer',
        //     'price'     => 'required|integer',
        // ]);

        // $user = $request->user();
        // if($data->fails()){
        //     return toJsonErrorModel( $data->errors()->all() );
        // }else{
        //     $order = new Order();
        //     $cart = new Cart();
        //     // Save to Order
        //     $order->user_id    = $user->id;
        //     $order->tax        = $request->tax;
        //     $order->price      = $request->price;
        //     $order->products   = $request->products;
        //     $order->lat        = $request->lat;
        //     $order->long       = $request->long;
        //     $order->location   = $request->location;
        //     $order->save();
        //     // Save to Cart
        //     $data = $request->products;
        //     $d = implode(",",$data);
        //     foreach ($data as $value) {
        //         $product = Product::find( intval( $value ) );
        //         $cart->name     = $product->name;
        //         $cart->quantity = $request->quantity;
        //         $cart->price    = $request->price;
        //         $cart->order_id = $order->id;
        //         $cart->user_id  = $user->id;
        //         $cart->save();
        //     }

        //     return toJsonModel( ["order" => $order , "cart" => $cart ] );
        // }
    }

    public function destroy(Request $request)
    {
        $order = Order::find($request->id);
        if( $order->count() >= 1 ){
            $order->delete();
            return toJsonModel( $order );
        }
        return toJsonErrorModel( $order );
    }

    public function update(Request $request,$id)
    {
        $order = Order::find($id);

        if( $request->has('location') ){
            $order->location = $request->location;
        }
        if( $request->has('lat') ){
            $order->lat = $request->lat;
        }
        if( $request->has('long') ){
            $order->long = $request->long;
        }
        if( $request->has('price') ){
            $order->price = $request->price;
        }
        if( $request->has('products') ){
            $order->products = $request->products;
        }
        $order->save();
        return toJsonModel($order);
    }

    public function logCart(Request $request)
    {
        $user = $request->user();
        $orders = Order::where( 'user_id',$user->id )->get();

    }
}