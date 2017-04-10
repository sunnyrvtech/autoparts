<?php $__env->startSection('content'); ?>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row form-group">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Update Category
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <form role="form" class="form-horizontal" action="<?php echo e(route('categories.update',$categories->id)); ?>" method="post" enctype="multipart/form-data">
                <input name="_method" value="PUT" type="hidden">
                <?php echo e(csrf_field()); ?>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                            <label class="col-sm-3 col-md-3 control-label" for="name">Category Name:</label>
                            <div class="col-sm-9 col-md-9">
                                <input class="form-control" required="" name="name" value="<?php echo e($categories->name); ?>" placeholder="Category Name">
                                <?php if($errors->has('name')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('name')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-3 control-label" for="category_picture">Category Image:</label>
                            <div class="col-sm-9 col-md-9">
                                <input type="file" name="category_picture" class="preview-image">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group text-center" id="previewImage">
                                <span id="image_prev">
                                    <?php if(!empty($categories->category_image)): ?>
                                    <img width="200px" src="<?php echo e(URL::asset('/category').'/'.$categories->category_image); ?>">
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
            </form>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>