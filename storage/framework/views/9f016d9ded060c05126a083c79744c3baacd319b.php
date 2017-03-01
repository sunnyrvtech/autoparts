<?php $__env->startSection('content'); ?>
<div class="container animated slideInDown"><!-- /#content.container -->    
    <div class="row">
        <h2>Please Login or Register <small>Welcome Back to Auto Light House!</small></h2>
        <hr class="colorgraph">
        <div class="col-xs-12 col-md-6">
            <form name="loginForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitLogin(loginForm.$valid)" novalidate>
                <?php echo e(csrf_field()); ?>

                <h2>Login In <small>It's free and always will be.</small></h2>
                <hr class="colorgraph">
                <div class="form-group" ng-class="{ 'has-error' : loginForm.email.$invalid && !loginForm.email.$pristine }">
                    <input type="email" name="email" required="" ng-model="user.email" class="form-control input-lg" placeholder="Email Address" tabindex="3">
                    <span ng-show="loginForm.email.$invalid && !loginForm.email.$pristine" class="help-block">
                        <strong>Please enter valid email.</strong>
                    </span> 
                </div>
                <div class="form-group" ng-class="{ 'has-error' : loginForm.password.$invalid && !loginForm.password.$pristine }">
                    <input type="password" name="password" required="" ng-model="user.password"  class="form-control input-lg" placeholder="Password" tabindex="4">
                    <span ng-show="loginForm.password.$invalid && !loginForm.password.$pristine" class="help-block">
                        <strong>Please enter password.</strong>
                    </span> 
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><button type="submit" class="btn btn-success btn-block btn-lg">Sign In</button></div>
                </div>
            </form>
        </div>
        <div class="col-xs-12 col-md-6">
            <form role="form">
                <h2>Register<small></small></h2>
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="first_name" required=""  id="first_name" class="form-control input-lg" placeholder="First Name" tabindex="1">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="last_name" required=""  id="last_name" class="form-control input-lg" placeholder="Last Name" tabindex="2">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="email" name="email" required=""  id="email" class="form-control input-lg" placeholder="Email Address" tabindex="4">
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="password" name="password" required=""  id="password" class="form-control input-lg" placeholder="Password" tabindex="5">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="password" name="password_confirmation" required=""  id="password_confirmation" class="form-control input-lg" placeholder="Confirm Password" tabindex="6">
                        </div>
                    </div>
                </div>
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><input type="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>