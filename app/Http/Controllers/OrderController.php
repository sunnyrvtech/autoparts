<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\OrderDetail;
use App\User;
use App\Order;
use Mail;
use Session;

class OrderController extends Controller {

    /**
     * Display a listing of the resource.
     * this function is used to track order details
     *
     * @return Response
     */
    public function index(Request $request) {
        $track_id = $request->get('track_id');
        $data['order_details'] = array();
        return View::make('orders.track', $data);
    }

    public function postTrackOrder(Request $request) {
        $this->validate($request, [
            'track_id' => 'required',
            'email' => 'required'
        ]);


        $order_details = OrderDetail::Where('track_id', $request->get('track_id'))->whereNotNull('track_id')->first();

        if ($order_details) {
            if ($order_details->getOrder->getCustomer->email == $request->get('email')) {
                $data['order_details'] = $order_details;
                return View::make('orders.track', $data);
            } else {
                return redirect()->back()
                                ->with('error-message', 'No order found to this email address !');
            }
        }
        return redirect()->back()
                        ->with('error-message', 'No order found !');


//        return redirect()->back()
//                        ->with('error-message', 'No order found to this email address !');
    }

    public function orderCancelled(Request $request) {
        $id = $request->get('id');
        $order = Order::find($id);
        if ($order->order_status == "processing") {

            $data = array(
                'order_id' => $order->id,
                'shipping_address' => json_decode($order->shipping_address),
                'billing_address' => json_decode($order->billing_address)
            );

            if ($order->fill(array("order_status" => "cancelled"))->save()) {
                Session::flash('success-message', 'Order cancelled successfully!');
                Mail::send('auth.emails.order_cancel', $data, function($message) use ($data) {
                    $message->from('autolighthouseplus@gmail.com', " Welcome To Autolighthouse");
                    $message->to('sunny_kumar@rvtechnologies.com')->subject('Order cancelled #' . $data['order_id']);
                });
                return response()->json(array('success' => true));
            }
            return response()->json(array('error' => 'something is wrong,please try again later'), 401);
        }
    }

}
