<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::resource('customers', 'Admin\CustomerController');
    Route::resource('categories', 'Admin\CategoryController');
    Route::resource('subcategories', 'Admin\SubCategoryController');
    Route::resource('vehicle', 'Admin\VehicleCompanyController');
    Route::resource('brands', 'Admin\BrandController');
});


Route::group(['prefix' => 'api'], function () {
    Route::get('/', 'HomeController@index');

//    Route::resource('api/todos', 'TodosController');

    Route::get('/login', 'Auth\LoginController@index');
});
