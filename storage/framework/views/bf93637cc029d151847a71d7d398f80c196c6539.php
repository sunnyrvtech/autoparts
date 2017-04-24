<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Sub Sub Category
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <?php echo e(Form::open(array('route' => 'subsubcategories.store', 'class' => 'form-horizontal','method'=>'post'))); ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group <?php echo e($errors->has('sub_category_id') ? ' has-error' : ''); ?>">
                    <label class="col-sm-3 col-md-3 control-label" for="sub_category_id">Sub Category Name:</label>
                    <div class="col-sm-9 col-md-9">  
                        <?php echo e(Form::select('sub_category_id', $sub_categories,null,['class' => 'form-control'])); ?>

                        <?php if($errors->has('sub_category_id')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('sub_category_id')); ?></strong>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group <?php echo e($errors->has('vehicle_company_id') ? ' has-error' : ''); ?>">
                    <label class="col-sm-3 col-md-3 control-label" for="vehicle_company_id">Vehicle Name:</label>
                    <div class="col-sm-9 col-md-9">  
                        <?php echo e(Form::select('vehicle_company_id', $vehicle_companies,null,['class' => 'form-control'])); ?>

                        <?php if($errors->has('vehicle_company_id')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('vehicle_company_id')); ?></strong>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 text-center">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Add</button>
            </div>
        </div>
        <?php echo e(Form::close()); ?>

    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>