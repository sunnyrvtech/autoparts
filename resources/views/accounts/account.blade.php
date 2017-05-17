@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container"><!-- /#content.container -->   
    <div class="my-account">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <div class="btn-group btn-group-vertical" ng-init="selectedTab = 'shipping-address'">
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
                    <a class="btn btn-nav" ng-class="{'active':selectedTab === 'orders'}" ng-click="selectedTab = 'orders'" href="#orders" data-toggle="tab">
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
        <div class="col-xs-12 col-sm-9 col-md-6 col-lg-6">
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane" id="profile">
                    <div class="row">
                        <h3>Update Account Details:</h3>
                        <hr class="colorgraph">
                        
                        <form name="profileForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitProfile(profileForm.$valid)" novalidate>
                            {{ csrf_field()}}
                            <div class="row">
                                <div class="form-group" ng-class="{ 'has-error' : profileForm.first_name.$invalid && !profileForm.first_name.$pristine }">
                                    <input type="text" name="first_name" required="" ng-model="profile.first_name" ng-init="profile.first_name='{{ $users->first_name }}'" class="form-control" placeholder="First Name">
                                    <span ng-show="profileForm.first_name.$invalid && !profileForm.first_name.$pristine" class="help-block">
                                        <strong>Please enter first name.</strong>
                                    </span> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group" ng-class="{ 'has-error' : profileForm.last_name.$invalid && !profileForm.last_name.$pristine }">
                                    <input type="text" name="last_name" required="" ng-model="profile.last_name" ng-init="profile.last_name='{{ $users->last_name }}'" class="form-control" placeholder="Last Name">
                                    <span ng-show="profileForm.last_name.$invalid && !profileForm.last_name.$pristine" class="help-block">
                                        <strong>Please enter last name.</strong>
                                    </span> 
                                </div>
                            </div>
                            <div class="row">
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
                            <div class="row">
                                <div class="form-group text-center" id="previewImage">
                                       @if(!empty($users->user_image))
                                            <img width="200px" src="{{ URL::asset('/user_images').'/'.$users->user_image }}">
                                       @endif
                                </div>
                            </div>
                            <div class="row">
                                <button type="submit" class="btn btn-success btn-block btn-lg">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane active" id="shipping-address">
                    <div class="row">
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
                                <div class="col-sm-9 col-md-9" ng-init="getState(<?php echo isset($shipping_address->country_id)?$shipping_address->country_id:'undefined' ?>,'states1')">
                                    <select name="country_id" id="country_id" ng-init="shipping.country_id='{{@$shipping_address->country_id}}'" required="" ng-model="shipping.country_id" ng-change="getState(shipping.country_id,'states1')" class="form-control">
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
                            @if($previous_url[3] == 'cart')
                            <input type="hidden" ng-model="shipping.redirect_url" ng-init="shipping.redirect_url='cart'">
                            @endif
                            <div class="row">
                                <button type="submit" class="btn btn-success btn-block btn-lg">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="billing-address">
                    <div class="row">
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
                                <div class="col-sm-9 col-md-9" ng-init="getState(<?php echo isset($billing_address->country_id)?$billing_address->country_id:'undefined' ?>,'states2')">
                                    <select name="country_id" id="country_id" ng-init="billing.country_id='{{@$billing_address->country_id}}'" required="" ng-model="billing.country_id" ng-change="getState(billing.country_id)" class="form-control">
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
                            <div class="row">
                                <button type="submit" class="btn btn-success btn-block btn-lg">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="orders">
                    <div class="row">
                        <h3>Your Orders:</h3>
                        <hr class="colorgraph">
                    </div>
                </div>
                <div class="tab-pane" id="change-password">
                    <div class="row">
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
                            <div class="row">
                                <button type="submit" ng-disabled="password.password !== password.confirm_password" class="btn btn-success btn-block btn-lg">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush
