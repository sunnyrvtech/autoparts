<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class ApiController extends Controller {

    /**
     * get order details API.
     *
     * @return Response
     */
    public function getOrderDetails(Request $request) {
        $orders = Order::Where('order_status', '!=', 'failed')->get();

        $order_array = array();
        foreach ($orders as $key => $value) {
            //print_r($value->getOrderDetailById->toArray());
            $order_array[$key]['order_id'] = $value->id;
            $order_array[$key]['track_id'] = $value->track_id != null ? $value->track_id : null;
            $product_array = array();
            $product_name = '';
            $sku_number = '';
            $quantity = '';
            $price = '';
            $discount = '';
            foreach ($value->getOrderDetailById as $k => $val) {
                $product_name .= $val->product_name . '|';
                $sku_number .= $val->sku_number . '|';
                $quantity .= $val->quantity . '|';
                $price .= $val->total_price / $val->quantity . '|';
                $discount .= $val->discount . '|';
            }
            $order_array[$key]['product_name'] = rtrim($product_name, '|');
            $order_array[$key]['sku_number'] = rtrim($sku_number, '|');
            $order_array[$key]['quantity'] = rtrim($quantity, '|');
            $order_array[$key]['price'] = rtrim($price, '|');
            $order_array[$key]['discount'] = rtrim($discount, '|');
            $order_array[$key]['ship_price'] = $value->ship_price;
            $order_array[$key]['tax'] = $value->tax_rate;
            $order_array[$key]['total_price'] = $value->total_price;
            $order_array[$key]['status'] = $value->order_status;
        }
        return $order_array;
    }

    /**
     * post order details API.
     *
     * @return Response
     */
    public function postOrderDetails(Request $request) {
        $orders = $request->all();

        foreach ($orders as $value) {
            $order = Order::find($value['order_id']);
            if ($order) {
                $order->fill(array('track_id' => $value['track_id'], 'order_status' => $value['status']))->save();
            }
        }
        return response()->json(['status' => "success"]);

//             return response()->json(['error' => "Your account is deactivated by admin! Please contact with administrator."], 401);
    }

}
