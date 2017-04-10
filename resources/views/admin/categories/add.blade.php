@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12 form-group">
            <h1 class="page-header">
                Add New Category
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form role="form" class="form-horizontal" action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field()}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-sm-3 col-md-3 control-label" for="name">Category Name:</label>
                        <div class="col-sm-9 col-md-9">
                            <input class="form-control" required="" name="name" placeholder="Category Name">
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-md-3 control-label" for="category_picture">Category Image:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="file" name="category_picture" class="preview-image">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group text-center" id="previewImage">
                            <span id="image_prev">

                            </span>
                        </div>
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