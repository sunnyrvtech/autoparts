@extends('admin/layouts.master')
@push('stylesheet')
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />
@endpush
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add Shipping Rates
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('shipping_rates.store')}}">
            {{ csrf_field()}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('country_id') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="name">Name:</label>
                        <div class="col-sm-9 col-md-9">
                            <select name="country_id" required="" id="country_id"  class="form-control">
                                <option value="">Please select country</option>
                                @foreach($countries as $val)
                                <option value="{{ $val->id}}">{{ $val->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country_id'))
                            <span class="help-block">
                                <strong>{{ $errors-> first('country_id')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('ship_type') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="name">Ship Type:</label>
                        <div class="col-sm-9 col-md-9">
                            <select name="ship_type" required="" class="form-control">
                                <option value="zip_by">Zip By</option>
                                <option value="weight_by">Weight By</option>
                            </select>
                            @if ($errors->has('country_id'))
                            <span class="help-block">
                                <strong>{{ $errors-> first('country_id')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="zip-content">
                        <div class="form-group {{ $errors->has('zip_code') ? ' has-error' : ''}}">
                            <label class="col-sm-3 col-md-3 control-label" for="zip_code">Zip Code:</label>
                            <div class="col-sm-9 col-md-9">
                                <input type="text" class="form-control" data-role="tagsinput"  name="zip_code" placeholder="Enter multiple zip code">
                            </div>
                        </div>
                    </div>
                    <div class="weight-content" style="display: none;">
                        <div class="form-group {{ $errors->has('low_weight') ? ' has-error' : ''}}">
                            <label class="col-sm-3 col-md-3 control-label" for="low_weight">Low Weight:</label>
                            <div class="col-sm-9 col-md-9">
                                <input type="text" name="low_weight" class="form-control" placeholder="Low Weight">
                                @if ($errors->has('low_weight'))
                                <span class="help-block">
                                    <strong>{{ $errors-> first('low_weight')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('high_weight') ? ' has-error' : ''}}">
                            <label class="col-sm-3 col-md-3 control-label" for="high_weight">High Weight:</label>
                            <div class="col-sm-9 col-md-9">
                                <input type="text" name="high_weight" class="form-control" placeholder="High Weight">
                                @if ($errors->has('high_weight'))
                                <span class="help-block">
                                    <strong>{{ $errors-> first('high_weight')}}</strong>
                                </span> 
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('price') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="price">Price:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" name="price" required="" class="form-control" placeholder="Price">
                            @if ($errors->has('price'))
                            <span class="help-block">
                                <strong>{{ $errors-> first('price')}}</strong>
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
<script src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
   $(document).on('change','select[name="ship_type"]',function(){
       if($(this).val() == 'zip_by'){
           $(".zip-content").show();
           $(".weight-content").hide();
       }else{
           $(".zip-content").hide();
           $(".weight-content").show();
       }
   }); 
});
</script>
@endpush