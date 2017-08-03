@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Coupan Code
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('coupan_code.store')}}">
            {{ csrf_field()}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('coupan_type') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="coupan_type">Coupan Type:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" name="coupan_type" class="form-control" placeholder="Coupan Type">
                            @if ($errors->has('coupan_type'))
                            <span class="help-block">
                                <strong>{{ $errors->first('coupan_type')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('code') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="code">Coupan Code:</label>
                        <div class="col-sm-6 col-md-6">
                            <input required="" type="text"  name="code" class="form-control" placeholder="Coupan Code">
                            @if ($errors->has('code'))
                            <span class="help-block">
                                <strong>{{ $errors->first('code')}}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <button type="button" class="btn btn-info generate_code">Generate</button>
                        </div>    
                    </div>
                    <div class="form-group {{ $errors->has('usage') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="usage">Usage:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text" name="usage"  class="form-control" placeholder="Usage">
                            @if ($errors->has('usage'))
                            <span class="help-block">
                                <strong>{{ $errors->first('usage')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('expiration_date') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="expiration_date">Expiration Date:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text" name="expiration_date"  class="form-control datepicker1" placeholder="Expiration Date">
                            @if ($errors->has('expiration_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('expiration_date')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('status') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="status">Status:</label>
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
@push('scripts')
@endpush

