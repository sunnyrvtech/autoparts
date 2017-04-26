@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container">
    <div class="well well-sm">
        <div class="row">
        <div class="col-md-4">
            <strong>Category Title:-</strong>
            <a href="#" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list"></span>List</a> 
            <a href="#" id="grid" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th"></span>Grid</a>
        </div>
        <div class="col-md-4">
            <label class="col-sm-3 col-md-3 control-label">Sort By:-</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" name="sortBy"><option>Highest Price</option><option>Lowest Price</option></select>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-9">
        <div id="products-content-area" class="row list-group">

            @foreach($products as $key=> $value)
            <div class="item  col-xs-4 col-lg-4 grid-group-item list-group-item">
                <div class="thumbnail">
                    <img class="group list-group-image" src="{{ URL::asset('/images/product1.jpg') }}" alt="" />
                    <div class="caption">
                        <h4 class="group inner list-group-item-heading">{{ $value->getProducts->product_name }}</h4>
                        <h4 class="group inner grid-group-item-heading">{{ str_limit($value->getProducts->product_name, $limit = 43, $end = '...') }}</h4>
                        <p class="group inner grid-group-item-text">
                            {{ str_limit($value->getProducts->product_long_description, $limit = 50, $end = '...') }}
                        </p>
                        <p class="group inner list-group-item-text">
                            {{ $value->getProducts->product_long_description }}
                        </p>
                        <div class="row">
                            <p class="lead">${{ $value->getProducts->price }}</p>
                        </div>
                    </div>
                </div>
                <div class="product-card__overlay">
                    <a class="btn am-black product-card__overlay-btn ">View <span class="glyphicon glyphicon-eye-open"></span></a>
                    <a class="btn am-orange product-card__overlay-btn" href="javascript:void(0);">Add to cart <span class="glyphicon glyphicon-shopping-cart"></span></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="item col-md-3">
        <div class="panel-group" id="search-filter-results-accordion" role="tablist">
            <div class="panel panel-default search-filter-ymm">
                <div class="panel-heading" role="tab" id="search-ymm-heading-plain">
                    <h4 class="panel-title">
                        <a aria-expanded="true" class="accordion-toggle" data-toggle="collapse" rel="nofollow" role="button" href="#search-ymm-collapse-plain" aria-controls="search-ymm-collapse-plain">
                            <span>Select Your Vehicle</span>
                            <span aria-hidden="true" class="pull-right glyphicon glyphicon-chevron-down hidden-sm hidden-xs"></span>
                            <span aria-hidden="true" class="pull-right glyphicon glyphicon-chevron-up hidden-sm hidden-xs"></span>
                        </a>
                    </h4>
                </div>
                <div class="panel-collapse collapse in" role="tabpanel" aria-labelledby="search-ymm-heading-plain" id="search-ymm-collapse-plain" aria-expanded="true" style="">
                    <div class="panel-body">
                        <form class="form-horizontal filter-results-search-ymm-form" role="form">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="btn-group year-select ymm-select">
                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
                                            <span class="select-text">2011</span><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu scrollable-menu"><li><a role="button">Select Vehicle Year</a></li></ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="btn-group make-select ymm-select">
                                        <button aria-expanded="false" aria-haspopup="true" class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
                                            <span class="select-text">Buick</span><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu scrollable-menu">
                                            <li><a data-value="0" role="button">Select Vehicle Make</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="btn-group model-select ymm-select">
                                        <button aria-expanded="false" aria-haspopup="true" class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
                                            <span class="select-text">Century</span><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu scrollable-menu">
                                            <li><a role="button">Select Vehicle Model</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-sm material pull-right ymm-submit" elevation="1" type="submit">Search</button>
                            <br class="clearfix">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pagination_main_wrapper">{{ $products->links() }}</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '#list', function (event) {
            event.preventDefault();
            $('#products-content-area .item').addClass('list-group-item');
        });

        $('body').on('click', '#grid', function (event) {
            event.preventDefault();
            $('#products-content-area .item').removeClass('list-group-item');
            $('#products-content-area .item').addClass('grid-group-item');
        });

        $(document).on('mouseenter', '#products-content-area .item', function () {
            $(this).find(".product-card__overlay").addClass("fadeInDown animated");
        });
        $(document).on('mouseleave', '#products-content-area .item', function () {
            $(this).find(".product-card__overlay").removeClass("fadeInDown");
        });
        $('body').on('click', '.pagination a', function (e) {
            e.preventDefault();
            angular.element(this).scope().getProductByPage($(this).attr('href'));
        });
    });
</script>
@endpush
