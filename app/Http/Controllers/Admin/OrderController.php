<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\Order;
use App\OrderDetail;
use App\Product;
use Redirect;
use Session;
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
            $orders = Order::with(['getCustomer'])->get();
            $status_array = array('completed', 'failed', 'processing', 'shipped');
            $check_array = array('completed', 'failed');
            foreach ($orders as $key => $value) {
                if (!in_array($value->order_status, $check_array)) {
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
                } else {
                    $html = $value->order_status;
                }
                $orders[$key]['status'] = $html;
                $orders[$key]['action'] = '<a href="'.route('orders.show', $value->id).'" data-toggle="tooltip" title="View Order Details" class="glyphicon glyphicon-eye-open"></a>';
           
            }
            return Datatables::of($orders)->make(true);
        }
        return View::make('admin.orders.index', compact('title'));
    }
    
    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $orderId) {
        $title = 'Orders | details';
    
        if ($request->ajax()) {
            $order_details = OrderDetail::Where('order_id',$orderId)->get();
            
            return Datatables::of($order_details)->make(true);
        }
        $ajaxURL = route('orders.show',$orderId);
        return View::make('admin.orders.order_details', compact('title','ajaxURL'));
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
            Session::flash('error-message', 'Something went wrong.Please try again later!');
//          return response()->json(array('messages' => 'Something went wrong.Please try again later!'), 401);
        } else {
            $orders->fill(array('order_status' => $status))->save();
            if ($status == 'failed') {
                foreach ($orders->getOrderDetailById as $val) {
                    if (isset($val->getProduct->id)) {
                        Product::Where('id',$val->getProduct->id)->increment('quantity', $val->quantity);   ///   quantity increment if order cancelled
                    } else {
                        Session::flash('error-message', 'Product id not found!');
//                        return response()->json(['messages' => "Product id not found!"], 401);
                    }
                }
            }
            Session::flash('success-message', 'Order status updated successfully!');
//            return response()->json(['messages' => "Status updated successfully!"]);
        }
    }

}
