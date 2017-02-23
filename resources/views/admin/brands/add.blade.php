@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Brand
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form action="{{ route('brands.store') }}" method="post" enctype="multipart/form-data">     
            {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label">Brand Name</label>
                        <input class="form-control" name="name" value="">
                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('brand_picture') ? ' has-error' : '' }}">
                        <label class="control-label">Brand Image</label>
                        <input type="file" name="brand_picture">
                        @if ($errors->has('brand_picture'))
                        <span class="help-block">
                            <strong>{{ $errors->first('brand_picture') }}</strong>
                        </span>
                        @endif
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 text-center">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Add</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection