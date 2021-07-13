<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
| [UserProfileController::class, 'show']
*/

Route::post( '/register',  [ Api\UserController::class , 'create'] );
Route::post( '/login',  [ Api\UserController::class , 'login'] );
Route::post('/forget', [ Api\UserController::class , 'forgot_password']);
Route::post('/password/reset', [Api\UserController::class ,'reset'])->name('password.reset');

Route::middleware('auth:api')->group( function(){
    Route::get( '/user',  [ Api\UserController::class , 'index'] );
    Route::delete( '/user/{id}',  [ Api\UserController::class , 'destroy'] );
    Route::post( '/user/update/{id}',  [ Api\UserController::class , 'update'] );
    Route::get( '/users',  [ Api\UserController::class , 'show'] );

    Route::post('/test', [ Api\CategoryController::class , 'test']);

    Route::post('/cate/create', [ Api\CategoryController::class , 'create']);
    Route::get('/cate/categories', [ Api\CategoryController::class , 'show']);
    Route::get('/cate/category/{id}', [ Api\CategoryController::class , 'index']);
    Route::post('/cate/update/{id}', [ Api\CategoryController::class , 'update']);
    Route::delete('/cate/delete/{id}', [ Api\CategoryController::class , 'destroy']);
    Route::get('/cate/select', [ Api\CategoryController::class , 'select']);

    // TODO: [Produces]

    Route::post('/pro/create', [ Api\ProductController::class , 'create']);
    Route::get('/pro/products', [ Api\ProductController::class , 'show']);
    Route::get('/pro/showShop/{id}', [ Api\ProductController::class , 'showShop']);
    Route::get('/pro/showCate/{id}', [ Api\ProductController::class , 'showCate']);
    Route::get('/pro/category/{id}', [ Api\ProductController::class , 'index']);
    Route::put('/pro/update/{id}', [ Api\ProductController::class , 'update']);
    Route::delete('/pro/delete/{id}', [ Api\ProductController::class , 'destroy']);
    Route::get('/pro/search',[ Api\ProductController::class , 'search']);
    // Test Sub Products [getSubProduct]
    Route::get('/pro/subProducsts',[ Api\ProductController::class , 'getSubProduct']);

    //TODO: Order

    Route::post('/order/create', [ OrderController::class , 'create']);
    Route::delete('/order/delete', [ OrderController::class , 'destroy']);
    Route::get('/order/show', [ OrderController::class , 'show']);
    Route::put('/order/update', [ OrderController::class , 'update']);
    //--------------------------------------
    Route::post('/cart/create' , [CartController::class , 'create']);
    Route::get('/cart/get' , [CartController::class , 'getCart']);
    Route::delete('/cart/delete' , [CartController::class , 'destroy']);
    Route::delete('/cart/deteleItem/{id}',[CartController::class , 'destroyItem']);
    Route::get('/cart/totalPrice' , [CartController::class , 'totalPrice']);

    //TODO: Discount
    Route::post('/dis/create' , [Api\DiscountController::class , 'store']);
    Route::get('/dis/show' , [Api\DiscountController::class , 'show']);

    //TODO: Add Order and [CWUD]
    

});

/*
    TODO: GET:		/api/produce/search/name	return once product  handle Search By one Character
*/