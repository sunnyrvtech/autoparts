@extends('layouts.app')
@section('content')
<style>
.main.checkout-onepage-success {
  padding: 70px;
}
.checkout-onepage-success .col-main {
  padding: 0;
  text-align: center;
}
.checkout-onepage-success .col-main {
  float: none;
  padding: 0;
  width: auto;
}

.checkout-onepage-success .page-title h1, .checkout-onepage-success .page-title h2, .checkout-onepage-success .product-name h1, .checkout-onepage-success .product-name .h1 {
  border-bottom: 1px solid #ededed;
  color: #636363;
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 15px;
  padding-bottom: 3px;
  text-transform: uppercase;
}

.checkout-onepage-success .buttons-set {
  margin: 10px 0;
  text-align: center;
    border-top: 1px solid #ededed;
  clear: both;
  padding-top: 10px;
}

    
</style>
<div class="container">
    <div class="main checkout-onepage-success">
        <div class="col-main">
            <div class="page-title">
                <h1>Your order has been received.</h1>
            </div>
            <h2 class="sub-title">Thank you for your purchase!</h2>

            <p>Your order # is: <a href="#">{{ $transaction_id }}</a>.</p>
            <p>You will receive an order confirmation email with details of your order.</p>
            <div class="buttons-set">
                <button type="button" class="btn btn-success" title="Continue Shopping" onclick="window.location = '{{ url('/') }}'"><span><span>Continue Shopping</span></span></button>
            </div>
        </div>
    </div>
</div>
@endsection
