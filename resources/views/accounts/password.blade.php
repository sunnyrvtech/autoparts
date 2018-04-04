@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container"><!-- /#content.container -->   
    <div class="my-account">
         @include('accounts.sidebar') 

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-panel" id="change-password">
                    <div class="col-xs-12 col-sm-9 col-md-6 col-lg-6 colsm">
                        <div class="row colsm-row">
                            <h3>Change Your Password:</h3>
                            <hr class="colorgraph">
                            <form class="form-horizontal" name="passwordForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitChangePassword(passwordForm.$valid)" novalidate>
                                <input type='text' style="display:none;">
                                <input type='password' style="display:none;">
                                {{ csrf_field()}}
                                <div class="form-group" ng-class="{ 'has-error' : passwordForm.current_password.$invalid && !passwordForm.current_password.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="currentPassword">Current Password:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="password" name="current_password" required="" ng-model="password.current_password" class="form-control" placeholder="Current Password">
                                        <span ng-show="passwordForm.current_password.$invalid && !passwordForm.current_password.$pristine" class="help-block">
                                            <strong>Please enter current password.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : passwordForm.password.$invalid && !passwordForm.password.$pristine }">
                                    <label class="col-sm-3 col-md-3 control-label" for="password">New Password:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="password" name="password" required="" ng-model="password.password" class="form-control" placeholder="New Password">
                                        <span ng-show="passwordForm.password.$invalid && !passwordForm.password.$pristine" class="help-block">
                                            <strong>Please enter new password.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="form-group" ng-class="{ 'has-error' : passwordForm.confirm_password.$invalid && !passwordForm.confirm_password.$pristine || password.password !== password.confirm_password }">
                                    <label class="col-sm-3 col-md-3 control-label" for="confirm_password">Confirm Password:</label>
                                    <div class="col-sm-9 col-md-9">
                                        <input type="password" name="confirm_password" required="" ng-model="password.confirm_password" class="form-control" placeholder="Confirm Password">
                                        <span ng-show="password.password !== password.confirm_password" class="help-block">
                                            <strong>Password and confirm password should be same.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="row1">
                                    <button type="submit" ng-disabled="password.password !== password.confirm_password" class="btn am-orange btn-block btn-lg">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>
</div>
@endsection
