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

Route::group(['prefix' => 'admin', 'middleware' => 'IsAdmin'], function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::resource('customers', 'Admin\CustomerController');
    Route::resource('categories', 'Admin\CategoryController');
    Route::post('categories/status', 'Admin\CategoryController@categoryStatus')->name('categories-status');
    Route::resource('subcategories', 'Admin\SubCategoryController');
    Route::get('subcategories/show/{id}', 'Admin\SubCategoryController@showSubCategory')->name('subcategories-show');
//    Route::resource('subsubcategories', 'Admin\SubSubCategoryController');
//    Route::get('subsubcategories/show/{id}', 'Admin\SubSubCategoryController@showSubSubCategory')->name('subsubcategories-show');
    Route::resource('vehicle', 'Admin\VehicleCompanyController');
    Route::resource('vehicle_model', 'Admin\VehicleModelController');
    Route::resource('brands', 'Admin\BrandController');
    Route::resource('products', 'Admin\ProductController');
    Route::resource('orders', 'Admin\OrderController');
    Route::post('import/csv', 'Admin\ImportController@uploadCsv')->name('import.csv');
});
Route::get('/', 'HomeController@index');
Route::get('login', 'Auth\LoginController@index');
Route::get('password/email', 'Auth\ForgotPasswordController@index');
Route::post('password/email', 'Auth\ForgotPasswordController@getEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@index')->name('password-reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::post('login', 'Auth\LoginController@login');
Route::get('register', 'Auth\RegisterController@index');
Route::post('register', 'Auth\RegisterController@create');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('products', 'ProductController@index');
Route::get('single-product', 'ProductController@singleProduct');
Route::get('cart', 'ProductController@Cart');
Route::get('my-account', 'AccountController@index');
Route::post('my-account/profile', 'AccountController@updateProfile');
Route::post('my-account/shipping', 'AccountController@updateShipping');
Route::post('my-account/billing', 'AccountController@updateBilling');
Route::post('my-account/change-password', 'AccountController@changePassword');
Route::post('my-account/getState', 'AccountController@getStateByCountryId');
Route::post('my-account/getCity', 'AccountController@getCityByStateId');
Route::get('account/activate/{code}', array(
    'as' => 'account.activate',
    'uses' => 'AccountController@getActivate'
));
Route::get('/{slug}', 'SubCategoryController@getSubSubcategory');
Route::get('/{company}/{slug}', 'SubSubCategoryController@getSubSubSubcategory');

// Auth::routes();
 
 
//Route::group(['prefix' => 'api'], function () {
   

//    Route::resource('api/todos', 'TodosController');

   
//});
