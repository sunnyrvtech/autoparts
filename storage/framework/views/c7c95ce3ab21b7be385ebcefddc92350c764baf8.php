<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Brand
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form role="form" class="form-horizontal" action="<?php echo e(route('brands.store')); ?>" method="post" enctype="multipart/form-data">     
            <?php echo e(csrf_field()); ?>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label">Brand Name:-</label>
                        <div class="col-sm-9 col-md-9">
                            <input class="form-control" name="name" value="">
                            <?php if($errors->has('name')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('name')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('brand_picture') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label">Brand Image:-</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="file" name="brand_picture" class="preview-image">
                            <?php if($errors->has('brand_picture')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('brand_picture')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group text-center" id="previewImage">
                            <span id="image_prev">

                            </span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 text-center">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Add</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>