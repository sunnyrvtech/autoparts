@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container">
    <section>
        <div id="breadcrumb" itemprop="breadcrumb" itemscope="itemscope" itemtype="http://www.schema.org/BreadcrumbList">
            <a href="{{ url('/') }}">Home</a>
            <span class="divider"> &gt; </span><span>{{ Request::segment(1) }}</span>
            <span class="divider"> &gt; </span><span>{{ Request::segment(2) }}</span>
        </div>
    </section>
    <?php
    $product_images = json_decode(@$products->product_details->product_images);
    ?>
    <div class="row single-pro-wrp">
        <div class="col-md-6 col-sm-6 cal-width1">
            <div class="product-images">
               <div id="product-image">
                    <span>
                        <img class="img current-image" id="ShowImage" src="{{ URL::asset('/product_images').'/' }}{{ isset($product_images[0])?$product_images[0]:'default.jpg' }}">
                    </span>
                </div>
                <ul class="thumbs">
                    @if($product_images)
                    @foreach($product_images as $val)
                    <li class="current">
                        <a href="javascript:void(0);">
                            <img class="img" src="{{ URL::asset('/product_images').'/'.$val}}">
                        </a>
                    </li>
                    @endforeach
                    @endif
                </ul>
               
            </div>
        </div>
        <div class="col-md-6 col-sm-6 cal-width2">
          
                <div id="product-promo">
                    <h3>{{ $products->product_name }}</h3>
                </div>
            
            <div class="material" elevation="1">
                <div class="product-details-container">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label for="parse_link">Parse Link:</label><span> {{ $products->product_details->parse_link }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label for="vehicle_make">Make:</label><span> {{ @$products->get_vehicle_company->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label for="oem_number">OEM:</label><span> {{ $products->product_details->oem_number }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label for="certification">Certifications:</label><span> {{ $products->product_details->certification }}</span>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label for="warranty">Warranty:</label><span> {{ $products->product_details->warranty }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label for="model">Model:</label><span> {{ @$products->get_vehicle_model->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label for="price">Price:</label><span> ${{ $products->price }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label for="quantity">Available Quantity:</label><span> {{ $products->quantity }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row form-inline">
                        <div class="col-md-12">
                            <form name="cartForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitCart(cartForm.$valid,{{ $products->id }})" novalidate>
                                {{ csrf_field()}}
                                <div class="form-group" ng-class="{ 'has-error' : submitted && cartForm.quantity.$error.required }">
                                    <span ng-show="submitted && cartForm.quantity.$error.required" class="help-block">
                                        <strong>Please select quantity</strong>
                                    </span> 
                                    <label class="control-label" for="product-add-to-cart-quantity">Quantity:</label>
                                    <input size="1" ng-model="cart.quantity" ng-init="cart.quantity=1" class="form-control" name="quantity" required="">
                                    <button class="btn am-orange" ng-click="submitted=true" type="submit" value="submit">
                                        Add To Cart <span class="glyphicon glyphicon-shopping-cart"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="product-details-con">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#productDetails">Product Details</a></li>
                    <li><a data-toggle="tab" href="#vehicleFit">Vehicle Fit</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="productDetails">     
<!--                        <p><span class="am-orange-text">Part Number: <em>AM-2048461716</em></span></p>-->
                        <div class="product-details-body">
                            {!! $products->product_long_description !!}    
                        </div>
                    </div> 
                    <div class="tab-pane" id="vehicleFit">
                        <h4 class="part-replaces-header">Vehicle Fit</h4>
                        {!! $products->vehicle_fit !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $(".current img").hover(function(){
            var url = $(this).attr("src");
            $("#product-image img").attr("src",url);
        });
    });
</script>
@endpush
