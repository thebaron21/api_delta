<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /*
GET: 		/api/produces		return all Produces with selected Categories or Stories
GET:		/api/produces/categores_id	return all Produces of Category
GET:		/api/produces/shop_id	return all Produces of Shop
GET:		/api/produces/id		return one Product of Selected on Screen
POST:	/api/create		return once of New Produce
PUT  : 	/api/produce/id		return Update Produce if Parameters not Empty
DELETED:	/api/produce/id`		return Boolean if Deleted Produce
GET:		/api/produce/search/name	return once product TODO handle Search By one Character

*/
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
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product >= 1) {
            $product->delete();
            return toJsonModel(["status" => "ok"]);
        }
        return toJsonModel(["status" => "no"]);
    }
}
