<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;
use App\Http\Controllers\CartController;
use App\Http\Controllers\VideoCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportProblemController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------|
| API Routes                                                               | 
|--------------------------------------------------------------------------|
|                                                                          | 
| Here is where you can register API routes for your application. These    | 
| routes are loaded by the RouteServiceProvider within a group which       | 
| is assigned the "api" middleware group. Enjoy building your API!         |
| -------------------------------------------------------------------------|
*/

Route::post( '/register',  [ Api\UserController::class , 'create'] );
Route::post( '/login',       [ Api\UserController::class , 'login'] )->middleware("verifiedEmail");
Route::post('/forgot',         [ Api\UserController::class , 'forgot_password'])->middleware("verifiedEmail");
Route::post('/password/reset', [Api\UserController::class ,'reset'])->name('password.reset');
Route::post( '/EmailVerified',  [ Api\UserController::class , 'emailVerified'] )->middleware('auth:api');
Route::post('/sendOTP', [Api\UserController::class ,'sendOtp'])->middleware('auth:api');


Route::middleware(['verifiedEmail','auth:api'])->group( function(){


    // ----------------------------
    Route::get( '/user',  [ Api\UserController::class , 'index'] );
    Route::delete( '/user/{id}',  [ Api\UserController::class , 'destroy'] );
    Route::post( '/user/update/{id}',  [ Api\UserController::class , 'update'] );
    Route::get( '/users',  [ Api\UserController::class , 'show'] );

    

    Route::post('/cate/create', [ Api\CategoryController::class , 'create']);
    Route::get('/cate/categories', [ Api\CategoryController::class , 'show']);
    Route::get('/cate/category/{id}', [ Api\CategoryController::class , 'index']);
    Route::post('/cate/update/{id}', [ Api\CategoryController::class , 'update']);
    Route::delete('/cate/delete/{id}', [ Api\CategoryController::class , 'destroy']);
    Route::get('/cate/select', [ Api\CategoryController::class , 'getCategoryAndProduct']);

    // TODO: [Produces]

    Route::post('/pro/create', [ Api\ProductController::class , 'create']);
    Route::get('/pro/products', [ Api\ProductController::class , 'show']);
    Route::get('/pro/showShop/{id}', [ Api\ProductController::class , 'showShop']);
    Route::get('/pro/showCate/{id}', [ Api\ProductController::class , 'showCate']);
    Route::get('/pro/category/{id}', [ Api\ProductController::class , 'index']);
    Route::put('/pro/update/{id}', [ Api\ProductController::class , 'update']);
    Route::delete('/pro/delete/{id}', [ Api\ProductController::class , 'destroy']);
    Route::get('/pro/search',[ Api\ProductController::class , 'search']);
    Route::get('/pro/subProducts',[ Api\ProductController::class , 'getSubProduct']);

    //TODO: Order

    Route::post('/order/create', [ OrderController::class , 'create']);
    Route::delete('/order/delete', [ OrderController::class , 'destroy']);
    Route::get('/order/show', [ OrderController::class , 'show']);
    Route::put('/order/update', [ OrderController::class , 'update']);
    //--------------------------------------
    Route::post('/cart/create' , [CartController::class , 'create']);
    Route::get('/cart/get' , [CartController::class , 'getCart']);
    Route::delete('/cart/delete' , [CartController::class , 'destroy']);
    Route::delete('/cart/deleteItem/{id}',[CartController::class , 'destroyItem']);
    Route::get('/cart/totalPrice' , [CartController::class , 'totalPrice']);

    //TODO: Discount
    Route::post('/dis/create' , [Api\DiscountController::class , 'store']);
    Route::get('/dis/show' , [Api\DiscountController::class , 'show']);

    //TODO: Report a Problme
    
    Route::post('/report/create', [ ReportProblemController::class , 'create']);
    Route::delete('/report/delete/{id}', [ ReportProblemController::class , 'destroy']);
    Route::get('/report/show', [ ReportProblemController::class , 'getReport']);
    Route::put('/report/update/{id}', [ ReportProblemController::class , 'update']);

    // News

    Route::get('/news/show', [ NewsController::class , 'show']);

    // Video And Categories Videos
    Route::get( '/video/categories' , [VideoCategoryController::class , 'show'] );
    Route::get( '/videos/videos' , [VideoCategoryController::class , 'showAndVideo'] );
    

    // Studio
    Route::get( '/studio' , [StudioController::class , 'show'] );

   
    
});
