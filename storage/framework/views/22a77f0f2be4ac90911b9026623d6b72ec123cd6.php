<?php $__env->startPush('stylesheet'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="product-images">
                <ul class="thumbs">
                    <li class="current">
                        <a href="javascript:void(0);">
                            <img class="img" src="https://db08le7w43ifw.cloudfront.net/partimage/LTP/AM-2048461716/88b8cce3d7b34263bddfadc8f1eaa662_120.jpg">
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <img class="img" src="https://db08le7w43ifw.cloudfront.net/partimage/LTP/AM-2048461716/01d3cd3f289d4133a32a71efb44de08c_120.jpg">
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);">
                            <img class="img" src="https://db08le7w43ifw.cloudfront.net/partimage/LTP/AM-2048461716/b494cf9e8bac481090e0550313d37a8c_120.jpg">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img class="img" src="https://db08le7w43ifw.cloudfront.net/partimage/LTP/AM-2048461716/427d809bdfcb4b84b522f0303cf00bad_120.jpg">
                        </a>
                    </li>
                </ul>
                <div id="product-image">
                    <span>
                        <img class="img current-image" element="img" id="ShowImage" itemprop="image" data-original="https://db08le7w43ifw.cloudfront.net/partimage/LTP/AM-2048461716/88b8cce3d7b34263bddfadc8f1eaa662_386.jpg" src="https://db08le7w43ifw.cloudfront.net/partimage/LTP/AM-2048461716/88b8cce3d7b34263bddfadc8f1eaa662_386.jpg">
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div id="product-promo">
                    <h3>1997-1997 Mercury Mountaineer License Plate Light Pair Black Ford OEM F37Z13550A AM-2048461716</h3>
                    <div class="pricing-list">
                        <div class="am-price">
                            <span>Price:</span><span>$32.40</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-inline add-to-cart-full" id="frmAddToCart">
                    <div class="form-group">
                        <label for="product-add-to-cart-quantity">Quantity:</label>
                        <select class="form-control" id="product-add-to-cart-quantity" name="quantity" required="">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <button class="btn am-orange hover material add-to-cart-button" elevation="1" type="submit" value="submit">
                        Add To Cart <span aria-hidden="true" class="glyphicon glyphicon-shopping-cart"></span></button>
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
                        <p><span class="am-orange-text">Part Number: <em>AM-2048461716</em></span></p>
                        <div class="product-details-body">
                            Product descriptions   
                        </div>
                    </div> 
                    <div class="tab-pane" id="vehicleFit">
                        <h4 class="part-replaces-header">Vehicle Fit</h4>
                        Vehicle Fit Description
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