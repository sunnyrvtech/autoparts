@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Vehicle
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form role="form" class="form-horizontal" action="{{ route('vehicle_model.update',$vehicle_model->id)}}" method="post">     
            <input name="_method" value="PUT" type="hidden">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-sm-3 col-md-3 control-label">Name</label>
                        <div class="col-sm-9 col-md-9">
                        <input class="form-control" name="name" value="{{ $vehicle_model->name }}">
                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
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
        </form>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection