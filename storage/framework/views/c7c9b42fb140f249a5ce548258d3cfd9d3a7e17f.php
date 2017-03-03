<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Sub Category
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form action="<?php echo e(route('subcategories.store')); ?>" method="post" enctype="multipart/form-data">     
            <?php echo e(csrf_field()); ?>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group <?php echo e($errors->has('category_id') ? ' has-error' : ''); ?>">
                        <label class="control-label">Category Name</label>
                        <?php echo e(Form::select('category_id', $categories,null,['class' => 'form-control'])); ?>

                        <?php if($errors->has('category_id')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('category_id')); ?></strong>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                        <label class="control-label">Sub Category Name</label>
                        <input class="form-control" name="name" value="">
                        <?php if($errors->has('name')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('name')); ?></strong>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group <?php echo e($errors->has('category_picture') ? ' has-error' : ''); ?>">
                        <label class="control-label">Category Image</label>
                        <input type="file" name="category_picture">
                        <?php if($errors->has('category_picture')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('category_picture')); ?></strong>
                        </span>
                        <?php endif; ?>
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