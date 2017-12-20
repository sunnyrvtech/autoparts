<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/orders', 'Api\ApiController@getOrderDetails');
    Route::post('/orders', 'Api\ApiController@postOrderDetails');
    Route::get('/products', 'Api\ApiController@getProductDetails');
    Route::post('/products/add', 'Api\ApiController@addProductDetails');
    Route::post('/products/update', 'Api\ApiController@updateProductDetails');
    Route::get('/products/delete', 'Api\ApiController@deleteproducts');
});
