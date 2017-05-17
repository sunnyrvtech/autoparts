<?php $__env->startPush('stylesheet'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="container-fluid page-header-wrapper cart-header">
        <div class="row">
            <div class="col-md-12 col-sm-8 col-xs-12">
                <h1 class="onea-page-header">View Cart</h1>
            </div>
        </div>
    </div>
    <div id="checkout-final-con" class="container-fluid order-container">
        <?php if(!empty($cart_data)): ?>
        
        <form class="form-horizontal" action="<?php echo e(route('payment.store')); ?>" method="post">
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
                                <?php $__currentLoopData = $cart_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <?php $total_price_cart += $value['total_price']; ?>
                                <tr>
                                    <td>
                                        <div class="product-image"><img src="<?php echo e(URL::asset('/product_images').'/'.$value['product_image']); ?>" alt="<?php echo e($value['product_name']); ?>" width="120" height="120"></div>
                                    </td>
                                    <td>
                                        <a class="ga-product-link" href="<?php echo e(URL('products').'/'.$value['product_slug']); ?>"><?php echo e($value['product_name']); ?></a>
                                        <!--<div class="product-shipping-text">In Stock Ships Within 1 Business Day FREE SHIPPING AND HANDLING!</div>-->
                                        <div class="product-sku">Part Number: <?php echo e($value['part_number']); ?></div>
                                        <div class="product-fit">Make: <?php echo e($value['vehicle_company']); ?> / Model: <?php echo e($value['vehicle_model']); ?> / Year: <?php echo e($value['vehicle_year']); ?></div>
                                    </td>
                                    <td>
                                        <input class="order-quantity-dropdown form-control" value="<?php echo e($value['quantity']); ?>" data-product-id="<?php echo e($value['product_id']); ?>">
                                        <input type="hidden" name="cart_id[]" value="<?php echo e($value['cart_id']); ?>">
                                    </td>
                                    <td>
                                        <div>$<?php echo e($value['price']); ?></div>
                                    </td>
                                    <td>
                                        <div class="">$<?php echo e($value['total_price']); ?></div>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger btn-sm" ng-click="submitDeleteCart(<?php echo e($value['cart_id']); ?>,<?php echo e($value['quantity']); ?>)"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mobile-carts-items">
                        <?php $__currentLoopData = $cart_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <div class="row">
                            <div class="image-and-title">
                                <div class="image">
                                    <img src="<?php echo e(URL::asset('/product_images').'/'.$value['product_image']); ?>" alt="<?php echo e($value['product_name']); ?>" width="120" height="120">
                                </div>
                                <div class="title">
                                    <a class="ga-product-link" href="<?php echo e(URL('products').'/'.$value['product_slug']); ?>"><?php echo e($value['product_name']); ?></a>
                                </div>
                            </div>

                            <!--                        <div class="product-shipping-text">
                                                        In Stock Ships Within 1 Business Day<br>
                                                        FREE SHIPPING AND HANDLING!
                                                    </div>-->
                            <div class="product-sku">Part Number: <?php echo e($value['part_number']); ?></div>
                            <div class="product-fit">Make: <?php echo e($value['vehicle_company']); ?> / Model: <?php echo e($value['vehicle_model']); ?> / Year: <?php echo e($value['vehicle_year']); ?></div>

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
                                            <input class="order-quantity-dropdown form-control" value="<?php echo e($value['quantity']); ?>" data-product-id="<?php echo e($value['product_id']); ?>">
                                        </td>
                                        <td>
                                            <div>$<?php echo e($value['price']); ?></div>
                                        </td>
                                        <td>
                                            <div class="">$<?php echo e($value['total_price']); ?></div>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-sm" ng-click="submitDeleteCart(<?php echo e($value['cart_id']); ?>)"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>   
                                </tbody>
                            </table>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </div>
                </div>
            </div>
            <div class="row shipping-section material" elevation="1">
                <div class="col-md-6">
                    <?php if(!empty($shipping_address) && Auth::check()): ?>
                    <div class="row">
                        <h4>Shipping To: </h4>
                        <div class="col-md-6">
                            <span><?php echo e(Auth::user()->first_name); ?></span><span> <?php echo e(Auth::user()->last_name); ?></span>,
                            <span><?php echo e(Auth::user()->email); ?></span>
                            <span>
                                <span><?php echo e($shipping_address->address1); ?></span><span> <?php echo e($shipping_address->address2); ?></span>
                            </span><br>
                            <span><?php echo e($shipping_address->city); ?></span>,<span><?php echo e($shipping_address->get_state->name); ?><br>
                            </span><span> <?php echo e($shipping_address->get_country->name); ?></span><span> <?php echo e($shipping_address->zip); ?></span>

                        </div>
                    </div>
                    <div class="row"><a href="<?php echo e(URL('/my-account')); ?>" class="btn btn-success" type="submit">Edit Shipping Address</a></div>
                    <?php endif; ?>
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
                                <span>$<?php echo e($total_price_cart); ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <label>Total:</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span class="price">$<?php echo e($total_price_cart); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if(Auth::check() && !empty($shipping_address)): ?>
                        <a class="btn btn-success btn-block" ng-click="account_cart_area=true" ng-show="!account_cart_area">Checkout</a>
                        <?php elseif(empty($shipping_address)): ?>
                        <a class="btn btn-success btn-block" href="<?php echo e(URL('/my-account')); ?>" type="button">Checkout</a>
                        <?php else: ?>
                        <button class="btn btn-success btn-block" ng-click="login()" type="button">Checkout</button>
                        <?php endif; ?>
                    </div>`
                </div>
                <?php if(Auth::check()): ?>
                 <div class="row" ng-show="account_cart_area">
                     <div class="col-md-6"></div>
                     <div class="col-md-6">
                        <h4>Enter Payment Information:</h4>
                            <div class="form-group form-group-sm">
                                <label class="col-sm-4 control-label" for="cardholderName">Name Of Card Holder: *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="cardholderName" name="cardholderName" required="" value="<?php echo e(Auth::user()->first_name.' '.Auth::user()->last_name); ?>" type="text">
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
                                        <select class="form-control"  name="expiry_month" required="">
                                            <option>--Select Month--</option>
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
                                            <option>--Select Year--</option>
                                            <?php
                                            $currentYear = date('Y');
                                            $nextYear = date('Y', strtotime('+10 year'));
                                            // set start and end year range
                                            $yearArray = range($currentYear, $nextYear);
                                            ?>
                                             <?php $__currentLoopData = $yearArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                               <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
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
                <?php endif; ?>
            </div>
        </form>
        <?php else: ?>
        <span>Your cart is empty</span>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>