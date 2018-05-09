@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container">
    <div class="page-header-wrapper cart-header">
        <div class="row">
            <div class="col-md-12 col-sm-8 col-xs-12">
                <h1 class="onea-page-header">View Cart</h1>
            </div>
        </div>
    </div>
    <div id="checkout-final-con" class="order-container">
        @if(!empty($cart_data))
        
        <form id="paymentForm" class="form-horizontal" action="{{ route('checkout.store') }}" method="post">
            {{ csrf_field() }}
            <div class="cart-list material" elevation="1">
                <div class="col-12">
                    <div class="table-responsive order-items">
                        <table class="table order">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><label>Item Details</label></th>
                                    <th><label>Quantity</label></th>
                                    <th><label>Price</label></th>
                                    @if($other_cart_data['discount_status'] && $other_cart_data['coupon_type'] == 'per_product')
                                    <th><label>Discount</label></th>
                                    @endif
                                    <th><label>Total</label></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total_price = '';$sub_total=0;$total_discount = 0; ?>
                                @foreach($cart_data as $value)
                                <?php 
                                    //calulate total price after coupan match and discount
                                    if(isset($value['coupon_discount']) && $other_cart_data['discount_status'] && $other_cart_data['coupon_type'] == 'per_product'){
                                        $item_price = $value['price']*$value['quantity'];
                                        $total_price = $item_price-($item_price*$other_cart_data['coupon_discount']/100);
                                        $sub_total += $total_price; 
                                    }else{
                                        $total_price = $value['price']*$value['quantity'];
                                        $sub_total += $value['price']*$value['quantity'];
                                    }
                                    
                                    // just used to hide discount text field if no discount available 
//                                    $total_discount += $value['discount'];
                                ?>
                                <tr>
                                    <td>
                                        <div class="product-image"><img src="{{ URL::asset('/product_images').'/'.$value['product_image'] }}" alt="{{ $value['product_name']}}" width="120" height="120"></div>
                                    </td>
                                    <td>
                                        <a class="ga-product-link" href="{{ URL('products').'/'.$value['product_slug']}}">{{ $value['product_name']}}</a>
                                        <!--<div class="product-shipping-text">In Stock Ships Within 1 Business Day FREE SHIPPING AND HANDLING!</div>-->
                                        <div class="product-sku">Sku: {{ $value['sku']}}</div>
                                        <div class="product-fit">Make: {{ $value['vehicle_company']}} / Model: {{ $value['vehicle_model']}} / Year: {{ $value['vehicle_year']}}</div>
                                    </td>
                                    <td>
                                        <input class="order-quantity-dropdown form-control" value="{{ $value['quantity']}}" data-product-id="{{ $value['product_id']}}">
                                        <a class="btn btn-default qty_refresh" title="refresh"><i class="glyphicon glyphicon-refresh"></i></a>
                                        <input type="hidden" name="cart_id[]" value="{{ $value['cart_id'] }}">
                                        <input type="hidden" name="shipping_price" value="{{ $other_cart_data['shipping_price'] }}">
                                    </td>
                                    <td>
                                        <div>${{ number_format($value['price'],2) }}</div>
                                    </td>
                                    @if($other_cart_data['discount_status'] && $other_cart_data['coupon_type'] == 'per_product')
                                    <?php $item_discount = $item_price-$total_price; ?>
                                    <td>
                                        @if(isset($value['coupon_discount']))
                                        <div>${{ number_format($item_discount,2) }}</div>
                                        @else
                                        <div>---</div>
                                        @endif
                                    </td>
                                    @endif
                                    <td>
                                        <div class="">${{ number_format($total_price,2) }}</div>
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
                                      <div class="product-sku">Sku: {{ $value['sku']}}</div>
                            <div class="product-fit">Make: {{ $value['vehicle_company']}} / Model: {{ $value['vehicle_model']}} / Year: {{ $value['vehicle_year']}}</div>
                                </div>
                            </div>

