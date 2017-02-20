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

Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::get('/users', 'Admin\IndexController@get_customer');
});


Route::group(['prefix' => 'api'], function () {
    Route::get('/', 'HomeController@index');

//    Route::resource('api/todos', 'TodosController');

    Route::get('/login', function(){
        return 'hello';
    });
});
