<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\User;
use App\Product;
use App\Order;
use Yajra\Datatables\Facades\Datatables;

class IndexController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $data['title'] = 'AutoLightHouse | Dashboard';
        $data['users'] = User::whereNull('role_id')->count();
        $data['orders'] = Order::count();
        $data['products'] = Product::count();
        return View::make('admin.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
//    public function store() {
//        
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function update($id) {
//        
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function destroy($id) {
//        
//    }
}
