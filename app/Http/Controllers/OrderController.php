<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\OrderDetail;
use App\User;

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

}
