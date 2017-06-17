<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Paypalpayment;
use App\Cart;
use App\ShippingAddress;
use App\BillingAddress;
use App\Order;
use App\OrderDetail;
use Auth;
use App\WarehouseStore;
use Mail;
use Redirect;
use View;

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

        $shipping_address = ShippingAddress::where('user_id', Auth::id())->first();
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
        $addr->setCountryCode($shipping_address->get_country->name);
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


        $item = array();
        $total_price = 0;
        foreach ($carts as $key => $value) {
            $total_price += $value->total_price;
            $item[$key] = Paypalpayment::item();
            $item[$key]->setName($value->get_products->product_name)
                    ->setDescription($value->get_products->product_long_description)
                    ->setCurrency('USD')
                    ->setQuantity($value->quantity)
                    // ->setTax(0.3)
                    ->setPrice($value->get_products->price);
        }

        $itemList = Paypalpayment::itemList();
        $itemList->setItems($item);


        $details = Paypalpayment::details();
        // $details->setShipping("1.2")
        //->setTax("1.3")
        //total of items prices
        $details->setSubtotal($total_price);

        //Payment Amount
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
                // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
                ->setTotal($total_price)
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
            $error = json_decode($ex->getData());
            return Redirect::back()
                        ->with('error-message',$error->details[0]->issue);
        }
        if ($transaction_id = $this->savePaymentDetails($payment, $carts,$shipping_address)) {
            Cart::destroy($cart_ids); ///  empty cart table after payment successfull
            return View::make('carts.success', compact('transaction_id'));
        }
    }

    public function savePaymentDetails($payment, $carts,$shipping_address) {

        $order_array = array(
            'user_id' => Auth::id(),
            'transaction_id' => $payment->id,
            'order_status' => 'processing'
        );
        $orders = Order::create($order_array);
        $transaction_details = array(
            'transaction_id'=>$orders->id,
            'order_time'=>  date('M d,Y H:i:s A',strtotime($payment->create_time))
        );
        if ($orders) {
            foreach ($carts as $value) {
                $detail_array = array(
                    'order_id' => $orders->id,
                    'product_id' => $value->product_id,
                    'quantity' => $value->quantity,
                    'total_price' => $value->total_price
                );
                OrderDetail::create($detail_array);
            }
            
             if ($this->sendInvoice($transaction_details,$carts, $shipping_address)){
                 return $transaction_details['transaction_id'];
             }
        }
        return true;
    }

    public function sendInvoice($transaction_details,$carts, $shipping_address) {
        $billing_address = BillingAddress::where('user_id', Auth::id())->first();
        
        $all_store = WarehouseStore::get();
        $distance_array = array();
        $store_email = '';

        // this is used to get the nearest store
        foreach ($all_store as $key => $value) {
            $distance = $this->getDistanceBetweenPointsNew($shipping_address->latitude, $shipping_address->longitude, $value->latitude, $value->longitude);
            $distance_array[] = $distance;
            if (min($distance_array) >= $distance) {
                $store_email = $value->email;
            }
        }

        $data = array(
        'transaction_id' =>$transaction_details['transaction_id'],
        'email' => $store_email
        );
        
       if (!empty($store_email)) {
           $transaction_details['store_email'] = true;
            Mail::send('auth.emails.order_invoice', array('transaction_details'=>$transaction_details,'carts'=>$carts, 'shipping_address'=>$shipping_address,'billing_address'=>$billing_address), function($message) use ($data) {
                $message->from('test4rvtech@gmail.com', " Welcome To Autolighthouse");
                $message->to($data['email'])->subject('Autolighthouse Store:New Order #' . $data['transaction_id']);
            });
        }
        
        $data['email'] = Auth::user()->email;
        $transaction_details['store_email'] = false;
        Mail::send('auth.emails.order_invoice', array('transaction_details'=>$transaction_details,'carts'=>$carts, 'shipping_address'=>$shipping_address,'billing_address'=>$billing_address), function($message) use ($data) {
            $message->from('test4rvtech@gmail.com', " Welcome To Autolighthouse");
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
