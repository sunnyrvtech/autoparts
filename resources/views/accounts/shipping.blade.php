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
                    <div class="col-xs-12 col-sm-9 col-md-6 col-lg-6 colsm">
                        <div class="row colsm-row">
                            <h3>Update Shipping Address:</h3>
                            <hr class="colorgraph">
                            <form class="form-horizontal" name="shippingForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitShipping(shippingForm.$valid)" novalidate>
                                {{ csrf_field()}}

                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="first_name">First Name:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" class="form-control" readonly="" value="{{ Auth::user()->first_name }}" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="last_name">Last Name:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" class="form-control" readonly="" value="{{ Auth::user()->last_name }}" placeholder="Last Name">
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
            </div>
</div>
</div>
@endsection
