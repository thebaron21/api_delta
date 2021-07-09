<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;
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
Route::get( '/user',  [ Api\UserController::class , 'index'] );
Route::post('/forget', [ Api\UserController::class , 'forgot_password']);
Route::post('/password/reset', [Api\UserController::class ,'reset'])->name('password.reset');

Route::get('/test', [ Api\CategoryController::class , 'test']);
Route::middleware('auth:api')->group( function(){

    Route::post('/cate/create', [ Api\CategoryController::class , 'create']);
    Route::get('/cate/categories', [ Api\CategoryController::class , 'show']);
    Route::get('/cate/category/{id}', [ Api\CategoryController::class , 'index']);
    Route::put('/cate/update/{id}', [ Api\CategoryController::class , 'update']);
    Route::delete('/cate/delete/{id}', [ Api\CategoryController::class , 'destroy']);

    // TODO: [Produces]

    Route::post('/pro/create', [ Api\ProductController::class , 'create']);
    Route::get('/pro/categories', [ Api\ProductController::class , 'show']);
    Route::get('/pro/category/{id}', [ Api\ProductController::class , 'index']);
    Route::put('/pro/update/{id}', [ Api\ProductController::class , 'update']);
    Route::delete('/pro/delete/{id}', [ Api\ProductController::class , 'destroy']);


});

    /*->errors()
GET: 		/api/produces		return all Produces with selected Categories or Stories
GET:		/api/produces/categores_id	return all Produces of Category
GET:		/api/produces/shop_id	return all Produces of Shop
GET:		/api/produces/id		return one Product of Selected on Screen
POST:	/api/create		return once of New Produce
PUT  : 	/api/produce/id		return Update Produce if Parameters not Empty
DELETED:	/api/produce/id`		return Boolean if Deleted Produce
GET:		/api/produce/search/name	return once product TODO handle Search By one Character

*/