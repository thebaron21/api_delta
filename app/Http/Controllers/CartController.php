<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShoppingSession;
use App\Models\User;
use App\Models\TypeProduct;
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
        $req = Validator::make($request->all(), [
            'price'     => 'required|integer',
            'product_id' => 'required|integer',
            'subproduct_id' => 'required|integer'
        ]);

        if ($req->fails()) {
            return toJsonErrorModel($req->errors()->all());
        } else {
            $this->createSession($request);
            $userSession = ShoppingSession::where(["user_id" => $user->id])->first();
            $cartexsing = CartItem::where(
                [
                    "session_id"    => $userSession->id,
                    "product_id"    => $request->product_id,
                    "subproduct_id" => $request->subproduct_id,
                ]
            );
            if ($cartexsing->count() >= 1) {
                $cart2 = CartItem::where([
                    "session_id" => $userSession->id,
                    "product_id" => $request->product_id,
                    "subproduct_id" => $request->subproduct_id,
                ])->first();
                if ($request->has('quantity_id')) {
                    $cart2->quantity_id = intval($request->quantity_id);
                } else {
                    $newQuantity =  $cart2->quantity_id;
                    $cart2->quantity_id = intval($newQuantity) + 1;
                }
                $cart2->save();
                return toJsonModel($cart2);
            } else {
                $cart->session_id    = $userSession->id;
                $cart->product_id    = $request->product_id;
                $cart->subproduct_id = $request->subproduct_id;

                $cart->quantity_id = 1;
                $cart->save();
                return toJsonModel($cart);
            }
        }
    }

    public function getCart(Request $request)
    {
        $userSession = ShoppingSession::with("carts")->get();

        if ($userSession->count() == 0) {
            return toJsonErrorModel($userSession);
        } else {
            $list = array();
            $totalPrice = 0;
            foreach ($userSession[0]["carts"] as $c) {
                $price = 0;
                $product = Product::where(['id' => $c->product_id])->first();
                $price = $price + ($product->price * $c->quantity_id);
                $totalPrice = $totalPrice + ($product->price * $c->quantity_id);
                array_push($list, [
                    "quantity" => $c->quantity_id,
                    "price"    => intval($price),
                    "product"  => $product,
                ]);
            }

            return toJsonModel([
                "totalPrice" => $totalPrice,
                "orderItem" => $list
            ]);
        }
    }
    public function destroy(Request $request)
    {
        $user = $request->user();


        $userSession1 = ShoppingSession::where(["user_id" => $user->id]);
        if ($userSession1->count() >= 1) {
            $userSession = ShoppingSession::where(["user_id" => $user->id])->first();
            $cart = CartItem::where(["session_id" => $userSession->id]);
            $cart->delete();
            $userSession1->delete();
            //return $userSession->count();
            return toJsonModel(true);
        } else {
            return toJsonModel(false);
        }
    }
    public function destroyItem(Request $request, $id)
    {
        $user = $request->user();
        $userSession = ShoppingSession::where(["user_id" => $user->id])->first();
        $cart = CartItem::where(["session_id" => $userSession->id, "product_id" => $id])
            ->delete();

        return toJsonModel($cart);
    }
    public function totalPrice(Request $request) // ,$sessionId,$productId
    {
        $userId = $request->user()->id;
        $userSession = ShoppingSession::where(["user_id" => $userId])->first();
        $cart = CartItem::where(["session_id" => $userSession->id])->get();
        $price = 0;
        foreach ($cart as $c) {
            $product = Product::find($c->product_id)->first();
            $price   = ($price + $product->price) * $c->quantity_id;
        }
        return $price;
    }
}
