<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ShoppingSession;
use App\Models\OrderItem;
use App\Models\OrdreDetails;
use App\Models\CartItem;

class OrderController extends Controller
{
    public function show(Request $request)
    {
        $orders = Order::all();
        return toJsonModel($orders);
    }

    public function create(Request $request)
    {

        $data = Validator::make(
            $request->all(),
            [
                'total'     => 'required',
                'price'     => 'required|integer',
                'location'  => 'required',
                'quantity'  => 'required|integer',
            ]
        );


        if ($data->fails()) {
            return toJsonErrorModel($data->errors()->all());
        } else {
            $user = $request->user();
            // $this->createSession($request);
            $userSession = ShoppingSession::where(["user_id" => $user->id])->first();
            $cartexsing = CartItem::where(["session_id" => $userSession->id])->get();
    
            $quantity = 0;
            foreach ($cartexsing as $cart) {
                $quantity = $quantity + $cart->quantity_id;
            }
            $orderDetails = new OrdreDetails;
            $order = new OrderItem;

            // Save to Order Details
            $orderDetails->total      = $request->total;
            $orderDetails->price      = $request->proce; 
            $orderDetails->user_id    = $user->id;
            $orderDetails->location   = $request->location;
            $orderDetails->save();
            // Save to Order
            // $order->order_id = $orderDetails->id;
            // $order->cart_id  = $cartexsing[0]->session_id;
            // $order->quantity = $quantity;
            $order->save();
            return toJsonModel([
                "quantity"     => $quantity,
                "orderDetails" => $orderDetails,
                "order"        => $order
            ]);

        }
    }

    public function destroy(Request $request)
    {
            $user = $request->user();
            $userSession = ShoppingSession::where(["user_id" => $user->id])->first();
            $order = CartItem::where(["session_id" => $userSession->id])->get();
        if ($order->count() >= 1) {
            $order->delete();
            return toJsonModel($order);
        }
        return toJsonErrorModel($order);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $userSession = ShoppingSession::where(["user_id" => $user->id])->first();
        $order = CartItem::where([
        "session_id" => $userSession->id,
        "id" => $id,
        ])->get();

        if ($request->has('location')) {
            $order->location = $request->location;
        }

        if ($request->has('price')) {
            $order->price = $request->price;
        }

        if ($request->has('total')) {
            $order->total = $request->total;
        }
        $order->save();
        return toJsonModel($order);
    }
}
