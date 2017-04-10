<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Customer
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo e(route('customers.store')); ?>">
            <?php echo e(csrf_field()); ?>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group <?php echo e($errors->has('first_name') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="first_name">First Name:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" name="first_name" class="form-control" placeholder="First Name">
                            <?php if($errors->has('first_name')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('first_name')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->has('last_name') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="last_name">Last Name:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text"  name="last_name" class="form-control" placeholder="Last Name">
                            <?php if($errors->has('last_name')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('last_name')); ?></strong>
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
                    <div class="form-group <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 col-md-3 control-label" for="email">Password:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="password" name="password"  class="form-control" placeholder="Password">
                            <?php if($errors->has('password')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('password')); ?></strong>
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