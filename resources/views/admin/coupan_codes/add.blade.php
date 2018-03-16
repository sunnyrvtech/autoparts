@extends('admin/layouts.master')
@section('content')
@push('stylesheet')
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />
@endpush
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Coupon Code
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('coupon_code.store')}}">
            {{ csrf_field()}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('coupon_name') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="coupon_name">Coupon Name:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" name="coupon_name" class="form-control" placeholder="Coupon Name">
                            @if ($errors->has('coupon_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('coupon_name')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('coupon_type') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="coupon_type">Coupon Type:</label>
                        <div class="col-sm-9 col-md-9">
                            <select  required="" name="coupon_type" class="form-control">
                                <option value="all_products">All Products</option>
                                <option value="per_product">Choose Product</option>
                            </select>
                            @if ($errors->has('coupon_type'))
                            <span class="help-block">
                                <strong>{{ $errors->first('coupon_type')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group product_sku" style="display:none;">
                        <label class="col-sm-3 col-md-3 control-label" for="product_sku">Product Sku's:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text"  name="product_sku" data-role="tagsinput" class="form-control" placeholder="Enter multiple product sku">
                        </div>  
                    </div>
                    <div class="form-group {{ $errors->has('code') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="code">Coupon Code:</label>
                        <div class="col-sm-6 col-md-6">
                            <input required="" type="text"  name="code" class="form-control" placeholder="Coupon Code">
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
                    <div class="form-group {{ $errors->has('discount') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="discount">Discount:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text"  name="discount" class="form-control" placeholder="Discount">
                            @if ($errors->has('discount'))
                            <span class="help-block">
                                <strong>{{ $errors->first('discount')}}</strong>
                            </span>
                            @endif
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
<script src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
   $(document).on('change','select[name="coupon_type"]',function(){
       if($(this).val() == 'all_products'){
           $(".product_sku").hide();
       }else{
           $(".product_sku").show();
       }
   }); 
});
</script>
@endpush

