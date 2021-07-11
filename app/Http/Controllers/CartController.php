<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ShoppingSession;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function createSession(Request $request)
    {
        $user = $request->user();
        $session2 = ShoppingSession::where(["user_id" => $user->id]);
        if ($session2->count() == 0) {
            $session1 = new  ShoppingSession;
            $session1->user_id = $user->id;
            $session1->total = "0";
            $session1->save();
        }
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $cart = new CartItem();
        $userSession2 = new ShoppingSession();
        $req = Validator::make($request->all(), [
            'price'     => $request->price,
            'product_id' => $request->product_id
        ]);

        $this->createSession($request);
        $userSession = ShoppingSession::where(["user_id" => $user->id])->first();
        $cartexsing = CartItem::where(
            [
                "session_id" => $userSession->id,
                "product_id" => $request->product_id
            ]
        );
        if ($cartexsing->count() >= 1) {
            $cart2 = CartItem::where([
                "session_id" => $userSession->id,
                "product_id" => $request->product_id
            ])->first();
            if($request->has('quantity_id')){
                $cart2->quantity_id = intval($request->quantity_id);
            }else{
                $newQuantity =  $cart2->quantity_id;
                $cart2->quantity_id = intval($newQuantity) + 1;
            }
            $cart2->save();
            return toJsonModel($cart2);
        } else {
            $cart->session_id = $userSession->id;
            $cart->product_id = $request->product_id;
            $cart->quantity_id = 1;
            $cart->save();
            return toJsonModel($cart);
        }
    }
    //increment and decrement
    public function getCart(Request $request)
    {
        $user = $request->user();
        $userSession = ShoppingSession::where(["user_id" => $user->id])->first();

        $cart = CartItem::where(["session_id" => $userSession->id])->get();
        $listProducts = array();
        $total = 0;
        foreach ($cart as $c) {
            $product = Product::where(['id' => $c->product_id])->first();
            $total = $total + $product->price;
            array_push($listProducts, $product);
        }
        return toJsonModel([ 'products' => $listProducts, 'total' => $this->totalPrice($user->id) ]);
    }
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $userSession = ShoppingSession::where(["user_id" => $user->id])->first();
        $cart = CartItem::where(["session_id" => $userSession->id, 'product_id' => $id])
            ->delete();
        return toJsonModel($cart);
    }
    public function totalPrice($userId) // ,$sessionId,$productId
    {
        $userSession = ShoppingSession::where(["user_id" => $userId])->first();
        $cart = CartItem::where(["session_id" => $userSession->id])->get();
        $price = 0;
        foreach( $cart as $c ){
            $product = Product::find($c->product_id)->first();
            $price   = ($price + $product->price) * $c->quantity_id;
        }
        return $price;
    }
}
