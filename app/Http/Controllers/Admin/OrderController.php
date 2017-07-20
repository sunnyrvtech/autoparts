<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\Order;
use Redirect;
use Yajra\Datatables\Facades\Datatables;

class OrderController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Orders';
        if ($request->ajax()) {
            $orders = Order::with(['getCustomer', 'getOrderDetails', 'getOrderDetails.getProduct'])->get();
            $status_array = array('completed', 'failed', 'processing', 'shipped');
            foreach ($orders as $key => $value) {

                $html = '<select name="order_status" data-id="' . $value->id . '" id="order_status">';
                foreach ($status_array as $val) {
                    if ($value->order_status == $val) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    $html .= '<option ' . $selected . ' value="' . $val . '">' . ucfirst($val) . '</option>';
                }

                $html .= '</select>';
                $orders[$key]['status'] = $html;
            }
            return Datatables::of($orders)->make(true);
        }
        return View::make('admin.orders.index', compact('title'));
    }
    
    /**
     * function to update category status
     *
     * @param  int  $id
     * @return Response
     */
    public function orderStatus(Request $request) {
        $id = $request->get('id');
        $status = $request->get('status');
        $orders = Order::find($id);

        if (!$orders) {
            return response()->json(array('error' => 'Something went wrong.Please try again later!'), 401);
        } else {
            $orders->fill(array('order_status' => $status))->save();
            return response()->json(['success' => true, 'messages' => "Status updated successfully!"]);
        }
    }


}
