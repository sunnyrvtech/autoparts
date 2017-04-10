@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Update Sub Sub Category
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        {{ Form::open(array('route' => ['subsubcategories.update',$subsub_categories->id],'method'=>'PUT', 'class' => 'form-horizontal','enctype'=>'multipart/form-data')) }}
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group {{ $errors->has('sub_category_id') ? ' has-error' : '' }}">
                    <label class="col-sm-3 col-md-3 control-label" for="sub_category_id">Sub Category Name:</label>
                    <div class="col-sm-9 col-md-9">  
                        {{ Form::select('sub_category_id', $sub_categories,$subsub_categories->sub_category_id,['class' => 'form-control']) }}
                        @if ($errors->has('sub_category_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('sub_category_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('vehicle_company_id') ? ' has-error' : '' }}">
                    <label class="col-sm-3 col-md-3 control-label" for="vehicle_company_id">Vehicle Name:</label>
                    <div class="col-sm-9 col-md-9">  
                        {{ Form::select('vehicle_company_id', $vehicle_companies,$subsub_categories->vehicle_company_id,['class' => 'form-control']) }}
                        @if ($errors->has('vehicle_company_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('vehicle_company_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 text-center">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Update</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection