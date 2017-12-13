<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * this function is used to track order details
     *
     * @return Response
     */
    
    public function index(Request $request){
        return View::make('orders.index');
    }
}
