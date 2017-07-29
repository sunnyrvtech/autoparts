<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category;
use App\SubCategory;
use App\Cart;
use App\StaticPage;
use Session;
use View;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $categories = Category::where('status', 1)->orderBy('name')->limit(8)->get(array('name', 'id'));
        $featured_category = SubCategory::groupBy('name')->get(array('name', 'id', 'slug'));    
        $header_content = StaticPage::where('slug','header')->first();
        view()->share('categories', $categories);
        view()->share('header_content', $header_content);
        view()->share('featured_category', $featured_category);
        
        View::composer('*', function($view) {  // this is used to share cart item count 
            if (auth()->check()) {
                $cart_count = Cart::where('user_id',auth()->id())->sum('quantity');
            } else {
                // array_sum and array_column function is used to count sum for quantity 
                $cart_count = Session::has('cartItem') ? array_sum(array_column(Session::get('cartItem'),'quantity')) : '0';  
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
