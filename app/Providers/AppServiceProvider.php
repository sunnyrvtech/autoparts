<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category;
use App\Cart;
use Session;
use View;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $categories = Category::where('status', 1)->get(array('name', 'id'));
        view()->share('categories', $categories);
        
        View::composer('*', function($view) {  // this is used to share cart item count 
            if (auth()->check()) {
                $cart_count = Cart::where('user_id',auth()->id())->count();
            } else {
                $cart_count = Session::has('cartItem') ? count(Session::get('cartItem')) : '0';  
            }
            $view->with('cart_count', $cart_count);
        });
//
//
//
//
//
//        view()->share('cart_count', $cart_count);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
