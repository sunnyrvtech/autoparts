@extends('layouts.app')

@section('content')
<div class="container animated slideInDown"><!-- /#content.container -->    
    <div class="row">
        <h2>Welcome Back to <small>Auto Light House!</small></h2>
        <hr class="colorgraph">
        <div class="row text-center">
            <div class="col-xs-12 col-md-6 col-centered">
                <form name="registerForm" role="form" role="form" method="POST" action="javascript:void(0);" ng-submit="submitRegister(registerForm.$valid)" novalidate>
                    <input type='text' style="display:none;">
                    <input type='password' style="display:none;">
                    {{ csrf_field()}}
                    <h2>Register <small>It's free and always will be.</small></h2>
                    <hr class="colorgraph">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group" ng-class="{ 'has-error' : registerForm.first_name.$invalid && !registerForm.first_name.$pristine }">
                                <input type="text" name="first_name" required="" ng-model="register.first_name"  id="first_name" class="form-control input-lg" placeholder="First Name" tabindex="1">
                                <span ng-show="registerForm.first_name.$invalid && !registerForm.first_name.$pristine" class="help-block">
                                    <strong>Please enter first name.</strong>
                                </span> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group" ng-class="{ 'has-error' : registerForm.last_name.$invalid && !registerForm.last_name.$pristine }">
                                <input type="text" name="last_name" required=""  id="last_name" ng-model="register.last_name" class="form-control input-lg" placeholder="Last Name" tabindex="2">
                                <span ng-show="registerForm.last_name.$invalid && !registerForm.last_name.$pristine" class="help-block">
                                    <strong>Please enter last name.</strong>
                                </span> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group" ng-class="{ 'has-error' : registerForm.email.$invalid && !registerForm.email.$pristine }">
                        <input type="email" name="email" required=""  id="email" ng-model="register.email" class="form-control input-lg" placeholder="Email Address" tabindex="4">
                        <span ng-show="registerForm.email.$invalid && !registerForm.email.$pristine" class="help-block">
                            <strong>Please enter valid email.</strong>
                        </span> 
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group" ng-class="{ 'has-error' : registerForm.password.$invalid && !registerForm.password.$pristine }">
                                <input type="password" name="password" required="" ng-model="register.password"  id="password" class="form-control input-lg" placeholder="Password" tabindex="5">
                                <span ng-show="registerForm.password.$invalid && !registerForm.password.$pristine" class="help-block">
                                    <strong>Please enter password.</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group" ng-class="{ 'has-error' : registerForm.password_confirmation.$invalid && !registerForm.password_confirmation.$pristine || register.password !== register.password_confirmation }">
                                <input type="password" name="password_confirmation" required="" ng-model="register.password_confirmation" id="password_confirmation" class="form-control input-lg" placeholder="Confirm Password" tabindex="6">
                                <span ng-show="register.password !== register.password_confirmation" class="help-block">
                                    <strong>Password and confirm password should be same.</strong>
                                </span> 
                            </div>
                        </div>
                    </div>
                    <hr class="colorgraph">
                    <div class="row">
                        <input type="submit" ng-disabled="register.password !== register.password_confirmation" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
