<?php $__env->startSection('content'); ?>
<div class="container">
    <div>
        <section><div id="breadcrumb">
                <a href="<?php echo e(url('/')); ?>">Home</a>
                <span class="divider"> &gt; </span><span><?php echo e($sub_categories->name); ?></span></div>
            <br></section>
        <div>
            <div class="container-fluid">
                <div class="row">
                    <h1 class="onea-page-header"><?php echo e($sub_categories->name); ?></h1>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="catalog-list row">
                                <?php $__currentLoopData = $sub_categories->sub_sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <div class="col-xs-4">
                                    <div class="row">
                                        <div class="col-xs-12 catalog-list-item">
                                            <a href="<?php echo e(url('/'.$value->get_vehicle_company_name->name.'/'.$sub_categories->slug)); ?>"><span class="fa fa-angle-double-right"></span> <?php echo e($sub_categories->name.' '.$value->get_vehicle_company_name->name); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>