<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\Order;
use Redirect;
use Yajra\Datatables\Facades\Datatables;


class OrderController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Orders';
        if ($request->ajax()) {
            $orders = Order::with(['getCustomer','getOrderDetails','getOrderDetails.getProduct'])->get();
//            foreach ($orders as $key => $value) {
//                $orders[$key]['action'] = '<a href="' . route('products.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('products.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
//            }
            return Datatables::of($orders)->make(true);
        }
        return View::make('admin.orders.index', compact('title'));
    }
}
