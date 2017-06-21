<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Update Shipping Rate
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo e(route('shipping_rates.update',$shipping_rates->id)); ?>">
            <input name="_method" value="PUT" type="hidden">
            <?php echo e(csrf_field()); ?>

                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group <?php echo e($errors->has('country_id') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="name">Name:</label>
                        <div class="col-sm-9 col-md-9">
                            <select name="country_id" required="" id="country_id"  class="form-control">
                                <option value="">Please select country</option>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <option <?php if($val->id == $shipping_rates->country_id): ?> selected <?php endif; ?> value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </select>
                            <?php if($errors->has('country_id')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors-> first('country_id')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('low_weight') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="low_weight">Low Weight:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" name="low_weight" required="" value="<?php echo e($shipping_rates->low_weight); ?>" class="form-control" placeholder="Low Weight">
                            <?php if($errors->has('low_weight')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors-> first('low_weight')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('high_weight') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="high_weight">High Weight:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" name="high_weight" required="" value="<?php echo e($shipping_rates->high_weight); ?>" class="form-control" placeholder="High Weight">
                            <?php if($errors->has('high_weight')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors-> first('high_weight')); ?></strong>
                            </span> 
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('price') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="price">Price:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" name="price" required="" value="<?php echo e(number_format($shipping_rates->price)); ?>" class="form-control" placeholder="Price">
                            <?php if($errors->has('price')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors-> first('price')); ?></strong>
                            </span> 
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                </div>

            <div class="row">
                <div class="col-lg-6">
                    <button type="submit" class="btn btn-success btn-block btn-lg">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>