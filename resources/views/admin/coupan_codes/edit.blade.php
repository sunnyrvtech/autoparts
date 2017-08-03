@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Update Coupan Code
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('coupon_code.update',$coupan_codes->id)}}">
            <input name="_method" value="PUT" type="hidden">
            {{ csrf_field()}}
            <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('coupan_type') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="coupan_type">Coupon Type:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" name="coupan_type" value="{{ $coupan_codes->coupan_type }}" class="form-control" placeholder="Coupan Type">
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
                            <input required="" type="text"  name="code" class="form-control" value="{{ $coupan_codes->code }}" placeholder="Coupon Code">
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
                            <input required="" type="text" name="usage"  class="form-control" value="{{ $coupan_codes->usage }}" placeholder="Usage">
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
                            <input required="" type="text" name="expiration_date"  class="form-control datepicker1" value="{{ $coupan_codes->expiration_date }}" placeholder="Expiration Date">
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
                                <option @if($coupan_codes->status == 1) selected @endif value="1">Active</option>
                                <option @if($coupan_codes->status == 0) selected @endif value="0">Not Active</option>
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