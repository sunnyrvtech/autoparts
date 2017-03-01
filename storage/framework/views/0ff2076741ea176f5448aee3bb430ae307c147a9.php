<?php $__env->startSection('content'); ?>
<!--full width slider on home page-->
<div class="slickSlider-full" style="overflow: initial; display: block;">
    <div class="thumbnail-wrapper">
        <div class="img-wrapper">
            <img src="<?php echo e(URL::asset('/images/slider1.jpg')); ?>" alt="slider" />
        </div>  
    </div>
    <div class="thumbnail-wrapper">
        <div class="img-wrapper">
            <img src="<?php echo e(URL::asset('/images/slider2.jpg')); ?>" alt="slider" />
        </div>  
    </div>
</div>
<div class="container"><!-- /#content.container -->                 
    <div class="row ymm-con">
        <div class="col-md-0"></div>
        <div class="col-md-12 material" elevation="1">
            <div class="am-ymm horizontal hide-header full-width">
                <h2>Select your vehicle</h2>
                <div class="am-ymm-inner">
                    <h3 id="ymm-header">Find parts for your car</h3>
                    <form id="am-ymm-home-form">
                        <div class="btn-group year-select ymm-select">
                            <button class="btn btn-default dropdown-toggle input-xlg" data-toggle="dropdown" type="button">
                                <span class="select-text">Select Vehicle Year</span><span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu scrollable-menu">
                                <li><a role="button">Select Vehicle Year</a></li>
                            </ul>
                        </div>

                        <div class="btn-group make-select ymm-select">
                            <button class="btn btn-default dropdown-toggle input-xlg" data-toggle="dropdown" type="button">
                                <span class="select-text">Select Vehicle Make</span><span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu scrollable-menu">
                                <li><a role="button">Select Vehicle Make</a></li>
                            </ul>
                        </div>

                        <div class="btn-group model-select ymm-select">
                            <button class="btn btn-default dropdown-toggle input-xlg" data-toggle="dropdown" type="button">
                                <span class="select-text">Select Vehicle Model</span><span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu scrollable-menu">
                                <li><a role="button">Select Vehicle Model</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-xlg am-orange hover material ymm-submit" elevation="1" type="submit">Search</button>
                        <br class="clearfix" />
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-0"></div>
    </div>
    <div class="row featured-cats-con">
        <div class="col-md-12 material" elevation="1">
            <!-- Featured Categories -->
            <div class="home-page-card-con">
                <div class="home-page-card-con-inner">
                    <h3 class="text-center">Featured Categories</h3>
                    <!--                <div class="carousel-loading">
                                        <i class="glyphicon glyphicon-repeat gly-spin"></i>
                                    </div>-->
                    <div class="slickSlider-con slickSlider" type="TOP_BASIC_MAKE" style="overflow: initial; display: block;">
                        <?php $__currentLoopData = $featured_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <div class="thumbnail-wrapper">
                            <a class="thumbnail" href="javascript:void(0);">
                                <!--                            <div class="img-wrapper">
                                                                <img class="" src="https://db08le7w43ifw.cloudfront.net/catimage/19/main.JPG" alt="Headlight Assemblies" />
                                                            </div>  -->
                                <div class="caption">
                                    <div class="caption-text truncate"><?php echo e($value->name); ?></div>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </div>
                    <div class="full-list-widget">
                        <div class="actions">
                            <a class="btn am-orange hover material" elevation="1" href="javascript:void(0);">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row popular-brands-con" >
        <div class="col-md-12">
            <div class="col-md-6">
                <!-- Popular Brands -->
                <div class="home-page-card-con material" elevation="1">
                    <div class="home-page-card-con-inner">
                        <h3>Popular Brands</h3>
                        <!--                <div class="carousel-loading">
                                            <i class="glyphicon glyphicon-repeat gly-spin"></i>
                                        </div>-->
                        <div class="slickSlider-half slickSlider"  type="TOP_BASIC_MAKE" style="overflow: initial; display: block;">
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <div class="thumbnail-wrapper">
                                <a class="thumbnail" href="javascript:void(0);">
                                    <!--                                <div class="img-wrapper">
                                                                        <img class="" src="" alt="" />
                                                                    </div>-->
                                    <div class="caption">
                                        <div class="caption-text truncate"><?php echo e($value->name); ?></div>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </div>
                        <div class="full-list-widget">
                            <div class="actions">
                                <a class="btn am-orange hover material" elevation="1" href="javascript:void(0);">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="home-page-card-con material" elevation="1">
                    <div class="home-page-card-con-inner">
                        <h3>Shop by Vehicle</h3>
                        <div class="slickSlider-half slickSlider" type="TOP_BASIC_MAKE" style="overflow: initial; display: block;">
                            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <div class="thumbnail-wrapper">
                                <a class="thumbnail" href="javascript:void(0);">
                                    <div class="caption">
                                        <div class="caption-text truncate"><?php echo e($value->name); ?></div>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </div>
                        <div class="full-list-widget">
                            <div class="actions">
                                <a class="btn am-orange hover material" elevation="1" href="javascript:void(0);">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--    <div class="row shop-by-make-con">
            <div class="col-md-0"></div>
            
            <div class="col-md-0"></div>
        </div>-->

    <div class="row featured-products-con">
        <div class="col-md-12 material" elevation="1">
            <!-- Featured Categories -->
            <div class="home-page-card-con">
                <div class="home-page-card-con-inner">
                    <h3 class="text-center">Latest Products</h3>

                    <div class="slickSlider-con slickSlider"  style="overflow: initial; display: block;">

                        <div class="thumbnail-wrapper">
                            <a class="thumbnail" href="javascript:void(0);">
                                <div class="img-wrapper">
                                    <img src="<?php echo e(URL::asset('/images/product1.jpg')); ?>" alt="" />
                                </div>  
                                <div class="caption">
                                    <div class="caption-text truncate">Product1</div>
                                </div>
                            </a>
                        </div>
                        <div class="thumbnail-wrapper">
                            <a class="thumbnail" href="javascript:void(0);">
                                <div class="img-wrapper">
                                    <img src="<?php echo e(URL::asset('/images/product2.jpg')); ?>" alt="" />
                                </div>  
                                <div class="caption">
                                    <div class="caption-text truncate">Product2</div>
                                </div>
                            </a>
                        </div>
                        <div class="thumbnail-wrapper">
                            <a class="thumbnail" href="javascript:void(0);">
                                <div class="img-wrapper">
                                    <img src="<?php echo e(URL::asset('/images/product3.jpg')); ?>" alt="" />
                                </div>  
                                <div class="caption">
                                    <div class="caption-text truncate">Product3</div>
                                </div>
                            </a>
                        </div>
                        <div class="thumbnail-wrapper">
                            <a class="thumbnail" href="javascript:void(0);">
                                <div class="img-wrapper">
                                    <img src="<?php echo e(URL::asset('/images/product1.jpg')); ?>" alt="" />
                                </div>  
                                <div class="caption">
                                    <div class="caption-text truncate">Product4</div>
                                </div>
                            </a>
                        </div>
                        <div class="thumbnail-wrapper">
                            <a class="thumbnail" href="javascript:void(0);">
                                <div class="img-wrapper">
                                    <img src="<?php echo e(URL::asset('/images/product2.jpg')); ?>" alt="" />
                                </div>  
                                <div class="caption">
                                    <div class="caption-text truncate">Product5</div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <div class="full-list-widget">
                        <div class="actions">
                            <a class="btn am-orange hover material" elevation="1" href="javascript:void(0);">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row featured-products-con">
        <div class="col-md-12 material" elevation="1">
            <!-- Featured Categories -->
            <div class="home-page-card-con">
                <div class="home-page-card-con-inner">
                    <h3 class="text-center">Testimonials</h3>
                    <div class="slickSlider-full slickSlider"  style="overflow: initial; display: block;">
                        <div class="thumbnail-wrapper">
                            <div class="col-sm-3 text-center">
                                <img class="img-circle" src="<?php echo e(URL::asset('/images/default-avatar.png')); ?>" style="width: 100px;height:100px;">
                            </div>
                            <div class="col-sm-9">
                                <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit!</p>
                                <small>Someone famous</small>
                            </div>
                        </div>
                        <div class="thumbnail-wrapper">
                            <div class="col-sm-3 text-center">
                                <img class="img-circle" src="<?php echo e(URL::asset('/images/default-avatar.png')); ?>" style="width: 100px;height:100px;">
                            </div>
                            <div class="col-sm-9">
                                <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit!</p>
                                <small>Someone famous</small>
                            </div>
                        </div>
                        <div class="thumbnail-wrapper">
                            <div class="col-sm-3 text-center">
                                <img class="img-circle" src="<?php echo e(URL::asset('/images/default-avatar.png')); ?>" style="width: 100px;height:100px;">
                            </div>
                            <div class="col-sm-9">
                                <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit!</p>
                                <small>Someone famous</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row about-us-con">
        <div class="col-md-0"></div>
        <div class="col-md-12 material" elevation="1">
            <br />
            <h1 class="welcome-msg">Welcome to Auto Light House!</h1>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<a href="<?php echo e(url('.')); ?>">AUTOLIGHTHOUSE.COM</a>!</p>
        </div>
        <div class="col-md-0"></div>
    </div>
</div><!-- /#content.container -->
<script src="<?php echo e(URL::asset('/slick/slick.js')); ?>"></script>
<script type="text/javascript">
$(".slickSlider-full").slick({autoplay: true});
$(".slickSlider-half").slick({
    autoplay: false,
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,

});
$(".slickSlider-con").slick({
    autoplay: false,
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 900,
            settings: {
                slidesToShow: 3
            }
        },
        {
            breakpoint: 500,
            settings: {
                slidesToShow: 2
            }
        }
    ]
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>