<?php $__env->startSection('content'); ?>
<div class="container animated slideInDown"><!-- /#content.container -->    
    <div class="row">
        <h2>Welcome Back to <small>Auto Light House!</small></h2>
        <hr class="colorgraph">
        <div class="row text-center">
            <div class="col-xs-12 col-md-6 col-centered divcontainer">
                <form name="loginForm" role="form" action="javascript:void(0);" ng-submit="submitLogin(loginForm.$valid)" novalidate>
                    <?php echo e(csrf_field()); ?>

                    <h2>Login In <small>It's free and always will be.</small></h2>
                    <hr class="colorgraph">
                    <div class="form-group" ng-class="{ 'has-error' : loginForm.email.$invalid && !loginForm.email.$pristine }">
                        <input type="email" name="email" required="" ng-model="login.email" class="form-control input-lg" placeholder="Email Address" tabindex="3">
                        <span ng-show="loginForm.email.$invalid && !loginForm.email.$pristine" class="help-block">
                            <strong>Please enter valid email.</strong>
                        </span> 
                    </div>
                    <div class="form-group" ng-class="{ 'has-error' : loginForm.password.$invalid && !loginForm.password.$pristine }">
                        <input type="password" name="password" required="" ng-model="login.password"  class="form-control input-lg" placeholder="Password" tabindex="4">
                        <span ng-show="loginForm.password.$invalid && !loginForm.password.$pristine" class="help-block">
                            <strong>Please enter password.</strong>
                        </span> 
                    </div>
                    <!--                <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>-->
                    <!--<div class="col-md-12">-->
                    <div class="form-group text-right">
                        <a class="btn btn-link" ng-click="forgotPassword()" href="javascript:void(0);">
                            Forgot Your Password?
                        </a>
                    </div>
                    <!--</div>-->

                    <hr class="colorgraph">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>