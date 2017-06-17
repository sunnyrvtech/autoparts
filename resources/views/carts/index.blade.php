@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container">
    <div class="container-fluid page-header-wrapper cart-header">
        <div class="row">
            <div class="col-md-12 col-sm-8 col-xs-12">
                <h1 class="onea-page-header">View Cart</h1>
            </div>
        </div>
    </div>
    <div id="checkout-final-con" class="container-fluid order-container">
        @if(!empty($cart_data))
        
        <form class="form-horizontal" action="{{ route('checkout.store') }}" method="post">
            <div class="row cart-list material" elevation="1">
                <div class="col-md-12">
                    <div class="table-responsive order-items">
                        <table class="table order">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><label>Item Details</label></th>
                                    <th><label>Quantity</label></th>
                                    <th><label>Price</label></th>
                                    <th><label>Total</label></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  $total_price_cart=''; ?>
                                @foreach($cart_data as $value)
                                <?php $total_price_cart += $value['total_price']; ?>
                                <tr>
                                    <td>
                                        <div class="product-image"><img src="{{ URL::asset('/product_images').'/'.$value['product_image'] }}" alt="{{ $value['product_name']}}" width="120" height="120"></div>
                                    </td>
                                    <td>
                                        <a class="ga-product-link" href="{{ URL('products').'/'.$value['product_slug']}}">{{ $value['product_name']}}</a>
                                        <!--<div class="product-shipping-text">In Stock Ships Within 1 Business Day FREE SHIPPING AND HANDLING!</div>-->
                                        <div class="product-sku">Part Number: {{ $value['part_number']}}</div>
                                        <div class="product-fit">Make: {{ $value['vehicle_company']}} / Model: {{ $value['vehicle_model']}} / Year: {{ $value['vehicle_year']}}</div>
                                    </td>
                                    <td>
                                        <input class="order-quantity-dropdown form-control" value="{{ $value['quantity']}}" data-product-id="{{ $value['product_id']}}">
                                        <input type="hidden" name="cart_id[]" value="{{ $value['cart_id'] }}">
                                    </td>
                                    <td>
                                        <div>${{ $value['price']}}</div>
                                    </td>
                                    <td>
                                        <div class="">${{ $value['total_price']}}</div>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger btn-sm" ng-click="submitDeleteCart({{ $value['cart_id'] }},{{ $value['quantity'] }})"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mobile-carts-items">
                        @foreach($cart_data as $value)
                        <div class="row">
                            <div class="image-and-title">
                                <div class="image">
                                    <img src="{{ URL::asset('/product_images').'/'.$value['product_image'] }}" alt="{{ $value['product_name']}}" width="120" height="120">
                                </div>
                                <div class="title">
                                    <a class="ga-product-link" href="{{ URL('products').'/'.$value['product_slug']}}">{{ $value['product_name']}}</a>
                                </div>
                            </div>

                            <!--                        <div class="product-shipping-text">
                                                        In Stock Ships Within 1 Business Day<br>
                                                        FREE SHIPPING AND HANDLING!
                                                    </div>-->
                            <div class="product-sku">Part Number: {{ $value['part_number']}}</div>
                            <div class="product-fit">Make: {{ $value['vehicle_company']}} / Model: {{ $value['vehicle_model']}} / Year: {{ $value['vehicle_year']}}</div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input class="order-quantity-dropdown form-control" value="{{ $value['quantity']}}" data-product-id="{{ $value['product_id']}}">
                                        </td>
                                        <td>
                                            <div>${{ $value['price']}}</div>
                                        </td>
                                        <td>
                                            <div class="">${{ $value['total_price']}}</div>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-sm" ng-click="submitDeleteCart({{ $value['cart_id'] }})"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>   
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row shipping-section material" elevation="1">
                <div class="col-md-6">
                    @if(!empty($shipping_address) && Auth::check())
                    <div class="row">
                        <h4>Shipping To: </h4>
                        <div class="col-md-6">
                            <span>{{ Auth::user()->first_name }}</span><span> {{ Auth::user()->last_name }}</span>,
                            <span>{{ Auth::user()->email }}</span>
                            <span>
                                <span>{{ $shipping_address->address1 }}</span><span> {{ $shipping_address->address2 }}</span>
                            </span><br>
                            <span>{{ $shipping_address->city }}</span>,<span>{{ $shipping_address->get_state->name }}<br>
                            </span><span> {{ $shipping_address->get_country->name }}</span><span> {{ $shipping_address->zip }}</span>

                        </div>
                    </div>
                    <div class="row"><a href="{{ URL('/my-account') }}" class="btn btn-success" type="submit">Edit Shipping Address</a></div>
                    @endif
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <h4>Order Total: </h4>
                    <!--                <div class="row">
                                        <form method="post" action="javascript:void(0);">
                                            <select class="form-control">
                                                <option>Select Shipping Method</option>
                                                <option>Ground</option>
                                                <option>UPS Next Day Air</option>
                                                <option>UPS 2nd Day Air</option>
                                            </select>
                                        </form>
                                    </div>-->
                    <div class="row total-price-section material" elevation="1">
                        <div class="row">
                            <!--                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <label>Tax: </label>
                                                    </div>-->
                            <!--                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <span>$0.00</span>
                                                    </div>-->
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <label>Subtotal:</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span>${{ $total_price_cart }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <label>Total:</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span class="price">${{ $total_price_cart }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if(Auth::check() && !empty($shipping_address))
                        <a class="btn btn-success btn-block" ng-click="account_cart_area=true" ng-show="!account_cart_area">Checkout</a>
                        @elseif(empty($shipping_address))
                        <a class="btn btn-success btn-block" href="{{ URL('/my-account')}}" type="button">Checkout</a>
                        @else
                        <button class="btn btn-success btn-block" ng-click="login()" type="button">Checkout</button>
                        @endif
                    </div>`
                </div>
                @if(Auth::check())
                 <div class="row" ng-show="account_cart_area">
                     <div class="col-md-6"></div>
                     <div class="col-md-6">
                        <h4>Enter Payment Information:</h4>
                            <div class="form-group form-group-sm">
                                <label class="col-sm-4 control-label" for="cardholderName">Name Of Card Holder: *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="cardholderName" name="cardholderName" required="" value="{{ Auth::user()->first_name.' '.Auth::user()->last_name }}" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="card-number">Card Number: *</label>
                                <div class="col-sm-8">
                                     <input class="form-control" id="card-number" maxlength="16" name="cardNumber" required="" type="tel">
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <label class="col-sm-4 control-label" for="card-number">Expiration Date: *</label>
                                <div class="col-sm-8">
                                    <div class="col-sm-6">
                                        <select class="form-control" name="expiry_month" required="">
                                            <option value="">--Select Month--</option>
                                            <?php
                                            $month = 1;
                                            for ($i = 0; $i < 12; $i++) {
                                                $monthtime = mktime(0, 0, 0, $month + $i, 1);
                                                $monthnum = date('m', $monthtime);
                                                echo '<option value="' . $monthnum . '">' . date('F', $monthtime) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control"  name="expiry_year" required="">
                                            <option value="">--Select Year--</option>
                                            <?php
                                            $currentYear = date('Y');
                                            $nextYear = date('Y', strtotime('+10 year'));
                                            // set start and end year range
                                            $yearArray = range($currentYear, $nextYear);
                                            ?>
                                             @foreach($yearArray as $val)
                                               <option value="{{ $val }}">{{ $val }}</option>
                                             @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <label class="col-sm-4 control-label" for="cardCvv">Card Verification Number:*</label>
                                <div class="col-sm-8">
                                     <input class="form-control" id="cardCvv" name="cardCvv" required="" type="tel">
                                </div>
                            </div>
                            <button class="btn btn-lg am-orange pull-right" type="submit"> 
                                <!--<i class="glyphicon glyphicon-repeat gly-spin"></i>-->
                                <span class="place-text">Place Order</span>
                                <!--<span class="placing-text">Placing Your Order!</span>-->
                            </button>
                     </div>
                </div>
                @endif
            </div>
        </form>
        @else
        <span>Your cart is empty</span>
        @endif
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '.order-quantity-dropdown', function (e) {
            e.preventDefault();
            var cart_count = 0;
            $(this).closest("tbody").find(".order-quantity-dropdown").each(function () {
                if (isNaN(parseInt($(this).val()))) {
                    cart_count += 1;
                } else {
                    cart_count += parseInt($(this).val());
                }
            });
            var quantity = $(this).val();
            var productId = $(this).attr('data-product-id');
            angular.element(this).scope().submitUpdateCart(quantity, productId, cart_count);
        });
    });
</script>
@endpush
