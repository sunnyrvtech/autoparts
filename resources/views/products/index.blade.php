@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container">
    <section>
        <div id="breadcrumb" itemprop="breadcrumb" itemscope="itemscope" itemtype="http://www.schema.org/BreadcrumbList">
            <a href="{{ url('/') }}">Home</a>
            <span class="divider"> &gt; </span><span>{{ Request::segment(1) }}</span>
        </div>
    </section>
     @if(!empty($products->toArray()['data']))
            <div class="well well-sm cate">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <strong>Category Title:-</strong>
                        <a href="#" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list"></span>List</a> 
                        <a href="#" id="grid" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th"></span>Grid</a>
                    </div>
                    <div class="col-md-4 col-sm-6 sort pull-right">
                        <div class="row">
                        <label class="col-sm-3 control-label">Sort By:-</label>
                        <div class="col-sm-9">
                            <form method="get">
                                @if(Request::get('page') != null)
                                <input type="hidden" name='page' value="{{ Request::get('page') }}">
                                @endif
                                <select class="form-control" name="sort_by" onchange="this.form.submit()">
                                    <option value="">Default Sorting</option>
                                    <option @if(Request::get('sort_by') == 'high') selected @endif value="high">Highest Price</option>
                                    <option @if(Request::get('sort_by') == 'low') selected @endif value="low">Lowest Price</option>
                                </select>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
     @endif
  <div class="row cat-list">
    <div class="col-md-9">
        <div id="products-content-area" class="row list-group">
            <?php
            $brand_array = [];
            $vehicle_company_array = [];
            $vehicle_model_array = [];

            $minYear = date('Y', strtotime('-50 year'));
            $maxYear = date('Y', strtotime('+1 year'));
            // set start and end year range
            $yearArray = range($maxYear, $minYear);
              function my_sort($a, $b) {
                    if (Request::get('sort_by') == 'high') {
                        return ($a['get_products']['price'] > $b['get_products']['price']) ? -1 : 1;
                    } else {
                        return ($a['get_products']['price'] < $b['get_products']['price']) ? -1 : 1;
                    }
                }

                if (Request::get('sort_by') != null) {
                    $pro_arr = $products->toArray();
                    usort($pro_arr['data'], 'my_sort');
                    $prod_data = $pro_arr['data'];
                } else {
                    $prod_data = $products->toArray();
                    $prod_data = $prod_data['data'];
                }
                
            ?>
            @forelse($prod_data as $key=> $value)
            <?php
            
            //this is used to create brand filter 
            if (!empty($value['get_products']['brand_id'])) {
                $brand_array[$key]['id'] = $value['get_products']['brand_id'];
                $brand_array[$key]['name'] = isset($value['get_products']['get_brands']['name']) ? $value['get_products']['get_brands']['name'] : '';
            }
            if (!empty($value['get_products']['vehicle_make_id'])) {
                $vehicle_company_array[$key]['id'] = $value['get_products']['vehicle_make_id'];
                $vehicle_company_array[$key]['name'] = isset($value['get_products']['get_vehicle_company']['name']) ? $value['get_products']['get_vehicle_company']['name'] : '';
            }
            if (!empty($value->get_products->vehicle_model_id)) {
                $vehicle_model_array[$key]['id'] = $value['get_products']['vehicle_model_id'];
                $vehicle_model_array[$key]['name'] = isset($value['get_products']['get_vehicle_model']['name']) ? $value['get_products']['get_vehicle_model']['name'] : '';
            }
            $product_images = json_decode($value['get_products']['product_details']['product_images']);
            ?>
            <div class="item col-xs-4 col-lg-4 list-group-item">
               <div class="list-wrp grid-wrp">
                <div class="thumbnail">
                   <div class="img-wrp">
                    <img width="250" height="250" class="group list-group-image" src="{{ URL::asset('/product_images').'/' }}{{ isset($product_images[0])?$product_images[0]:'default.jpg' }}" alt="" />
                    </div>
                    <div class="caption">
                        <h4 class="group inner list-group-item-heading">{{ $value['get_products']['product_name'] }}</h4>
                        <h4 class="group inner grid-group-item-heading">{{ str_limit($value['get_products']['product_name'], $limit = 43, $end = '...') }}</h4>
                        <div class="group inner grid-group-item-text">
                            {!! str_limit($value['get_products']['product_long_description'], $limit = 50, $end = '...') !!}
                        </div>
                        <div class="group inner list-group-item-text">
                            {!! $value['get_products']['product_long_description'] !!}
                        </div>
                        <div class="row">
                            <p class="lead">${{ $value['get_products']['price'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="product-card__overlay">
                    <a class="btn am-black product-card__overlay-btn" href="{{ URL('products').'/'.$value['get_products']['product_slug'] }}">View <span class="glyphicon glyphicon-eye-open"></span></a>
                    <a class="btn am-orange product-card__overlay-btn" href="javascript:void(0);" ng-click="submitCart(true,{{ $value['get_products']['id'] }})">Add to cart <span class="glyphicon glyphicon-shopping-cart"></span></a>
                </div>
                </div>
            </div>
            @empty
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        <strong>Sorry,</strong> no products found!
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    @if(!empty($products->toArray()['data']))
    <div class="item col-md-3">
        <div class="panel-group" id="search-filter-results-accordion" role="tablist">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="search-ymm-heading-plain">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" rel="nofollow" role="button" href="#search-ymm-collapse-plain">
                            <span>Select Your Vehicle</span>
                            <span class="pull-right glyphicon glyphicon-chevron-down hidden-sm hidden-xs"></span>
                            <span class="pull-right glyphicon glyphicon-chevron-up hidden-sm hidden-xs"></span>
                        </a>
                    </h4>
                </div>
                <div class="panel-collapse collapse in" role="tabpanel" id="search-ymm-collapse-plain" style="">
                    <div class="panel-body">
                         <form id="am-ymm-home-form" class="form-horizontal" role="form">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="btn-group year-select ymm-select">
                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
                                            <span id="vehicle_year" class="select-text">Select Vehicle Year</span><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu scrollable-menu">
                                            <li><a role="button">Select Vehicle Year</a></li>
                                            @foreach($yearArray as $val_year)
                                            <li><a data-id="{{ $val_year }}" data-method="vehicle_year" data-url="{{ url('products/vehicle') }}" role="button">{{ $val_year }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="btn-group make-select ymm-select">
                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
                                            <span id="vehicle_make" class="select-text">Select Vehicle Make</span><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu scrollable-menu">
                                            <li><a role="button">Select Vehicle Make</a></li>
                                            <li ng-repeat="x in result_vehicle_company"><a data-id="<%x.get_vehicle_company.id%>" data-method="vehicle_company" data-url="{{ url('products/vehicle_model') }}" role="button"><%x.get_vehicle_company.name%></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="btn-group model-select ymm-select">
                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
                                            <span id="vehicle_model" class="select-text">Select Vehicle Model</span><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu scrollable-menu">
                                            <li><a role="button">Select Vehicle Model</a></li>
                                            <li ng-repeat="x in result_vehicle_model"><a data-id="<%x.get_vehicle_model.id%>" data-method="vehicle_model"  role="button"><%x.get_vehicle_model.name%></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-sm material pull-right ymm-submit" elevation="1" ng-click="searchProduct()" type="submit">Search</button>
                            <br class="clearfix">
                        </form>
                    </div>
                </div>
                </div>
                <?php
                $filter_array = array(
                    0 => [
                        "title" => "Product Category",
                        "data" => $all_categories
                    ],
                    1 => [
                        "title" => "Brand",
                        "data" => $brand_array
                    ],
                    2 => [
                        "title" => "Vehicle Make",
                        "data" => array_values(array_map("unserialize", array_unique(array_map("serialize", $vehicle_company_array))))
                    ],
                    3 => [
                        "title" => "Vehicle Model",
                        "data" => array_values(array_map("unserialize", array_unique(array_map("serialize", $vehicle_model_array))))
                    ]
                );
                ?>
                @foreach($filter_array as $key=>$value)
                @if(!empty($value['data']))
                <div class="panel panel-default facet-panel">
                    <div class="panel-heading" role="tab" id="search-facet-heading-plain{{$key}}">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" role="button" href="#search-facet-collapse-plain{{$key}}">
                                <span>{{ $value['title'] }}</span>
                                <span class="pull-right glyphicon glyphicon-chevron-down hidden-sm hidden-xs"></span>
                                <span class="pull-right glyphicon glyphicon-chevron-up hidden-sm hidden-xs"></span>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" role="tabpanel" id="search-facet-collapse-plain{{$key}}">
                        <div class="panel-body">
                            <ul>
                                @foreach($value['data'] as $k=>$val)
                                <li>
                                    @if($key !=0)
                                    <label class="checkbox-inline">
                                        <!--<input type="checkbox" checked  value="{{ $val['id'] }}"><a class="filter-applied" href="javascript:void(0);">{{ $val['name'] }}</a>-->
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                        <a class="@if(Request::input('q') == $val['name'])filter-applied @endif" href="{{ URL('/products/search').'?q='.urlencode($val['name']) }}">{{ $val['name'] }}</a>
                                    </label>
                                    @else
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <a class="@if(Request::segment(1) == $val['slug'])filter-applied @endif" href="{{ url('/'.$val['slug']) }}">{{ $val['name'] }}</a>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
           
        </div>
    </div>
    @endif
    </div>
    <div class="pagination_main_wrapper">{{ $products->links() }}</div>
</div>
@endsection
@push('scripts')
<script src="{{ URL::asset('/js/product.js') }}"></script>
@endpush
