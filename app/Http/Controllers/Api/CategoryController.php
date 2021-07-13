<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CategoryController extends Controller
{

    public function create(Request $req)
    {
        $req->validate([
            'name' => 'required|max:255',
        ]);
        $category = new Category;

        if ($req->hasFile('image')) {
            $file = uploadimg2($req);
            $category->image = $file;
        }
        $category->name = $req->name;
        $category->save();
        return toJsonModel($category);
    }
    public function update(Request $req, $id)
    {
        $category = Category::find($id);

        if ($req->hasFile('image')) {
            $file = uploadimg2($req);
            $category->image = $file;
        }
        if ($req->has('name')) {
            $category->name = $req->name;
        }

        $category->save();
        return toJsonModel($category);
    }
    public function show()
    {
        $category = Category::all();
        return toJsonModel($category);
    }
    public function index($id)
    {
        $category = Category::find($id);
        return toJsonModel($category);
    }
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category->count() >= 0) {
            $category->delete();
        }
        return toJsonModel($category);
    }
    public function select(Request $req)
    {
        $category = Category::with('products')
            ->where('id', $req->id)
            ->first();
        return toArrayCategory($category);
    }

    public function test(Request $request)
    {
    }
}
