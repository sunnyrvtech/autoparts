<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Update Shipping Method
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo e(route('shipping.update',$shipping_methods->id)); ?>">
            <input name="_method" value="PUT" type="hidden">
            <?php echo e(csrf_field()); ?>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="name">Name:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" name="name" value="<?php echo e($shipping_methods->name); ?>" class="form-control" placeholder="Name">
                            <?php if($errors->has('name')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('name')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('status') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="email">Status:</label>
                        <div class="col-sm-9 col-md-9">
                            <select required="" class="form-control" name="status">
                                <option <?php if($shipping_methods->status == 1): ?> selected <?php endif; ?> value="1">Active</option>
                                <option <?php if($shipping_methods->status == 0): ?> selected <?php endif; ?> value="0">Not Active</option>
                            </select>
                            <?php if($errors->has('status')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('status')); ?></strong>
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