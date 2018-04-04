@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container"><!-- /#content.container -->   
    <div class="my-account">
        @include('accounts.sidebar') 

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-panel">
                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 colsm">
                        <div id="order_details">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="text-center">
                                        <h2>Invoice order id # {{ $order_details->id }}</h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-4 col-lg-4">
                                            <div class="panel panel-default height">
                                                <div class="panel-heading">Billing Details</div>
                                                <div class="panel-body">
                                                    <strong>{{ Auth::user()->first_name.' '.Auth::user()->last_name }}:</strong><br>
                                                    {{ $billing_address->address1.' '.$billing_address->address2 }}<br>
                                                    {{ $billing_address->city }},{{ $billing_address->get_state->name }}<br>
                                                    {{ $billing_address->get_country->name }},<strong>{{ $billing_address->zip }}</strong><br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-4 col-lg-4">
                                            <div class="panel panel-default height">
                                                <div class="panel-heading">Payment Method</div>
                                                <div class="panel-body text-center">
                                                    <strong>{{ $order_details->payment_method }}</strong>
                                                </div>
                                                <div class="panel-heading">Shipping Method</div>
                                                <div class="panel-body text-center">
                                                    <strong>{{ $order_details->shipping_method }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-4 col-lg-4">
                                            <div class="panel panel-default height">
                                                <div class="panel-heading">Shipping Address</div>
                                                <div class="panel-body">
                                                    <strong>{{ Auth::user()->first_name.' '.Auth::user()->last_name }}:</strong><br>
                                                    {{ $shipping_address->address1.' '.$shipping_address->address2 }}<br>
                                                    {{ $shipping_address->city }},{{ $shipping_address->get_state->name }}<br>
                                                    {{ $shipping_address->get_country->name }},<strong>{{ $shipping_address->zip }}</strong><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading"><h3 class="text-center"><strong>Tracking Info</strong></h3></div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <td><strong>Item Name</strong></td>
                                                            <td class="text-center"><strong>Sku</strong></td>
                                                            <td class="text-center"><strong>Track Number</strong></td>
                                                            <td class="text-center"><strong>Action</strong></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($order_details->getOrderDetailById as $value)
                                                        <tr>
                                                            <td>{{ $value->product_name }}</td>
                                                            <td class="text-center">{{ $value->sku_number }}</td>
                                                            <td class="text-center">{{ $value->track_id }}</td>
                                                            <td class="text-center">
                                                                @if($value->track_url != null && $value->track_id)
                                                                <a href="{{ $value->track_url }}" target="__blank">Track order</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><h3 class="text-center"><strong>Order Status</strong></h3></div>
                                        <div class="panel-body text-center">
                                            <span>
                                            @if($order_details->order_status == 'completed')
                                             Order is completed on {{ date('m-d-Y H:i A',strtotime($order_details->updated_at)) }}
                                            @endif
                                            @if($order_details->ship_date != null)
                                             Order is shipped on {{ date('m-d-Y H:i A',strtotime($order_details->ship_date)) }}
                                            @endif
                                            @if($order_details->ship_date == null)
                                             Order is processing 
                                            @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><h3 class="text-center"><strong>Order Summary</strong></h3></div>
                                        <div class="panel-body">
                                            <div class="table-wrp">
                                            <table class="table order-detail">
                                                <thead>
                                                    <tr>
                                                        <th><label>Item Details</label></th>
                                                        <th><label>Quantity</label></th>
                                                        <th><label>Price</label></th>
                                                        @if($order_details->coupon_type == 'per_product')
                                                        <th><label>Discount</label></th>
                                                        @endif
                                                        <th><label>Total</label></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $sub_total = 0; ?>
                                                    @foreach($order_details->getOrderDetailById as $val)
                                                    <?php
                                                    if ($order_details->coupon_type == 'per_product' && $val->discount !=null) {
                                                        $total_price = $val->total_price - ($val->total_price * $val->discount / 100);
                                                        $sub_total += $total_price;
                                                    } else {
                                                        $total_price = $val->total_price;
                                                        $sub_total += $total_price;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            @if(isset($val->getProduct->id))
                                                            <a class="ga-product-link" href="{{ URL('products').'/'.$val->getProduct->product_slug }}">{{ $val->product_name }}</a>
                                                            @else
                                                            <a class="ga-product-link" href="{{ URL('products').'/'.$val->product_id }}">{{ $val->product_name }}</a>
                                                            @endif
                                                            <div class="product-sku">Sku: {{ $val->sku_number }}</div>
                                                        </td>
                                                        <td>
                                                            <div>{{ $val->quantity }}</div>
                                                        </td>
                                                        <td>
                                                            <div>${{ number_format($val->total_price/$val->quantity,2) }}</div>
                                                        </td>
                                                        @if($order_details->coupon_type == 'per_product')
                                                         <?php $item_discount = $val->total_price-$total_price; ?>
                                                         <td>
                                                            <div>
                                                                @if($val->discount !=null)
                                                                ${{ number_format($item_discount,2) }}
                                                                @else
                                                                ---
                                                                @endif
                                                            </div>
                                                        </td>
                                                        @endif
                                                        
                                                        <td>
                                                            <div class="">${{ number_format($total_price,2) }}</div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                                            <h4>Order Total:</h4>
                                            <div class="outer-order">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <label>Subtotal:</label>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                                        <span>${{ number_format($sub_total,2) }}</span>
                                                    </div>
                                                </div>
                                                @if($order_details->discount != null && $order_details->coupon_type == 'all_products')
                                                <?php
                                                $sub_discount = $sub_total;
                                                $sub_total = $sub_total-($sub_total*$order_details->discount/100);
                                                $sub_discount = $sub_discount-$sub_total;
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <label>Discount:</label>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                                        <span>${{ number_format($sub_discount,2) }}</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <label>Subtotal after discount:</label>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                                        <span>${{ number_format($sub_total,2) }}</span>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <label>Tax:</label>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                                        <span>${{ $order_details->tax_rate or '0.00' }}</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <label>Shipping & Handling:</label>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                                        <span>${{ $order_details->ship_price or '0.00' }}</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <label>Total:</label>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                                        <span class="price">${{ number_format($sub_total+$order_details->ship_price+$order_details->tax_rate,2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection
