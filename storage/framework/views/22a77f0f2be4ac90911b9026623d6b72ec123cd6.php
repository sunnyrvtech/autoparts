<?php $__env->startPush('stylesheet'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <section>
        <div id="breadcrumb" itemprop="breadcrumb" itemscope="itemscope" itemtype="http://www.schema.org/BreadcrumbList">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="divider"> &gt; </span><span><?php echo e(Request::segment(1)); ?></span>
            <span class="divider"> &gt; </span><span><?php echo e(Request::segment(2)); ?></span>
        </div>
    </section>
    <?php
    $product_images = json_decode($products->product_details->product_images);
    ?>
    <div class="row single-pro-wrp">
        <div class="col-md-5 col-sm-5">
            <div class="product-images">
                <ul class="thumbs">
                    <?php if($product_images): ?>
                    <?php $__currentLoopData = $product_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <li class="current">
                        <a href="javascript:void(0);">
                            <img class="img" src="<?php echo e(URL::asset('/product_images').'/'.$val); ?>">
                        </a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    <?php endif; ?>
                </ul>
                <div id="product-image">
                    <span>
                        <img class="img current-image" id="ShowImage" src="<?php echo e(URL::asset('/product_images').'/'); ?><?php echo e(isset($product_images[0])?$product_images[0]:'default.jpg'); ?>">
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-sm-7">
          
                <div id="product-promo">
                    <h3><?php echo e($products->product_name); ?></h3>
                </div>
            
            <div class="material" elevation="1">
                <div class="product-details-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="price">Sku:</label><span> <?php echo e($products->sku); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="price">Price:</label><span> $<?php echo e($products->price); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="quantity">Available Quantity:</label><span> <?php echo e($products->quantity); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row form-inline">
                        <div class="col-md-12">
                            <form name="cartForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitCart(cartForm.$valid,<?php echo e($products->id); ?>)" novalidate>
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group" ng-class="{ 'has-error' : submitted && cartForm.quantity.$error.required }">
                                    <span ng-show="submitted && cartForm.quantity.$error.required" class="help-block">
                                        <strong>Please select quantity</strong>
                                    </span> 
                                    <label class="control-label" for="product-add-to-cart-quantity">Quantity:</label>
                                    <input size="1" ng-model="cart.quantity" class="form-control" name="quantity" required="">
                                    <button class="btn am-orange" ng-click="submitted=true" type="submit" value="submit">
                                        Add To Cart <span class="glyphicon glyphicon-shopping-cart"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="product-details-con">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#productDetails">Product Details</a></li>
                    <li><a data-toggle="tab" href="#vehicleFit">Vehicle Fit</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="productDetails">     
<!--                        <p><span class="am-orange-text">Part Number: <em>AM-2048461716</em></span></p>-->
                        <div class="product-details-body">
                            <?php echo $products->product_long_description; ?>    
                        </div>
                    </div> 
                    <div class="tab-pane" id="vehicleFit">
                        <h4 class="part-replaces-header">Vehicle Fit</h4>
                        <?php echo $products->vehicle_fit; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<!--<script type="text/javascript">
    
</script>-->
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>