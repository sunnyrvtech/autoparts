<?php $__env->startPush('stylesheet'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container"><!-- /#content.container -->   
    <div class="my-account">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <div class="btn-group btn-group-vertical" <?php if($order_details == '' && Request::segment(2) != 'order'): ?> ng-init="selectedTab = 'shipping-address'" <?php else: ?> ng-init="selectedTab = 'orders'" <?php endif; ?>>
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
                                <?php echo e(csrf_field()); ?>

                                <div class="row1">
                                    <div class="form-group" ng-class="{ 'has-error' : profileForm.first_name.$invalid && !profileForm.first_name.$pristine }">
                                        <input type="text" name="first_name" required="" ng-model="profile.first_name" ng-init="profile.first_name='<?php echo e($users->first_name); ?>'" class="form-control" placeholder="First Name">
                                        <span ng-show="profileForm.first_name.$invalid && !profileForm.first_name.$pristine" class="help-block">
                                            <strong>Please enter first name.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="row1">
                                    <div class="form-group" ng-class="{ 'has-error' : profileForm.last_name.$invalid && !profileForm.last_name.$pristine }">
                                        <input type="text" name="last_name" required="" ng-model="profile.last_name" ng-init="profile.last_name='<?php echo e($users->last_name); ?>'" class="form-control" placeholder="Last Name">
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
                                           <?php if(!empty($users->user_image)): ?>
                                                <img width="200px" src="<?php echo e(URL::asset('/user_images').'/'.$users->user_image); ?>">
                                           <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row1">
                                    <button type="submit" class="btn btn-success btn-block btn-lg">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane <?php if($order_details == '' && Request::segment(2) != 'order'): ?> active <?php endif; ?>" id="shipping-address">
                    <div class="col-xs-12 col-sm-9 col-md-6 col-lg-6 colsm">
                        <div class="row colsm-row">
                            <h3>Update Shipping Address:</h3>
                            <hr class="colorgraph">
                            <form class="form-horizontal" name="shippingForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitShipping(shippingForm.$valid)" novalidate>
                                <?php echo e(csrf_field()); ?>


                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="first_name">First Name:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" class="form-control" readonly="" value="<?php echo e($users->first_name); ?>" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="last_name">Last Name:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" class="form-control" readonly="" value="<?php echo e($users->last_name); ?>" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : shippingForm.address1.$invalid && !shippingForm.address1.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="address1">Address1:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="address1"  ng-required="true" ng-model="shipping.address1" ng-init="shipping.address1='<?php echo e(@$shipping_address->address1); ?>'" class="form-control" placeholder="Address1">
                                        <span ng-show="shippingForm.address1.$invalid && !shippingForm.address1.$pristine" class="help-block">
                                            <strong>Please enter address.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="address2">Address2:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="address2" ng-model="shipping.address2" ng-init="shipping.address2='<?php echo e(@$shipping_address->address2); ?>'" class="form-control" placeholder="Address2">
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : shippingForm.country_id.$invalid && !shippingForm.country_id.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="country_id">Country:</label>
                                    <div class="col-sm-9 col-md-9" ng-init="getState(<?php echo isset($shipping_address->country_id)?$shipping_address->country_id:'undefined' ?>,'states1')">
                                        <select name="country_id" id="country_id" ng-init="shipping.country_id='<?php echo e(@$shipping_address->country_id); ?>'" required="" ng-model="shipping.country_id" ng-change="getState(shipping.country_id,'states1')" class="form-control">
                                            <option value="">Please select country</option>
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                            <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                        </select>
                                        <span ng-show="shippingForm.country_id.$invalid && !shippingForm.country_id.$pristine" class="help-block">
                                            <strong>Please select country.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : shippingForm.state_id.$invalid && !shippingForm.state_id.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="state_id">State:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <select name="state_id" ng-options="obj.id as obj.name for obj in states1" ng-init="shipping.state_id=selectState(<?php echo e(@$shipping_address->state_id); ?>)" required="" ng-model="shipping.state_id" class="form-control">
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
                                        <input type="text" name="city"  ng-required="true" ng-model="shipping.city" ng-init="shipping.city='<?php echo e(@$shipping_address->city); ?>'" class="form-control" placeholder="City">
                                        <span ng-show="shippingForm.city.$invalid && !shippingForm.city.$pristine" class="help-block">
                                            <strong>Please select city.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : shippingForm.zip.$invalid && !shippingForm.zip.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="zip">Postal Code:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="zip" required="" ng-model="shipping.zip" maxlength="6" ng-init="shipping.zip='<?php echo e(@$shipping_address->zip); ?>'" class="form-control" placeholder="Postal Code">
                                        <span ng-show="shippingForm.zip.$invalid && !shippingForm.zip.$pristine" class="help-block">
                                            <strong>Please enter postal code.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <?php $previous_url =  explode("/", parse_url(URL::previous(), PHP_URL_PATH)); ?>
                                <?php if($previous_url[3] == 'cart'): ?>
                                <input type="hidden" ng-model="shipping.redirect_url" ng-init="shipping.redirect_url='cart'">
                                <?php endif; ?>
                                <div class="row1">
                                    <button type="submit" class="btn btn-success btn-block btn-lg">Submit</button>
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
                                <?php echo e(csrf_field()); ?>


                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="first_name">First Name:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" class="form-control" readonly="" value="<?php echo e($users->first_name); ?>" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="last_name">Last Name:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" class="form-control" readonly="" value="<?php echo e($users->last_name); ?>" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : billingForm.address1.$invalid && !billingForm.address1.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="address1">Address1:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="address1"  ng-required="true" ng-model="billing.address1" ng-init="billing.address1='<?php echo e(@$billing_address->address1); ?>'" class="form-control" placeholder="Address1">
                                        <span ng-show="billingForm.address1.$invalid && !billingForm.address1.$pristine" class="help-block">
                                            <strong>Please enter address.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 control-label" for="address2">Address2:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="address2" ng-model="billing.address2" ng-init="billing.address2='<?php echo e(@$billing_address->address2); ?>'" class="form-control" placeholder="Address2">
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : billingForm.country_id.$invalid && !billingForm.country_id.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="country_id">Country:</label>
                                    <div class="col-sm-9 col-md-9" ng-init="getState(<?php echo isset($billing_address->country_id)?$billing_address->country_id:'undefined' ?>,'states2')">
                                        <select name="country_id" id="country_id" ng-init="billing.country_id='<?php echo e(@$billing_address->country_id); ?>'" required="" ng-model="billing.country_id" ng-change="getState(billing.country_id)" class="form-control">
                                            <option value="">Please select country</option>
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                            <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                        </select>
                                        <span ng-show="billingForm.country_id.$invalid && !billingForm.country_id.$pristine" class="help-block">
                                            <strong>Please select country.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : billingForm.state_id.$invalid && !billingForm.state_id.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="state_id">State:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <select name="state_id" ng-options="obj.id as obj.name for obj in states2" required="" ng-model="billing.state_id" ng-init="billing.state_id=selectState(<?php echo e(@$billing_address->state_id); ?>)" class="form-control">
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
                                        <input type="text" name="city"  ng-required="true" ng-model="billing.city" ng-init="billing.city='<?php echo e(@$billing_address->city); ?>'" class="form-control" placeholder="City">
                                        <span ng-show="billingForm.city.$invalid && !billingForm.city.$pristine" class="help-block">
                                            <strong>Please select city.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : billingForm.zip.$invalid && !billingForm.zip.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="zip">Postal Code:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="text" name="zip" required="" ng-model="billing.zip" maxlength="6" ng-init="billing.zip='<?php echo e(@$billing_address->zip); ?>'" class="form-control" placeholder="Postal Code">
                                        <span ng-show="billingForm.zip.$invalid && !billingForm.zip.$pristine" class="help-block">
                                            <strong>Please enter postal code.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="row1">
                                    <button type="submit" class="btn btn-success btn-block btn-lg">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane <?php if($order_details != '' || Request::segment(2) == 'order'): ?> active <?php endif; ?>" id="orders">
                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 colsm">
                        <div class="row colsm-row" id="order_listing" <?php if($order_details != '' || Request::segment(2) == 'order'): ?> style="display:none;" <?php endif; ?>>
                            <h3>Your Orders:</h3>
                            <hr class="colorgraph">
                          <div class="table-wrp">
                            <table class="table">
                                <thead class="thead-inverse">
                                  <tr>
                                      <th><label>Order#</label></th>
                                      <th><label>Date</label></th>
                                      <th><label>Ship To</label></th>
                                      <th><label>Order Total</label></th>
                                      <th><label>Order Status</label></th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <?php $total_price = ''; ?>
                                        <?php $__currentLoopData = $value->getOrderDetailById; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                            <?php $total_price += $val->total_price; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                        <tr>
                                          <td><?php echo e($value->id); ?></td>
                                          <td><?php echo e(date('m-d-Y H:i:s',strtotime($value->created_at))); ?></td>
                                          <td><?php echo e(Auth::user()->first_name.' '.Auth::user()->last_name); ?></td>
                                          <td>$<?php echo e($total_price+$value->ship_price); ?></td>
                                          <td><?php echo e($value->order_status); ?></td>
                                          <td>
                                              <span class="nobr"><a href="<?php echo e(URL('/my-account/order/view').'/'.$value->id); ?>">View Order</a></span>
                                          </td>
                                        </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                </tbody>
                              </table>
                              </div>
                        </div>
                        <?php if($order_details != ''): ?>
                        <div class="row colsm-row" id="order_details">
                                <h3>Order Details:</h3>
                                <table class="table order-detail">
                                <thead>
                                    <tr>
                                        <th><label>Item Details</label></th>
                                        <th><label>Quantity</label></th>
                                        <th><label>Price</label></th>
                                        <th><label>Total</label></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sub_total='' ?>
                                    <?php $__currentLoopData = $order_details->getOrderDetailById; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <?php $sub_total += $val->total_price; ?>
                                    <tr>
                                        <td>
                                            <a class="ga-product-link" href="<?php echo e(URL('products').'/'.$val->getProduct->product_slug); ?>"><?php echo e($val->getProduct->product_name); ?></a>
                                            <div class="product-sku">Part Number: <?php echo e($val->getProduct->part_number); ?></div>
                                        </td>
                                        <td>
                                            <div><?php echo e($val->quantity); ?></div>
                                        </td>
                                        <td>
                                            <div>$<?php echo e($val->getProduct->price); ?></div>
                                        </td>
                                        <td>
                                            <div class="">$<?php echo e($val->total_price); ?></div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                </tbody>
                            </table>
                                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                                    <h4>Order Total:</h4>
                                    <div class="outer-order">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label>Subtotal:</label>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                                <span>$<?php echo e(number_format($sub_total,2)); ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label>Shipping & Handling:</label>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                                <span>$<?php echo e($order_details->ship_price); ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label>Total:</label>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                                <span class="price">$<?php echo e(number_format($sub_total+$order_details->ship_price,2)); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
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
                                <?php echo e(csrf_field()); ?>

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
                                    <button type="submit" ng-disabled="password.password !== password.confirm_password" class="btn btn-success btn-block btn-lg">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
 $(document).ready(function () {
     $(document).on("click","#order_tab",function(){
        $("#order_listing").show();
        $("#order_details").remove();
     });    
 });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>