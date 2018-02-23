@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <h3>Order Details :-</h3>
        </div>
    </div>
    <style>
        .height {
            min-height: 160px;
        }
        .table > tbody > tr > .highrow {
            border-top: 3px solid #ddd;
        }
        .table > tbody > tr > td {
            border-top: 1px solid #ddd;
        }
    </style>
    <div class="row">
        <div class="col-xs-12">
            <div class="text-center">
                <h2>Invoice order id #{{ $orders->id }}</h2>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="panel panel-default height">
                        <div class="panel-heading">Billing Details</div>
                        <?php
                        $billing_address = $orders->getCustomer->getBillingDetails;
                        ?>
                        <div class="panel-body">
                            <strong>{{ $orders->getCustomer->first_name.' '.$orders->getCustomer->last_name }}:</strong><br>
                            {{ $billing_address->address1.' '.$billing_address->address2 }}<br>
                            {{ $billing_address->city }},{{ $billing_address->get_state->name }}<br>
                            {{ $billing_address->get_country->name }},<strong>{{ $billing_address->zip }}</strong><br>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="panel panel-default height">
                        <div class="panel-heading">Payment Method</div>
                        <div class="panel-body text-center">
                            <strong>{{ $orders->payment_method }}</strong>
                        </div>
                        <div class="panel-heading">Shipping Method</div>
                        <div class="panel-body text-center">
                            <strong>{{ $orders->shipping_method }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="panel panel-default height">
                        <div class="panel-heading">Order Status <strong>{{ $orders->order_status }}</strong></div>
                        <div class="panel-body text-center">
                            <div class="form-group">
                                <?php
                                $status_array = array('processing', 'shipped', 'completed', 'failed');
                                ?>
                                <select class="form-control" name="order_status" data-id="{{ $orders->id }}" id="order_status">
                                    @foreach ($status_array as $val)
                                    <option @if($orders->order_status == $val) selected @endif>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($orders->order_status == 'completed')
                            <span><strong>Order is completed on {{ date('m-d-Y H:i A',strtotime($orders->updated_at)) }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="panel panel-default height">
                        <div class="panel-heading">Shipping Address</div>
                        <?php
                        $shipping_address = $orders->getCustomer->getShippingDetails;
                        ?>
                        <div class="panel-body">
                            <strong>{{ $orders->getCustomer->first_name.' '.$orders->getCustomer->last_name }}:</strong><br>
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
                                    <td class="text-center"><strong>Ship Carrier</strong></td>
                                    <td class="text-center"><strong>Ship Date</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders->getOrderDetailById as $value)
                                <tr>
                                    <td>{{ $value->product_name }}</td>
                                    <td class="text-center">{{ $value->sku_number }}</td>
                                    <td class="text-center">{{ $value->track_number }}</td>
                                    <td class="text-center">{{ $value->ship_carrier }}</td>
                                    <td class="text-center">@if($value->ship_date !=null){{ date('m-d-Y H:i A',strtotime($value->ship_date)) }}@endif</td>
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
            <div class="panel panel-default height">
                <div class="panel-heading"><h3 class="text-center"><strong>Notes</strong></h3></div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td><strong>Item Name</strong></td>
                                    <td class="text-center"><strong>Sku</strong></td>
                                    <td class="text-center"><strong>Notes</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders->getOrderDetailById as $value)
                                <tr>
                                    <td>{{ $value->product_name }}</td>
                                    <td class="text-center">{{ $value->sku_number }}</td>
                                    <td class="text-center">{{ $value->notes }}</td>
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
                <div class="panel-heading">
                    <h3 class="text-center"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td><strong>Item Name</strong></td>
                                    <td class="text-center"><strong>Sku</strong></td>
                                    <td class="text-center"><strong>Item Price</strong></td>
                                    <td class="text-center"><strong>Quantity</strong></td>
                                    <td class="text-center"><strong>Discount</strong></td>
                                    <td class="text-right"><strong>Total</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sub_total = 0.00; ?>
                                @foreach($orders->getOrderDetailById as $value)
                                <?php
                                $total_price = $value->total_price - ($value->total_price * $value->discount / 100);
                                $sub_total += $total_price;
                                ?>
                                <tr>
                                    <td>{{ $value->product_name }}</td>
                                    <td class="text-center">{{ $value->sku_number }}</td>
                                    <td class="text-center">${{ $value->price }}</td>
                                    <td class="text-center">{{ $value->quantity }}</td>
                                    <td class="text-center">
                                        @if($value->discount != null)
                                        {{ $value->discount.'%' }}
                                        @else
                                        {{"........"}}
                                        @endif
                                    </td>
                                    <td class="text-right">${{ number_format($value->total_price/$value->quantity,2) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow text-center"><strong>Subtotal</strong></td>
                                    <td class="highrow text-right">${{ number_format($sub_total,2) }}</td>
                                </tr>
                                <tr>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow text-center"><strong>Tax</strong></td>
                                    <td class="highrow text-right">${{ number_format($orders->tax_rate,2) }}</td>
                                </tr>
                                <tr>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-center"><strong>Shipping</strong></td>
                                    <td class="emptyrow text-right">${{ $orders->ship_price  or '0.00' }}</td>
                                </tr>
                                <tr>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-center"><strong>Total</strong></td>
                                    <td class="emptyrow text-right">${{ $orders->total_price }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(document).on('change', '#order_status', function (e) {
        e.preventDefault(); // does not go through with the link.
        var $this = $(this);
        $.post({
            data: {'id': $this.data('id'), 'status': $this.val()},
            url: "{{ route('orders-status') }}"
        }).done(function (data) {
            window.location.reload();
        }).fail(function (data) {
            window.location.reload();
        });
    });
</script>
@endpush
@endsection