<!--                                                    <div class="product-shipping-text">
                                                        In Stock Ships Within 1 Business Day<br>
                                                        FREE SHIPPING AND HANDLING!
                                                    </div>-->
                          

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        @if($other_cart_data['discount_status'] && $other_cart_data['coupon_type'] == 'per_product')
                                          <th>Discount</th>
                                        @endif
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                           <input class="order-quantity-dropdown form-control" value="{{ $value['quantity']}}" data-product-id="{{ $value['product_id']}}">
                                           <a class="btn btn-default" title="refresh"><i class="glyphicon glyphicon-refresh"></i></a>
                                        </td>
                                        <td>
                                            <div>${{ number_format($value['price'],2) }}</div>
                                        </td>
                                        @if($other_cart_data['discount_status'] && $other_cart_data['coupon_type'] == 'per_product')
                                            <td>
                                                @if(isset($value['coupon_discount']))
                                                <div>${{ number_format($item_discount,2) }}</div>
                                                @else
                                                <div>---</div>
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            <div class="">${{ number_format($total_price,2) }}</div>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-sm" ng-click="submitDeleteCart({{ $value['cart_id'] }},{{ $value['quantity'] }})"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>   
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="shipping-section material" elevation="1">
               @if(!empty($shipping_address))
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="discount-text-1">Discount/Gift Certificate</div>
                            <div class="discount-text-2">If you have a discount or gift certificate code, enter it here:</div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <input class="form-control" id="offerCode" @if($other_cart_data['discount_status']) readonly @endif  value="{{ $other_cart_data['discount_code'] }}" name="discount_code" type="text">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            @if($other_cart_data['discount_status'])
                                <span class="btn material glyphicon glyphicon-ok" elevation="1" style="color:green"></span>
                            @else
                                <button class="btn hover material" elevation="1" id="discountCodeSubmit" type="button">Apply Discount</button>
                            @endif
                        </div>
                    </div>
                @endif    
                <div class="row">
                    <div class="col-md-4">
                    @if(!empty($billing_address))
                    <div class="row">
                        
                        <div class="col-md-6">
                        <h4>Billing Address: </h4>
                        <span>{{ ucfirst($billing_address->first_name) }}</span><span> {{ ucfirst($billing_address->last_name) }}</span>,<br>
                            <!--<span>email</span>-->
                            <span>
                                <span>{{ ucfirst($billing_address->address1) }}</span><span> {{ ucfirst($billing_address->address2) }}</span>
                            </span><br>
                            <span>{{ ucfirst($billing_address->city) }}</span>,<span>{{ ucfirst($billing_address->state_name) }}<br>
                            </span><span> {{ ucfirst($billing_address->country_name) }}</span><span> {{ $billing_address->zip }}</span>

                        </div>
                    </div>
                    <div class="btn-wrp">
                    <a href="{{ route('cart.addresses') }}" class="btn btn-success" type="submit">Edit Billing Address</a></div>
                    @endif
                </div>
                    <div class="col-md-4">
                    @if(!empty($shipping_address))
                    <div class="row">
                        
                        <div class="col-md-6">
                        <h4>Shipping To: </h4>
                            <span>{{ ucfirst($shipping_address->first_name) }}</span><span> {{ ucfirst($shipping_address->last_name) }}</span>,<br>
                            <span>
                                <span>{{ ucfirst($shipping_address->address1) }}</span><span> {{ ucfirst($shipping_address->address2) }}</span>
                            </span><br>
                            <span>{{ ucfirst($shipping_address->city) }}</span>,<span>{{ ucfirst($shipping_address->state_name) }}<br>
                            </span><span> {{ ucfirst($shipping_address->country_name) }}</span><span> {{ $shipping_address->zip }}</span>

                        </div>
                    </div>
                    <div class="btn-wrp">
                    <a href="{{ route('cart.addresses') }}" class="btn btn-success" type="submit">Edit Shipping Address</a></div>
                    @endif
                </div>
              
                    <div class="col-md-4 col-xs-12 pull-right">
                    <h4>Order Total: </h4>
                    <div class="delivery-wrp">
                        @if(!empty($shipping_address) && !empty($shipping_methods->toArray()))
                        <select id="changeShippingMethod" name="shipping_method" class="form-control">
                                <option value="">Select Shipping Method</option>
                                @foreach($shipping_methods as $val)
                                <option @if($val->name == $other_cart_data['shipping_method']) selected @endif value="{{ $val->name }}">{{ $val->name }}</option>
                                @endforeach
                        </select>
                        <span id="shipping_method_error" class="help-block" style="display:none;">
                            <strong style="color:#a94442;">Please select shipping method first.</strong>
                        </span> 
                        @else
                        <span id="shipping_method_error" class="help-block" style="display:none;">
                            <strong style="color:#a94442;">Shipping method not activated yet!</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="total-price-section material" elevation="1">
                        <!--<div class="row">
                            <!--                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <label>Tax: </label>
                                                    </div>-->
                            <!--                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <span>$0.00</span>
                                                    </div>
                        </div>-->
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <label>Subtotal:</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span>${{ number_format($sub_total,2) }}</span>
                            </div>
                        </div>
                        @if($other_cart_data['discount_status'] && $other_cart_data['coupon_type'] == 'all_products')
                        <?php
                        $sub_discount = $sub_total;
                        $sub_total = number_format($sub_total-($sub_total*$other_cart_data['coupon_discount']/100),2);
                        $sub_discount = $sub_discount-$sub_total;
                        ?>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <label>Discount:</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span>${{ number_format($sub_discount,2) }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <label>Subtotal after discount:</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span>${{ $sub_total }}</span>
                            </div>
                        </div>
                        @else
                        <?php $sub_total = number_format($sub_total,2); ?>
                        @endif
                        @if($other_cart_data['shipping_price'] > 0)
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <label>Shipping:</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span class="price">${{ number_format($other_cart_data['shipping_price'],2) }}</span>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <label>Tax:</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <?php 
                                    // calculate tax price 
                                    $tax_price = ($sub_total+($sub_total*$other_cart_data['tax_price']/100))-$sub_total; 
                                ?>
                                <span class="price">${{ number_format($tax_price,2) }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <label>Total:</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <?php 
                                $total_cart_price = $sub_total+$other_cart_data['shipping_price']+$tax_price;
                                ?>
                                <span class="price">${{ number_format($total_cart_price,2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="btn-deliver">
                        @if(!empty($shipping_address))
                        <a class="btn btn-success btn-block" id="checkout_btn">Checkout</a>
                        @elseif(!Auth::check())
                        <a class="btn btn-success btn-block" ng-click="login()">Checkout</a>
                        <a class="btn btn-success btn-block" href="{{ route('cart.addresses')}}">Guest Checkout</a>
                        @else
                        <a class="btn btn-success btn-block" href="{{ route('cart.addresses')}}">Checkout</a>
                        @endif
                    </div>
                </div>
                </div>
                <div class="row" id="account_cart_area" style="display:none;">
                     <div class="col-md-6"></div>
                     <div class="col-md-6">
                        <h4>Enter Payment Information:</h4>
                            <div class="form-group form-group-sm">
                                <label class="col-sm-4 control-label" for="cardholderName">Name Of Card Holder: *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="cardholderName" name="cardholderName" required="" value="" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="card-number">Card Number: *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="card-number" maxlength="16" name="cardNumber" required="" type="tel">
                                    <span id="card_error" class="help-block" style="display:none;">
                                        <strong style="color:#a94442;">Invalid card number,Please enter valid card number.</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <label class="col-sm-4 control-label" for="card-number">Expiration Date: *</label>
                                <div class="col-sm-8">
                                   <div class="row expiry-wrp">
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
                            </div>
                            <div class="form-group form-group-sm">
                                <label class="col-sm-4 control-label" for="cardCvv">Card Verification Number:*</label>
                                <div class="col-sm-8">
                                     <input class="form-control" id="cardCvv" name="cardCvv" required="" type="tel">
                                </div>
                            </div>
                            <button class="btn btn-lg am-orange pull-right" id="paymentSubmit" type="submit"> 
                                <!--<i class="glyphicon glyphicon-repeat gly-spin"></i>-->
                                <span class="place-text">Place Order</span>
                                <!--<span class="placing-text">Placing Your Order!</span>-->
                            </button>
                     </div>
                </div>
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
        
         $(document).on("click",".qty_refresh",function(){
            $($(this).closest("tbody").find(".order-quantity-dropdown")).trigger("change");
         });
        
        $(document).on('change', '.order-quantity-dropdown', function (e) {
            e.preventDefault();
            changeQuantity($(this));
        });
        
        function changeQuantity($this){
            var cart_count = 0;
            $this.closest("tbody").find(".order-quantity-dropdown").each(function () {
                if (isNaN(parseInt($this.val()))) {
                    cart_count += 1;
                } else {
                    cart_count += parseInt($this.val());
                }
            });
            var quantity = $this.val();
            var productId = $this.attr('data-product-id');
            angular.element($this).scope().submitUpdateCart(quantity, productId, cart_count);
        }
        
        $(document).on('change', '#changeShippingMethod', function (e) {
              e.preventDefault();
              var ship_method = $(this).val();
              var offer_code = $("#offerCode").val();
              if(ship_method == ''){
                  ship_method = null;
              }
              angular.element(this).scope().changeShippingMethod(ship_method,offer_code);
       });
       
       $(document).on('click', '#discountCodeSubmit', function (e) {
              var offer_code = $("#offerCode").val();
              var ship_method = $("#changeShippingMethod").val();
              if(ship_method == ''){
                  ship_method = null;
              }
              angular.element(this).scope().submitDiscountCode(ship_method,offer_code);
       });
       
       $(document).on('click', '#checkout_btn', function (e) {
              e.preventDefault();
              var ship_method = $("#changeShippingMethod").val();
              angular.element(this).scope().get_payment_form(ship_method);
       });
       
       $(document).on('click', '#paymentSubmit', function (e) {
        var $myForm = $('#paymentForm');
           if($myForm[0].checkValidity()) {
                $("#card_error").hide();
                var luhn_check = valid_credit_card($("#card-number").val());
                if(!luhn_check){
                    $("#card_error").show();
                    return false;
                }
                $(this).prop('disabled', true);
                var scope = angular.element($("#loaderOverlay")).scope();
                scope.loading = true;
                angular.element($("#loaderOverlay")).scope().$apply();
                document.getElementById("paymentForm").submit(); 
            }
       });
       // takes the form field value and returns true on valid number
        function valid_credit_card(value) {
           // accept only digits, dashes or spaces
           if (/[^0-9-\s]+/.test(value)) return false;
           // The Luhn Algorithm. It's so pretty.
           var nCheck = 0, nDigit = 0, bEven = false;
            value = value.replace(/\D/g, "");
           for (var n = value.length - 1; n >= 0; n--) {
                var cDigit = value.charAt(n),
                nDigit = parseInt(cDigit, 10);
                if (bEven) {
                    if ((nDigit *= 2) > 9) nDigit -= 9;
                }
                nCheck += nDigit;
                bEven = !bEven;
            }
            return (nCheck % 10) == 0;
        }
       
    });
</script>
@endpush
