<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Update Sub Category
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <?php echo e(Form::open(array('route' => ['subcategories.update',$sub_categories->id],'method'=>'PUT', 'class' => 'form-horizontal','enctype'=>'multipart/form-data'))); ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group <?php echo e($errors->has('category_id') ? ' has-error' : ''); ?>">
                    <label class="col-sm-3 col-md-3 control-label" for="category_id">Category Name:</label>
                    <div class="col-sm-9 col-md-9">  
                        <?php echo e(Form::select('category_id', $categories,$sub_categories->category_id,['class' => 'form-control'])); ?>

                        <?php if($errors->has('category_id')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('category_id')); ?></strong>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                    <label class="col-sm-3 col-md-3 control-label" for="name">Sub Category Name:</label>
                    <div class="col-sm-9 col-md-9">  
                        <input class="form-control" name="name" value="<?php echo e($sub_categories->name); ?>">
                        <?php if($errors->has('name')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('name')); ?></strong>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group <?php echo e($errors->has('category_picture') ? ' has-error' : ''); ?>">
                    <label class="col-sm-3 col-md-3 control-label" for="category_picture">Category Image:</label>
                    <div class="col-sm-9 col-md-9">  
                        <input type="file" name="category_picture" class="preview-image">
                        <?php if($errors->has('category_picture')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('category_picture')); ?></strong>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group text-center" id="previewImage">
                        <span id="image_prev">
                            <?php if(!empty($sub_categories->category_image)): ?>
                            <img width="200px" src="<?php echo e(URL::asset('/category').'/'.$sub_categories->category_image); ?>">
                            <?php endif; ?>
                        </span>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 text-center">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Update</button>
            </div>
        </div>
        <?php echo e(Form::close()); ?>

    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>