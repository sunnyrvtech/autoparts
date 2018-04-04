@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container">
    <div class="track-content">
        @if($order_details)
        <div class="row">
            <h3>Order Details:</h3>
            <table class="table order-detail">
                <thead>
                    <tr>
                        <th><label>Item Details</label></th>
                        <th><label>Quantity</label></th>
                        <th><label>Price</label></th>
                        <th><label>Discount</label></th>
                        <th><label>Total</label></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sub_total = 0; ?>
                    <?php
                    $total_price = $order_details->total_price - ($order_details->total_price * $order_details->discount / 100);
                    $sub_total += $total_price;
                    ?>
                    <tr>
                        <td>
                            @if(isset($order_details->getOrder->getProduct->id))
                            <a class="ga-product-link" href="{{ URL('products').'/'.$order_details->getProduct->product_slug }}">{{ $order_details->product_name }}</a>
                            @else
                            <a class="ga-product-link" href="{{ URL('products').'/'.$order_details->product_id }}">{{ $order_details->product_name }}</a>
                            @endif
                            <div class="product-sku">Sku: {{ $order_details->sku_number }}</div>
                        </td>
                        <td>
                            <div>{{ $order_details->quantity }}</div>
                        </td>
                        <td>
                            <div>${{ number_format($order_details->total_price/$order_details->quantity,2) }}</div>
                        </td>
                        <td>
                            <div>
                                @if($order_details->discount != null)
                                {{ $order_details->discount.'%' }}
                                @else
                                {{"........"}}
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="">${{ $total_price }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="order_progress">
                <div class="circle_tyo_order order_done" data-title="Order Placed" data-note="Your order accepted on" data-date="{{ $order_details->created_at }}">
                    <span class="label">✓</span>
                    <span class="title">Placed</span>
                </div>
                <span class="bar_tyo_order order_done"></span>
                <div class="circle_tyo_order active_tyo_order" data-title="Order Processed" data-note="Your order processed on" data-date="{{ $order_details->created_at }}">
                    <span class="label"></span>
                    <span class="title">Processed</span>
                </div>
                <span class="bar_tyo_order"></span>
                <div class="circle_tyo_order" data-title="Order Shipped" data-note="Your order shipped on" data-date="{{ $order_details->created_at }}">
                    <span class="label"></span>
                    <span class="title">Shipped</span>
                </div>
                <span class="bar_tyo_order"></span>
                <div class="circle_tyo_order" data-title="Order Completed" data-note="Your order completed on" data-date="{{ $order_details->created_at }}">
                    <span class="label"></span>
                    <span class="title">Completed</span>
                </div>
                <span class="bar_tyo_order"></span>
                <div class="circle_tyo_order" data-title="Order Cancelled" data-note="Your order cancelled on" data-date="{{ $order_details->created_at }}">
                    <span class="label"></span>
                    <span class="title">Cancelled</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="order_track_info">
                <div class="track_info_child">
                    <h4 class="title">Order Shipped</h4>
                    <p class="note">Your order is shipped on</p>
                    <span class="date">01 December,2017 7:24 am</span>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-sm-12">
                <h2>Order Tracking <small></small></h2>
                <hr class="colorgraph">
            </div>
            <div class="">
                <div class="col-xs-12 col-md-12 col-centered">
                    <div class="divcontainer">
                        <h4>To check your order status, please enter your Email address and tracking id below.</h4>
                        <form role="form" method="POST" action="{{ route('track_order') }}">
                            {{ csrf_field()}}
                            <div class="form-row">
                                <div class="form-group col-md-6{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Email:<span class="required">*</span> </label>
                                    <input type="email" name="email" required="" class="form-control" placeholder="Your Email">
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6{{ $errors->has('track_id') ? ' has-error' : '' }}">
                                    <label for="track_id" class="col-form-label">Tracking Id</label>
                                    <input type="track_id" required="" class="form-control" name="track_id" placeholder="Enter Tracking Id">
                                    @if ($errors->has('track_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('track_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <hr class="colorgraph">
                                <button class="btn btn-lg am-orange hover material" elevation="1" type="submit">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
    });
</script>
@endpush
