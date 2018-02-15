<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Paypalpayment;
use App\Cart;
use App\ShippingAddress;
use App\BillingAddress;
use App\Order;
use App\OrderDetail;
use App\ShippingRate;
use App\Product;
use App\CoupanCode;
use App\CoupanUsage;
use App\TaxRate;
use Auth;
use App\WarehouseStore;
use Mail;
use Redirect;
use View;
use Carbon\Carbon;

class PaymentController extends Controller {

    /**
     * object to authenticate the call.
     * @param object $_apiContext
     */
    private $_apiContext;

    /*
     *   These construct set the SDK configuration dynamiclly, 
     *   If you want to pick your configuration from the sdk_config.ini file
     *   make sure to update you configuration there then grape the credentials using this code :
     *   $this->_cred= Paypalpayment::OAuthTokenCredential();
     */

    public function __construct() {

        // ### Api Context
        // Pass in a `ApiContext` object to authenticate 
        // the call. You can also send a unique request id 
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly. 

        $this->_apiContext = Paypalpayment::ApiContext(config('paypal_payment.Account.ClientId'), config('paypal_payment.Account.ClientSecret'));
    }

    public function index() {
        return redirect()->to('/cart');
    }

    /*
     * Process payment using credit card
     */

    public function store(Request $request) {

        $data = $request->all();
        $shipping_method = $data['shipping_method'];
        $shipping_price = $data['shipping_price'];
        $offer_code = $request->get('discount_code');

        $shipping_address = ShippingAddress::where('user_id', Auth::id())->first();

        if (!ShippingRate::where('country_id', $shipping_address->country_id)->first()) {
            return Redirect::back()
                            ->with('error-message', "No shipping available in your country !");
        }




        $cart_ids = $data['cart_id'];
        $carts = Cart::find($cart_ids);

        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $addr = Paypalpayment::address();
        $addr->setLine1($shipping_address->address1);
        $addr->setLine2($shipping_address->address2);
        $addr->setCity($shipping_address->city);
        $addr->setState($shipping_address->get_state->name);
        $addr->setPostalCode($shipping_address->zip);
        $addr->setCountryCode($shipping_address->get_country->sortname);
        // $addr->setPhone("716-298-1822");
        // ### CreditCard
        $card = Paypalpayment::creditCard();
        $card->setType("visa")
                ->setNumber($data['cardNumber'])
                ->setExpireMonth($data['expiry_month'])
                ->setExpireYear($data['expiry_year'])
                ->setCvv2($data['cardCvv'])
                ->setFirstName(Auth::user()->first_name)
                ->setLastName(Auth::user()->last_name);

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = Paypalpayment::fundingInstrument();
        $fi->setCreditCard($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("credit_card")
                ->setFundingInstruments(array($fi));


        $discount_status = false;
        $check_usage = false;
        // this code is used to verify coupan code and allow discount 
        if ($offer_code != null) {
            $current_date = Carbon::now();
            $coupan_codes = CoupanCode::Where(['code' => $offer_code, 'status' => 1], ['expiration_date', '>', $current_date])->first();
            if ($coupan_codes) {
                $check_usage = CoupanUsage::Where([['coupan_id', '=', $coupan_codes->id], ['user_id', '=', Auth::id()], ['usage', '<', $coupan_codes->usage]])->first();
                if ($check_usage) {
                    $discount_status = true;
                }
            }
        }

        $item = array();
        $item_price = 0;
        $sub_total = 0;
        foreach ($carts as $key => $value) {
            //calulate total price after coupan match and discount
            if ($discount_status && $value->get_products->discount != null) {
                $item_price = $value->total_price - ($value->total_price * $value->get_products->discount / 100);
                $sub_total += number_format($item_price, 2);
            } else {
                $item_price = $value->total_price;
                $sub_total += number_format($item_price, 2);
            }

            $item[$key] = Paypalpayment::item();
            $item[$key]->setName($value->get_products->product_name)
                    ->setDescription($value->get_products->product_long_description)
                    ->setCurrency('USD')
                    ->setQuantity($value->quantity)
                    // ->setTax(0.3)
                    ->setPrice($item_price / $value->quantity);
        }

        $regrex = '"([^"]*)' . $shipping_address->state_id . '([^"]*)"';
        $tax_price = TaxRate::Where('country_id', $shipping_address->country_id)->whereRaw("state_id REGEXP '" . $regrex . "'")->first(array('price'));
        if ($tax_price) {
            // calculate tax price 
            $tax_price = ($sub_total + ($sub_total * $tax_price->price / 100)) - $sub_total;
        } else {
            $tax_price = 0.00;
        }

        $total_cart_price = $sub_total + $shipping_price + $tax_price;

        $itemList = Paypalpayment::itemList();
        $itemList->setItems($item);

        $details = Paypalpayment::details();
        $details->setShipping($shipping_price)
                ->setTax($tax_price)
                //total of items prices
                ->setSubtotal($sub_total);

        //Payment Amount
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
                // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
                ->setTotal($total_cart_price)
                ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription("Payment description")
                ->setInvoiceNumber(uniqid());

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'

        $payment = Paypalpayment::payment();

        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setTransactions(array($transaction));

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create($this->_apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // echo $ex->getCode(); 
            if ($ex->getCode() != 503) {
                $error = json_decode($ex->getData());
                return Redirect::back()
                                ->with('error-message', $error->details[0]->issue);
            }
            return Redirect::back()
                            ->with('error-message', "Something went wrong,Please try again later !");
        }

        if ($transaction_id = $this->savePaymentDetails($payment, $carts, $shipping_address, $discount_status, $offer_code, $check_usage, $shipping_method)) {
            Cart::destroy($cart_ids); ///  empty cart table after payment successfull
            return View::make('carts.success', compact('transaction_id'));
        }
    }

    public function savePaymentDetails($payment, $carts, $shipping_address, $discount_status, $offer_code, $check_usage, $shipping_method) {
        $order_array = array(
            'user_id' => Auth::id(),
            'transaction_id' => $payment->id,
            'total_price' => $payment->transactions[0]->amount->total,
            'ship_price' => $payment->transactions[0]->amount->details->shipping,
            'tax_rate' => $payment->transactions[0]->amount->details->tax,
            'shipping_method' => $shipping_method,
            'payment_method' => 'Paypal',
            'order_status' => 'processing',
            'created_at' => date('Y-m-d H:i:s', strtotime($payment->create_time))
        );

        if ($discount_status) {
            $coupan_codes = CoupanCode::Where(['code' => $offer_code, 'status' => 1])->first();
            $discount_array = array(
                'user_id' => Auth::id(),
                'coupan_id' => $coupan_codes->id,
                'usage' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            );

            if ($check_usage) {
                CoupanUsage::Where('id', $check_usage->id)->increment('usage');   ///   usage increment
            } else {
                CoupanUsage::create($discount_array);
            }
        }

        $orders = Order::create($order_array);
        $transaction_details = array(
            'discount_status' => $discount_status,
            'transaction_id' => $orders->id,
            'shipping_method' => $shipping_method,
            'payment_method' => 'Paypal',
            'shipping_price' => $payment->transactions[0]->amount->details->shipping,
            'tax_rate' => $payment->transactions[0]->amount->details->tax,
            'order_time' => date('M d,Y H:i:s A', strtotime($payment->create_time))
        );
        if ($orders) {
            foreach ($carts as $value) {
                if ($discount_status) {
                    $discount = $value->get_products->discount;
                } else {
                    $discount = null;
                }
                $detail_array = array(
                    'order_id' => $orders->id,
                    'product_id' => $value->product_id,
                    'product_name' => $value->get_products->product_name,
                    'sku_number' => $value->get_products->sku,
                    'quantity' => $value->quantity,
                    'total_price' => $value->total_price,
                    'discount' => $discount
                );
                OrderDetail::create($detail_array);
                Product::Where('id', $value->product_id)->decrement('quantity', $value->quantity);   ///   quantity decrement after successfull purchase
            }

            if ($this->sendInvoice($transaction_details, $carts, $shipping_address)) {
                return $transaction_details['transaction_id'];
            }
        }
        return true;
    }

    public function sendInvoice($transaction_details, $carts, $shipping_address) {
        $billing_address = BillingAddress::where('user_id', Auth::id())->first();

//        $all_store = WarehouseStore::get();
//        $distance_array = array();
//        $store_email = '';

        // this is used to get the nearest store
//        foreach ($all_store as $key => $value) {
//            $distance = $this->getDistanceBetweenPointsNew($shipping_address->latitude, $shipping_address->longitude, $value->latitude, $value->longitude);
//            $distance_array[] = $distance;
//            if (min($distance_array) >= $distance) {
//                $store_email = $value->email;
//            }
//        }

        $data = array(
            'transaction_id' => $transaction_details['transaction_id']
//            'email' => $store_email
        );

//        if (!empty($store_email)) {
//            $transaction_details['store_email'] = true;
//            Mail::send('auth.emails.order_invoice', array('transaction_details' => $transaction_details, 'carts' => $carts, 'shipping_address' => $shipping_address, 'billing_address' => $billing_address), function($message) use ($data) {
//                $message->from('jerhica.pe@gmail.com', " Welcome To Autolighthouse");
//                $message->to($data['email'])->subject('Autolighthouse Store:New Order #' . $data['transaction_id']);
//            });
//        }

        $data['email'] = Auth::user()->email;
        $transaction_details['store_email'] = false;
        Mail::send('auth.emails.order_invoice', array('transaction_details' => $transaction_details, 'carts' => $carts, 'shipping_address' => $shipping_address, 'billing_address' => $billing_address), function($message) use ($data) {
            $message->from('jerhica.pe@gmail.com', " Welcome To Autolighthouse");
            $message->to($data['email'])->subject('Autolighthouse Store:New Order #' . $data['transaction_id']);
        });

        return true;
    }

    function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Mi') {
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;

        switch ($unit) {
            case 'Mi': break;
            case 'Km' : $distance = $distance * 1.609344;
        }
        return (round($distance, 2));
    }

    public function paymentSuccess() {
        return View::make('carts.success');
    }

}
