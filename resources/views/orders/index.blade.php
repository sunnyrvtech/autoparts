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
                    <div class="row colsm-row" id="order_listing">
                        <h3>Your Orders:</h3>
                        <hr class="colorgraph">
                        <div class="table-wrp">
                            <table class="table">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th><label>No#</label></th>
                                        <th><label>Date</label></th>
                                        <th><label>Ship To</label></th>
                                        <th><label>Order Total</label></th>
                                        <th><label>Order Status</label></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $key=>$value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ date('m-d-Y H:i:s',strtotime($value->created_at)) }}</td>
                                        <td>{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</td>
                                        <td>${{ number_format($value->total_price,2) }}</td>
                                        <td>{{ $value->order_status }}</td>
                                        <td>
                                            <span class="nobr"><a href="{{ URL('/my-account/order/view').'/'.$value->id }}">View Order</a></span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td><p>No Record Found!</p></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
