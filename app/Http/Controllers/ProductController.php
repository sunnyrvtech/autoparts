<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        return View::make('products.index');
    }
    
    /**
     * Single product detail function.
     *
     * @return Response
     */
    public function singleProduct(){
        return View::make('products.single');
    }
    
    /**
     * Cart function.
     *
     * @return Response
     */
    public function Cart(){
        return View::make('carts.index');
    }
}
