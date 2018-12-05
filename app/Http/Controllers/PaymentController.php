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
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Mail;
use Redirect;
use View;
use Session;
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
        $this->_apiContext->setConfig(array(
            'mode' => config('paypal_payment.Service.Mode'),
            'service.EndPoint' => config('paypal_payment.Service.EndPoint'),
            'http.ConnectionTimeOut' => config('paypal_payment.Http.ConnectionTimeOut'),
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__ . '/../PayPal.log',
            'log.LogLevel' => 'FINE'
        ));
    }

    public function index() {
        return redirect()->to('/cart');
    }

    /*
     * Process payment using credit card
     */

    public function oldstore(Request $request) {


        $data = Session::get('cart_data');

        $shipping_method = $data['other_cart_data']['shipping_method'];
        $shipping_price = $data['other_cart_data']['shipping_price'];

        $discount_status = $data['other_cart_data']['discount_status'];


        if (Auth::check()) {
            $shipping_address = ShippingAddress::where('user_id', Auth::id())->first();
            $shipping_address->state_name = $shipping_address->get_state->name;
            $shipping_address->country_code = $shipping_address->get_country->sortname;
        } else {
            $shipping_address = Session::get('shipping_address');
        }

        if (!ShippingRate::where('country_id', $shipping_address->country_id)->first() || $shipping_price == 0) {
            return Redirect::back()
                            ->with('error-message', "No shipping available in your country !");
        }

        $cart_ids = $request->get('cart_id');
        $carts = $data['cart_data'];

        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $addr = Paypalpayment::address();
        $addr->setLine1($shipping_address->address1);
        $addr->setLine2($shipping_address->address2);
        $addr->setCity($shipping_address->city);
        $addr->setState($shipping_address->state_name);
        $addr->setPostalCode($shipping_address->zip);
        $addr->setCountryCode($shipping_address->country_code);
        // $addr->setPhone("716-298-1822");
        // ### CreditCard
        $card = Paypalpayment::creditCard();
        $card->setType("visa")
                ->setNumber($request->get('cardNumber'))
                ->setExpireMonth($request->get('expiry_month'))
                ->setExpireYear($request->get('expiry_year'))
                ->setCvv2($request->get('cardCvv'))
                ->setFirstName($shipping_address->first_name)
                ->setLastName($shipping_address->last_name);

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
        $item_price = 0;
        $sub_total = 0;
        $i = 0;
        foreach ($carts as $key => $value) {

            $item[$i] = Paypalpayment::item();
            $item[$i]->setName($value['product_name'])
                    ->setDescription($value['product_long_description'])
                    ->setCurrency('USD')
                    ->setQuantity($value['quantity'])
                    // ->setTax(0.3)
                    ->setPrice($value['price']);

            $item_price = $value['price'] * $value['quantity'];
            if (isset($value['coupon_discount']) && $discount_status && $data['other_cart_data']['coupon_type'] == 'per_product') {
                $total_price = $item_price - ($item_price * $value['coupon_discount'] / 100);
                $sub_total += $total_price;
                $i++;
                $item[$i] = Paypalpayment::item();
                $item[$i]->setName('Discount')
                        ->setCurrency('USD')
                        ->setQuantity(1)
                        ->setPrice($total_price - $item_price);
            } else {
                $sub_total += $item_price;
            }
            $i++;
        }

        if ($discount_status && $data['other_cart_data']['coupon_type'] == 'all_products') {
            $discount = $sub_total;
            $sub_total = number_format($sub_total - ($sub_total * $data['other_cart_data']['coupon_discount'] / 100), 2);
            $discount_price = $sub_total - $discount;
            $item[count($carts)] = Paypalpayment::item();
            $item[count($carts)]->setName('Discount')
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice($discount_price);
        } else {
            $sub_total = number_format($sub_total, 2);
        }

        $tax_price = ($sub_total + ($sub_total * $data['other_cart_data']['tax_price'] / 100)) - $sub_total;

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
                if (isset($error->message))
                    return Redirect::back()
                                    ->with('error-message', $error->message);
            }
            return Redirect::back()
                            ->with('error-message', "Something went wrong,Please try again later !");
        }

        if ($transaction_id = $this->savePaymentDetails($payment, $data)) {
            Cart::destroy($cart_ids); ///  empty cart table after payment successfull
            return View::make('carts.success', compact('transaction_id'));
        }
    }

    public function store(Request $request) {

        $data = Session::get('cart_data');

        $shipping_method = $data['other_cart_data']['shipping_method'];
        $shipping_price = $data['other_cart_data']['shipping_price'];

        $discount_status = $data['other_cart_data']['discount_status'];


        if (Auth::check()) {
            $shipping_address = ShippingAddress::where('user_id', Auth::id())->first();
            $shipping_address->state_code = $shipping_address->get_state->postal_code;
            $shipping_address->country_code = $shipping_address->get_country->sortname;
        } else {
            $shipping_address = Session::get('shipping_address');
        }

        if (!ShippingRate::where('country_id', $shipping_address->country_id)->first() || $shipping_price == 0) {
            return Redirect::back()
                            ->with('error-message', "No shipping available in your country !");
        }

        $cart_ids = $request->get('cart_id');
        $carts = $data['cart_data'];

        $item = array();
        $item_price = 0;
        $sub_total = 0;
        $i = 0;
        foreach ($carts as $key => $value) {
            $item_price = $value['price'] * $value['quantity'];
            if (isset($value['coupon_discount']) && $discount_status && $data['other_cart_data']['coupon_type'] == 'per_product') {
                $total_price = $item_price - ($item_price * $value['coupon_discount'] / 100);
                $sub_total += $total_price;
                $i++;
            } else {
                $sub_total += $item_price;
            }
            $i++;
        }

        if ($discount_status && $data['other_cart_data']['coupon_type'] == 'all_products') {
            $discount = $sub_total;
            $sub_total = number_format($sub_total - ($sub_total * $data['other_cart_data']['coupon_discount'] / 100), 2);
            $discount_price = $sub_total - $discount;
        } else {
            $sub_total = number_format($sub_total, 2);
        }

        $tax_price = ($sub_total + ($sub_total * $data['other_cart_data']['tax_price'] / 100)) - $sub_total;

        $total_cart_price = $sub_total + $shipping_price + $tax_price;
        
        $data['other_cart_data']['tax_rate'] = $tax_price;
        $data['other_cart_data']['total_cart_price'] = $total_cart_price;
        
        // Common setup for API credentials
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('services.authorize.login'));
        $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
        $refId = 'ref' . time();

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();

        $creditCard->setCardNumber($request->get('cardNumber'));
        // $creditCard->setExpirationDate( "2038-12");
        $expiry = $request->get('expiry_year') . '-' . $request->get('expiry_month');
        $creditCard->setExpirationDate($expiry);
        $creditCard->setCardCode($request->get('cardCvv'));

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);


        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($shipping_address->first_name);
        $customerAddress->setLastName($shipping_address->last_name);
        $customerAddress->setAddress($shipping_address->address1);
        $customerAddress->setCity($shipping_address->city);
        $customerAddress->setState($shipping_address->state_name);
        $customerAddress->setZip($shipping_address->zip);
        $customerAddress->setCountry($shipping_address->country_code);

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($total_cart_price);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);


        // Assemble the complete transaction request
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);


        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
