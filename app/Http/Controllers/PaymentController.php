<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Paypalpayment;
use App\Cart;
use App\ShippingAddress;
use Auth;

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

        $this->_apiContext = Paypalpayment::apiContext(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'));
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
        $carts = Cart::find($data['cart_id']);

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
            echo $ex->getData();
            die;
        }

        dd($payment);
    }

}
