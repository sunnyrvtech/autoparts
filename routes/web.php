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
Route::get('/home', 'HomeController@index');
Route::post('/localZone','HomeController@getlocalRegion');
Route::group(['prefix' => 'admin', 'middleware' => 'IsAdmin'], function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::resource('customers', 'Admin\CustomerController');
//    Route::resource('warehouses', 'Admin\WareHouseController');
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
//    Route::resource('zones', 'Admin\ProductZoneController');
    Route::resource('tax_rates', 'Admin\TaxRateController');
    Route::resource('shipping', 'Admin\ShippingController');
    Route::resource('shipping_rates', 'Admin\ShippingRateController');
    Route::resource('static_page', 'Admin\StaticPageController');
    Route::resource('coupon_code', 'Admin\CoupanCodeController');
    Route::resource('orders', 'Admin\OrderController');
    Route::post('orders/status', 'Admin\OrderController@orderStatus')->name('orders-status');
    Route::post('import/csv', 'Admin\ImportController@uploadCsv')->name('import.csv');
    Route::post('import/images', 'Admin\ImportController@uploadProductImages')->name('import.images');
    Route::post('export/sample/csv', 'Admin\ImportController@exportSampleCsv')->name('export-sample-csv');
    Route::post('export/csv', 'Admin\ImportController@exportCsv')->name('export.csv');
    Route::post('import/category', 'Admin\ImportController@createCategoryByCsv')->name('import.category');
    Route::post('import/delete_product', 'Admin\ImportController@deleteProductData')->name('import.delete_product');
    Route::get('api/token', 'Admin\IndexController@createApiToken')->name('api.token');
});
Route::get('login', 'Auth\LoginController@index');
Route::get('password/email', 'Auth\ForgotPasswordController@index');
Route::post('password/email', 'Auth\ForgotPasswordController@getEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@index')->name('password-reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::post('login', 'Auth\LoginController@login');
Route::get('register', 'Auth\RegisterController@index');
Route::post('register', 'Auth\RegisterController@create');
Route::get('logout', 'Auth\LoginController@logout');
//Route::get('products', 'ProductController@index');
Route::post('products/vehicle', 'ProductController@getProductVehicleCompanyByYear');
Route::post('products/vehicle_model', 'ProductController@getProductVehicleModelByMakeId');
Route::get('products/search', 'ProductController@searchProduct');
Route::get('products/{slug}', 'ProductController@singleProduct');
Route::resource('checkout','PaymentController');
Route::post('cart/add', 'ProductController@addCart')->middleware('web');
Route::post('cart/update', 'ProductController@updateCart')->middleware('web');
Route::post('cart/delete', 'ProductController@deleteCart');
Route::get('cart', 'ProductController@Cart')->name('cart');
Route::get('track_order', 'OrderController@index');
Route::post('track_order', 'OrderController@postTrackOrder')->name('track_order');
Route::get('my-account', 'AccountController@index')->name('my-account');
Route::post('my-account/profile', 'AccountController@updateProfile');
Route::get('my-account/order', 'AccountController@getOrderList')->name('order');
Route::get('my-account/order/view/{id}', 'AccountController@getOrderDetails');
Route::get('my-account/shipping', 'AccountController@getShipping')->name('shipping');
Route::post('my-account/shipping', 'AccountController@updateShipping');
Route::get('my-account/billing', 'AccountController@getBilling')->name('billing');
Route::post('my-account/billing', 'AccountController@updateBilling');
Route::get('my-account/change-password', 'AccountController@getPassword')->name('change-password');
Route::post('my-account/change-password', 'AccountController@changePassword');
Route::post('my-account/getState', 'AccountController@getStateByCountryId')->name('get_state');
Route::post('my-account/getCity', 'AccountController@getCityByStateId');
Route::get('account/activate/{code}', array(
    'as' => 'account.activate',
    'uses' => 'AccountController@getActivate'
));
Route::get('/about-us', 'HomeController@getAboutUs');
Route::get('/shipping', 'HomeController@getShippingPolicy');
Route::get('/return', 'HomeController@getReturnPolicy');
Route::get('/faq', 'HomeController@getFaq');
Route::get('/contact-us', 'HomeController@getContactUs');
Route::post('/contact-us', 'HomeController@postContactUs');
Route::get('/{slug}', 'SubCategoryController@getListByCategorySlug');
Route::get('/{category}/{vehicle}', 'SubCategoryController@getListByCategoryVehicleSlug');
Route::get('/{vehicle}/{model}/{category}', 'SubCategoryController@getProductByCategoryVehicleModelSlug');
Route::get('/{year}/{vehicle}/{model}/{category}', 'SubCategoryController@getProductByYearCategoryVehicleModelSlug');
Route::get('cart/addresses', 'ProductController@getAddresses')->name('cart.addresses');
Route::post('cart/addresses', 'ProductController@postCartAddresses')->name('cart.addresses');

//Route::get('/{company}/{slug}', 'SubSubCategoryController@getSubSubSubcategory');

// Auth::routes();
 
 
//Route::group(['prefix' => 'api'], function () {
   

   
//});