//                    echo " Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n";
//                    echo " Transaction Response Code: " . $tresponse->getResponseCode() . "\n";
//                    echo " Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n";
//                    echo " Auth Code: " . $tresponse->getAuthCode() . "\n";
//                    echo " Description: " . $tresponse->getMessages()[0]->getDescription() . "\n";

                    if ($transaction_id = $this->savePaymentDetails($tresponse, $data)) {
                        Cart::destroy($cart_ids); ///  empty cart table after payment successfull
                        return View::make('carts.success', compact('transaction_id'));
                    }
                } else {
                    //echo "Transaction Failed \n";
                    if ($tresponse->getErrors() != null) {
                        //echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
                        //echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
                        return Redirect::back()
                                        ->with('error-message', $tresponse->getErrors()[0]->getErrorText());
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    //echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
                    //echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
                    return Redirect::back()
                                    ->with('error-message', $tresponse->getErrors()[0]->getErrorText());
                } else {
                    //echo " Error Code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
                    //echo " Error Message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
                    return Redirect::back()
                                    ->with('error-message', $response->getMessages()->getMessage()[0]->getText());
                }
            }
        } else {
            return Redirect::back()
                            ->with('error-message', 'No response returned !');
        }
    }

    public function savePaymentDetails($payment, $carts) {
        Session::forget('cartItem');
        Session::forget('cart_data');
        $order_array = array(
            'user_id' => Auth::check() ? Auth::id() : null,
            'transaction_id' =>  $payment->getTransId(),
            'total_price' =>  $carts['other_cart_data']['total_cart_price'],
            'ship_price' =>  $carts['other_cart_data']['shipping_price'],
            'tax_rate' =>  $carts['other_cart_data']['tax_rate'],
            'shipping_method' => $carts['other_cart_data']['shipping_method'],
            'payment_method' => 'Authorize Net',
            'order_status' => 'processing',
            'created_at' => Carbon::now()
        );

        if (Auth::check()) {
            $address_field_array = array('first_name', 'last_name', 'address1', 'address2', 'country_id', 'state_id', 'city', 'zip');
            $shipping_address = ShippingAddress::where('user_id', Auth::id())->first($address_field_array);
            $shipping_address->state_name = $shipping_address->get_state->name;
            $shipping_address->country_name = $shipping_address->get_country->name;
            $shipping_address->country_code = $shipping_address->get_country->sortname;
            $shipping_address = (object) $shipping_address->toArray();
            unset($shipping_address->get_state);
            unset($shipping_address->get_country);
            $billing_address = BillingAddress::where('user_id', Auth::id())->first($address_field_array);
            $billing_address->state_name = $billing_address->get_state->name;
            $billing_address->country_name = $billing_address->get_country->name;
            $billing_address->country_code = $billing_address->get_country->sortname;
            $billing_address = (object) $billing_address->toArray();
            unset($billing_address->get_state);
            unset($billing_address->get_country);
            $order_array['email'] = Auth::user()->email;
        } else {
            $shipping_address = Session::get('shipping_address');
            $billing_address = Session::get('billing_address');
            $order_array['email'] = Session::get('customer_email');
            Session::forget('shipping_address');
            Session::forget('billing_address');
        }
        $order_array['shipping_address'] = json_encode($shipping_address);
        $order_array['billing_address'] = json_encode($billing_address);

        if ($carts['other_cart_data']['discount_status']) {
            $coupan_codes = CoupanCode::Where(['code' => $carts['other_cart_data']['discount_code']])->first();
            if ($carts['other_cart_data']['coupon_type'] == 'all_products') {
                $order_array['discount'] = $carts['other_cart_data']['coupon_discount'];
            }
            $order_array['coupon_type'] = $carts['other_cart_data']['coupon_type'];
            $check_usage = CoupanUsage::Where([['coupan_id', '=', $coupan_codes->id], ['email', '=', $order_array['email']]])->first();
            if ($check_usage) {
                CoupanUsage::Where('id', $check_usage->id)->increment('usage');   ///   usage increment
            } else {
                $discount_array = array(
                    'email' => $order_array['email'],
                    'coupan_id' => $coupan_codes->id,
                    'usage' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                );
                CoupanUsage::create($discount_array);
            }
        }

        $orders = Order::create($order_array);

        if ($orders) {

            $carts['other_cart_data']['transaction_id'] = $orders->id;
            $carts['other_cart_data']['payment_method'] = 'Paypal';
            $carts['other_cart_data']['tax_rate'] = $carts['other_cart_data']['tax_rate'];
            $carts['other_cart_data']['order_time'] = $order_array['created_at'];

            foreach ($carts['cart_data'] as $value) {

                $detail_array = array(
                    'order_id' => $orders->id,
                    'product_id' => $value['product_id'],
                    'product_name' => $value['product_name'],
                    'sku_number' => $value['sku'],
                    'quantity' => $value['quantity'],
                    'total_price' => $value['price'] * $value['quantity']
                );
                if (isset($value['coupon_discount']) && $carts['other_cart_data']['discount_status'] && $carts['other_cart_data']['coupon_type'] == 'per_product') {
                    $detail_array['discount'] = $carts['other_cart_data']['coupon_discount'];
                }

                OrderDetail::create($detail_array);
                Product::Where('id', $value['product_id'])->decrement('quantity', $value['quantity']);   ///   quantity decrement after successfull purchase
            }

            if ($this->sendInvoice($carts, $shipping_address, $billing_address)) {
                return $orders->id;
            }
        }
        return true;
    }

    public function sendInvoice($carts, $shipping_address, $billing_address) {

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
            'transaction_id' => $carts['other_cart_data']['transaction_id']
        );

        if (Auth::check()) {
            $data['email'] = Auth::user()->email;
        } else {
            $data['email'] = Session::get('customer_email');
        }

//        if (!empty($store_email)) {
//            $transaction_details['store_email'] = true;
//            Mail::send('auth.emails.order_invoice', array('transaction_details' => $transaction_details, 'carts' => $carts, 'shipping_address' => $shipping_address, 'billing_address' => $billing_address), function($message) use ($data) {
//                $message->from('jerhica.pe@gmail.com', " Welcome To Autolighthouse");
//                $message->to($data['email'])->subject('Autolighthouse Store:New Order #' . $data['transaction_id']);
//            });
//        }

        $transaction_details['store_email'] = false;
        Mail::send('auth.emails.order_invoice', array('transaction_details' => $transaction_details, 'carts' => $carts, 'shipping_address' => $shipping_address, 'billing_address' => $billing_address), function($message) use ($data) {
            $message->from('autolighthouseplus@gmail.com', " Welcome To Autolighthouse");
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
