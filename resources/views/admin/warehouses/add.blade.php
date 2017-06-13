@extends('admin/layouts.master')
@section('content')
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
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('warehouses.store')}}">
            {{ csrf_field()}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('store_name') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="store_name">Store Name:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text" name="store_name"  class="form-control" placeholder="Store Name">
                            @if ($errors->has('store_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('store_name')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="email">Email:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="email" name="email"  class="form-control" placeholder="Email Address">
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('address') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="address">Address:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" name="address" class="form-control" placeholder="Address">
                            @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('country') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="country">Country:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text"  name="country" class="form-control" placeholder="Country">
                            @if ($errors->has('country'))
                            <span class="help-block">
                                <strong>{{ $errors->first('country')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('state') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="state">State:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text" name="state"  class="form-control" placeholder="State">
                            @if ($errors->has('state'))
                            <span class="help-block">
                                <strong>{{ $errors->first('state')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('city') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="city">City:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text" name="city"  class="form-control" placeholder="City">
                            @if ($errors->has('city'))
                            <span class="help-block">
                                <strong>{{ $errors->first('city')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('zip') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="zip">Zip Code:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text" name="zip"  class="form-control" placeholder="Zip Code">
                            @if ($errors->has('zip'))
                            <span class="help-block">
                                <strong>{{ $errors->first('zip')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('status') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="email">Status:</label>
                        <div class="col-sm-9 col-md-9">
                            <select required="" class="form-control" name="status">
                                <option value="1">Active</option>
                                <option value="0">Not Active</option>
                            </select>
                            @if ($errors->has('status'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status')}}</strong>
                            </span>
                            @endif
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
@endsection