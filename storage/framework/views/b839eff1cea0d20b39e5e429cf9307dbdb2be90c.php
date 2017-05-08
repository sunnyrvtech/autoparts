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
    <div class="container-fluid order-container">
        <?php if(!empty($cart_data)): ?>
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
                            <?php $__currentLoopData = $cart_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                                    <input class="order-quantity-dropdown form-control" value="<?php echo e($value['quantity']); ?>">
                                </td>
                                <td>
                                    <div>$<?php echo e($value['price']); ?></div>
                                </td>
                                <td>
                                    <div class="">$<?php echo e($value['total_price']); ?></div>
                                </td>
                                <td>
                                    <a class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></a>
                                    <a class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
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
                                        <input class="order-quantity-dropdown form-control" value="<?php echo e($value['quantity']); ?>">
                                    </td>
                                    <td>
                                        <div>$<?php echo e($value['price']); ?></div>
                                    </td>
                                    <td>
                                        <div class="">$<?php echo e($value['total_price']); ?></div>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></a>
                                        <a class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
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
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label">Shipping To: </label>
                    </div>
                    <div class="col-md-6">
                        <span>sad</span><span>adasda</span>,
                        <span>asdasd</span>,
                        <span>
                            <span>asdasda</span>,
                        </span>
                        <span>chandigarh</span>,
                        <span>NY</span>
                        <span>16004</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
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
                            <!--<span>$239.90</span>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <label>Total:</label>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <!--<span class="price">$267.56</span>-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button class="btn btn-success btn-block" type="submit">Checkout</button>
                </div>`
            </div>
        </div>
        <?php else: ?>
        <span>Your cart is empty</span>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>