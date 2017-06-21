<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add Warehouse Store
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo e(route('warehouses.store')); ?>">
            <?php echo e(csrf_field()); ?>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group <?php echo e($errors->has('store_name') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="store_name">Store Name:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text" name="store_name"  class="form-control" placeholder="Store Name">
                            <?php if($errors->has('store_name')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('store_name')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="email">Email:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="email" name="email"  class="form-control" placeholder="Email Address">
                            <?php if($errors->has('email')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('address') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="address">Address:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" name="address" class="form-control" placeholder="Address">
                            <?php if($errors->has('address')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('address')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('country') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="country">Country:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text"  name="country" class="form-control" placeholder="Country">
                            <?php if($errors->has('country')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('country')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('state') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="state">State:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text" name="state"  class="form-control" placeholder="State">
                            <?php if($errors->has('state')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('state')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('city') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="city">City:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text" name="city"  class="form-control" placeholder="City">
                            <?php if($errors->has('city')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('city')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('zip') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="zip">Zip Code:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text" name="zip"  class="form-control" placeholder="Zip Code">
                            <?php if($errors->has('zip')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('zip')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('status') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="email">Status:</label>
                        <div class="col-sm-9 col-md-9">
                            <select required="" class="form-control" name="status">
                                <option value="1">Active</option>
                                <option value="0">Not Active</option>
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