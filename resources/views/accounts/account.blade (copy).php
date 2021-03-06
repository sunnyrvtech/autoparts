@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container"><!-- /#content.container -->   
    <div class="my-account">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <div class="btn-group btn-group-vertical" @if($order_details == '' && Request::segment(2) != 'order') ng-init="selectedTab = 'shipping-address'" @else ng-init="selectedTab = 'orders'" @endif>
                <div class="btn-group"> 
                    <a class="btn btn-nav" ng-class="{'active':selectedTab === 'profile'}" ng-click="selectedTab = 'profile'" href="#profile" data-toggle="tab">
                        <span class="glyphicon glyphicon-user"></span>
                        <p>Profile</p>
                    </a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-nav" ng-class="{'active':selectedTab === 'shipping-address'}" ng-click="selectedTab = 'shipping-address'" href="#shipping-address" data-toggle="tab">
                        <span class="glyphicon fa fa-address-card"></span>
                        <p>Shipping Address</p>
                    </a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-nav" ng-class="{'active':selectedTab === 'billing-address'}" ng-click="selectedTab = 'billing-address'" href="#billing-address" data-toggle="tab">
                        <span class="glyphicon fa fa-address-card"></span>
                        <p>Billing Address</p>
                    </a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-nav" id="order_tab" ng-class="{'active':selectedTab === 'orders'}" ng-click="selectedTab = 'orders'" href="#orders" data-toggle="tab">
                        <span class="glyphicon fa fa-cart-arrow-down"></span>
                        <p>My Orders</p>
                    </a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-nav" ng-class="{'active':selectedTab === 'change-password'}" ng-click="selectedTab = 'change-password'" href="#change-password" data-toggle="tab">
                        <span class="glyphicon fa fa-cogs"></span>
                        <p>Change Password </p>
                    </a>
                </div>
            </div>
        </div>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane" id="profile">
                    <div class="col-xs-12 col-sm-9 col-md-6 col-lg-6 colsm">
                        <div class="row colsm-row">
                            <h3>Update Account Details:</h3>
                            <hr class="colorgraph">
                            <form name="profileForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitProfile(profileForm.$valid)" novalidate>
                                {{ csrf_field()}}
                                <div class="row1">
                                    <div class="form-group" ng-class="{ 'has-error' : profileForm.first_name.$invalid && !profileForm.first_name.$pristine }">
                                        <input type="text" name="first_name" required="" ng-model="profile.first_name" ng-init="profile.first_name='{{ $users->first_name }}'" class="form-control" placeholder="First Name">
                                        <span ng-show="profileForm.first_name.$invalid && !profileForm.first_name.$pristine" class="help-block">
                                            <strong>Please enter first name.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="row1">
                                    <div class="form-group" ng-class="{ 'has-error' : profileForm.last_name.$invalid && !profileForm.last_name.$pristine }">
                                        <input type="text" name="last_name" required="" ng-model="profile.last_name" ng-init="profile.last_name='{{ $users->last_name }}'" class="form-control" placeholder="Last Name">
                                        <span ng-show="profileForm.last_name.$invalid && !profileForm.last_name.$pristine" class="help-block">
                                            <strong>Please enter last name.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="row1">
                                    <div class="form-group" style="border:1px solid #ccc;">
                                        <div style="position:relative;padding: 10px;">
                                            <a class="btn btn-primary" href="javascript:void(0);">
                                                    Choose File...
                                                    <input name="profile_image" id="profile_image" style="position:absolute;z-index:2;top:0;left:0;opacity:0;background-color:transparent;color:transparent;" name="profile_image" size="40" onchange="$('#upload-file-info').html($(this).val());angular.element(this).scope().setFile(this)" type="file">
                                            </a>
                                            <span class="label label-info" id="upload-file-info"></span>
                                        </div>
                                      </div>
                                </div>
                                <div class="row1">
                                    <div class="form-group text-center" id="previewImage">
                                           @if(!empty($users->user_image))
                                                <img width="200px" src="{{ URL::asset('/user_images').'/'.$users->user_image }}">
                                           @endif
                                    </div>
                                </div>
                                <div class="row1">
                                    <button type="submit" class="btn am-orange btn-block btn-lg">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane @if($order_details == '' && Request::segment(2) != 'order') active @endif" id="shipping-address">
                    <div class="col-xs-12 col-sm-9 col-md-6 col-lg-6 colsm">
                        <div class="row colsm-row">
                            <h3>Update Shipping Address:</h3>
                            <hr class="colorgraph">
                            <form class="form-horizontal" name="shippingForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitShipping(shippingForm.$valid)" novalidate>
                                {{ csrf_field()}}

                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="first_name">First Name:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" class="form-control" readonly="" value="{{ $users->first_name }}" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="last_name">Last Name:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" class="form-control" readonly="" value="{{ $users->last_name }}" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : shippingForm.address1.$invalid && !shippingForm.address1.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="address1">Address1:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="address1"  ng-required="true" ng-model="shipping.address1" ng-init="shipping.address1='{{ @$shipping_address->address1 }}'" class="form-control" placeholder="Address1">
                                        <span ng-show="shippingForm.address1.$invalid && !shippingForm.address1.$pristine" class="help-block">
                                            <strong>Please enter address.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="address2">Address2:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="address2" ng-model="shipping.address2" ng-init="shipping.address2='{{ @$shipping_address->address2 }}'" class="form-control" placeholder="Address2">
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : shippingForm.country_id.$invalid && !shippingForm.country_id.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="country_id">Country:</label>
                                    <div class="col-sm-9 col-md-9" ng-init="getState(<?php echo isset($shipping_address->country_id)?$shipping_address->country_id:231 ?>,'states1')">
                                        <select name="country_id" id="country_id" ng-init="shipping.country_id='{{$shipping_address->country_id or 231}}'" required="" ng-model="shipping.country_id" ng-change="getState(shipping.country_id,'states1')" class="form-control">
                                            <option value="">Please select country</option>
                                            @foreach($countries as $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                        <span ng-show="shippingForm.country_id.$invalid && !shippingForm.country_id.$pristine" class="help-block">
                                            <strong>Please select country.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : shippingForm.state_id.$invalid && !shippingForm.state_id.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="state_id">State:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <select name="state_id" ng-options="obj.id as obj.name for obj in states1" ng-init="shipping.state_id=selectState({{@$shipping_address->state_id}})" required="" ng-model="shipping.state_id" class="form-control">
                                            <option value="">Please select state</option>
                                        </select>
                                        <span ng-show="shippingForm.state_id.$invalid && !shippingForm.state_id.$pristine" class="help-block">
                                            <strong>Please select state.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : shippingForm.city.$invalid && !shippingForm.city.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="city">City:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="city"  ng-required="true" ng-model="shipping.city" ng-init="shipping.city='{{ @$shipping_address->city }}'" class="form-control" placeholder="City">
                                        <span ng-show="shippingForm.city.$invalid && !shippingForm.city.$pristine" class="help-block">
                                            <strong>Please select city.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : shippingForm.zip.$invalid && !shippingForm.zip.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="zip">Postal Code:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="zip" required="" ng-model="shipping.zip" maxlength="6" ng-init="shipping.zip='{{ @$shipping_address->zip }}'" class="form-control" placeholder="Postal Code">
                                        <span ng-show="shippingForm.zip.$invalid && !shippingForm.zip.$pristine" class="help-block">
                                            <strong>Please enter postal code.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <?php $previous_url =  explode("/", parse_url(URL::previous(), PHP_URL_PATH)); ?>
                                @if(isset($previous_url[3]) && $previous_url[3] == 'cart')
                                <input type="hidden" ng-model="shipping.redirect_url" ng-init="shipping.redirect_url='cart'">
                                @endif
                                <div class="row1">
                                    <button type="submit" class="btn am-orange btn-block btn-lg">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="billing-address">
                    <div class="col-xs-12 col-sm-9 col-md-6 col-lg-6 colsm">
                        <div class="row colsm-row">
                            <h3>Update Billing Address:</h3>
                            <hr class="colorgraph">
                             <form class="form-horizontal" name="billingForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitBilling(billingForm.$valid)" novalidate>
                                {{ csrf_field()}}

                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="first_name">First Name:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" class="form-control" readonly="" value="{{ $users->first_name }}" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="last_name">Last Name:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" class="form-control" readonly="" value="{{ $users->last_name }}" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : billingForm.address1.$invalid && !billingForm.address1.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="address1">Address1:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="address1"  ng-required="true" ng-model="billing.address1" ng-init="billing.address1='{{ @$billing_address->address1 }}'" class="form-control" placeholder="Address1">
                                        <span ng-show="billingForm.address1.$invalid && !billingForm.address1.$pristine" class="help-block">
                                            <strong>Please enter address.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="address2">Address2:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="address2" ng-model="billing.address2" ng-init="billing.address2='{{ @$billing_address->address2 }}'" class="form-control" placeholder="Address2">
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : billingForm.country_id.$invalid && !billingForm.country_id.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="country_id">Country:</label>
                                    <div class="col-sm-9 col-md-9" ng-init="getState(<?php echo isset($billing_address->country_id)?$billing_address->country_id:'231' ?>,'states2')">
                                        <select name="country_id" id="country_id" ng-init="billing.country_id='{{$billing_address->country_id or 231}}'" required="" ng-model="billing.country_id" ng-change="getState(billing.country_id)" class="form-control">
                                            <option value="">Please select country</option>
                                            @foreach($countries as $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                        <span ng-show="billingForm.country_id.$invalid && !billingForm.country_id.$pristine" class="help-block">
                                            <strong>Please select country.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : billingForm.state_id.$invalid && !billingForm.state_id.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="state_id">State:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <select name="state_id" ng-options="obj.id as obj.name for obj in states2" required="" ng-model="billing.state_id" ng-init="billing.state_id=selectState({{@$billing_address->state_id}})" class="form-control">
                                            <option value="">Please select state</option>
                                        </select>
                                        <span ng-show="billingForm.state_id.$invalid && !billingForm.state_id.$pristine" class="help-block">
                                            <strong>Please select state.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : billingForm.city.$invalid && !billingForm.city.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="city">City:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="city"  ng-required="true" ng-model="billing.city" ng-init="billing.city='{{ @$billing_address->city }}'" class="form-control" placeholder="City">
                                        <span ng-show="billingForm.city.$invalid && !billingForm.city.$pristine" class="help-block">
                                            <strong>Please select city.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : billingForm.zip.$invalid && !billingForm.zip.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="zip">Postal Code:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="zip" required="" ng-model="billing.zip" maxlength="6" ng-init="billing.zip='{{ @$billing_address->zip }}'" class="form-control" placeholder="Postal Code">
                                        <span ng-show="billingForm.zip.$invalid && !billingForm.zip.$pristine" class="help-block">
                                            <strong>Please enter postal code.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="row1">
                                    <button type="submit" class="btn am-orange btn-block btn-lg">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane @if($order_details != '' || Request::segment(2) == 'order') active @endif" id="orders">
                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 colsm">
                        <div class="row colsm-row" id="order_listing" @if($order_details != '' || Request::segment(2) != 'order') style="display:none;" @endif>
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
                        @if($order_details != '')
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
                        @endif
                    </div>
                </div>
                <div class="tab-pane" id="change-password">
                    <div class="col-xs-12 col-sm-9 col-md-6 col-lg-6 colsm">
                        <div class="row colsm-row">
                            <h3>Change Your Password:</h3>
                            <hr class="colorgraph">
                            <form class="form-horizontal" name="passwordForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitChangePassword(passwordForm.$valid)" novalidate>
                                <input type='text' style="display:none;">
                                <input type='password' style="display:none;">
                                {{ csrf_field()}}
                                <div class="form-group" ng-class="{ 'has-error' : passwordForm.current_password.$invalid && !passwordForm.current_password.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="currentPassword">Current Password:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="password" name="current_password" required="" ng-model="password.current_password" class="form-control" placeholder="Current Password">
                                        <span ng-show="passwordForm.current_password.$invalid && !passwordForm.current_password.$pristine" class="help-block">
                                            <strong>Please enter current password.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : passwordForm.password.$invalid && !passwordForm.password.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="password">New Password:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="password" name="password" required="" ng-model="password.password" class="form-control" placeholder="New Password">
                                        <span ng-show="passwordForm.password.$invalid && !passwordForm.password.$pristine" class="help-block">
                                            <strong>Please enter new password.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : passwordForm.confirm_password.$invalid && !passwordForm.confirm_password.$pristine || password.password !== password.confirm_password }">
                                    <label class="col-sm-3 col-md-3 control-label" for="confirm_password">Confirm Password:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="password" name="confirm_password" required="" ng-model="password.confirm_password" class="form-control" placeholder="Confirm Password">
                                        <span ng-show="password.password !== password.confirm_password" class="help-block">
                                            <strong>Password and confirm password should be same.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="row1">
                                    <button type="submit" ng-disabled="password.password !== password.confirm_password" class="btn am-orange btn-block btn-lg">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
 $(document).ready(function () {
     $(document).on("click","#order_tab",function(){
        $("#order_listing").show();
        $("#order_details").remove();
     });    
     
     $(document).on('show.bs.tab', 'a[data-toggle="tab"]', function (e) {
          var href = $(e.target).attr('href');
          $('a[data-toggle="tab"]').removeClass('active');
          $('a[href="'+href+'"').addClass('active');
     });
 });
</script>
@endpush
