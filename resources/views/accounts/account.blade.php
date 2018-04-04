@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container"><!-- /#content.container -->   
    <div class="my-account">
        @include('accounts.sidebar') 
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-panel">
                    <div class="col-xs-12 col-sm-9 col-md-6 col-lg-6 colsm">
                        <div class="row colsm-row">
                            <h3>Update Account Details:</h3>
                            <hr class="colorgraph">
                            <form name="profileForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitProfile(profileForm.$valid)" novalidate>
                                {{ csrf_field()}}
                                <div class="row1">
                                    <div class="form-group" ng-class="{ 'has-error' : profileForm.first_name.$invalid && !profileForm.first_name.$pristine }">
                                        <input type="text" name="first_name" required="" ng-model="profile.first_name" ng-init="profile.first_name='{{ $users->first_name }}'" class="form-control" placeholder="First Name">
                                        <span ng-show="profileForm.first_name.$invalid && !profileForm.first_name.$pristine" class="help-block">
                                            <strong>Please enter first name.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="row1">
                                    <div class="form-group" ng-class="{ 'has-error' : profileForm.last_name.$invalid && !profileForm.last_name.$pristine }">
                                        <input type="text" name="last_name" required="" ng-model="profile.last_name" ng-init="profile.last_name='{{ $users->last_name }}'" class="form-control" placeholder="Last Name">
                                        <span ng-show="profileForm.last_name.$invalid && !profileForm.last_name.$pristine" class="help-block">
                                            <strong>Please enter last name.</strong>
                                        </span> 
                                    </div>
                                </div>
                                <div class="row1">
                                    <div class="form-group" style="border:1px solid #ccc;">
                                        <div style="position:relative;padding: 10px;">
                                            <a class="btn btn-primary" href="javascript:void(0);">
                                                    Choose File...
                                                    <input name="profile_image" id="profile_image" style="position:absolute;z-index:2;top:0;left:0;opacity:0;background-color:transparent;color:transparent;" name="profile_image" size="40" onchange="$('#upload-file-info').html($(this).val());angular.element(this).scope().setFile(this)" type="file">
                                            </a>
                                            <span class="label label-info" id="upload-file-info"></span>
                                        </div>
                                      </div>
                                </div>
                                <div class="row1">
                                    <div class="form-group text-center" id="previewImage">
                                           @if(!empty($users->user_image))
                                                <img width="200px" src="{{ URL::asset('/user_images').'/'.$users->user_image }}">
                                           @endif
                                    </div>
                                </div>
                                <div class="row1">
                                    <button type="submit" class="btn am-orange btn-block btn-lg">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection