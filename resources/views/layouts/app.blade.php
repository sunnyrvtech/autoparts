<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Auto Light House</title>
        <meta name="description" content="Buy now at Auto-LightHouse! Always Free Shipping. Order by 5 P.M. EST and your order ships same day." />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token()}}">
        <link rel="shortcut icon" href="assets/images/gt_favicon.png">
        <!-- Styles -->
        <link href="{{ URL::asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/css/animate.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/css/style.css') }}" rel="stylesheet">
        @stack('stylesheet')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet" type="text/css" />
        <script>
            window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?>
        </script>
        <script src="{{ URL::asset('/js/app.js') }}"></script>
    </head>
    <body ng-app="autoPartApp" ng-controller="autoPartController">

        <div id="loaderOverlay" ng-show="loading">
            <div class="loader">
                <div class="side"></div>
                <div class="side"></div>
                <div class="side"></div>
                <div class="side"></div>
                <div class="side"></div>
                <div class="side"></div>
                <div class="side"></div>
                <div class="side"></div>
            </div>
        </div>
        <section class="top-header-section">
            <div id="top-header-con">
                <div class="row">
                    <div class="col-md-12">
                        <a href="javascript:void(0);">What do you think of our new website?</a>
                    </div>
                </div>
            </div>
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <button aria-controls="navbar" aria-expanded="false" class="navbar-toggle collapsed" data-target="#navbar" data-toggle="collapse" type="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <a class="mini-cart pull-right hidden-md hidden-lg" id="mobile-mini-cart" href="{{ URL('/cart') }}">
                            <span class="fab-cirle am-bg-dark-blue">
                                <span aria-hidden="true" class="glyphicon glyphicon-shopping-cart"></span>
                            </span>
                            <span class="mini-cart-count" ng-bind="cart_count" ng-init="cart_count='{{ $cart_count }}'"></span>
                            <span class="hidden-xxs"> items in cart:</span>
<!--                            <span class="visible-xxs-inline"> / </span>
                            <span class="mini-cart-total">$0.00</span>-->
                        </a>

                        <a class="navbar-brand" title="Auto-LightHouse" href="{{ url('/')}}"></a>
                    </div>
                    <div class="navbar-collapse collapse" id="navbar">
                        <ul class="nav navbar-nav">
                            <li><a href="{{ URL('/contact-us') }}" title="Email Customer Care"><span aria-hidden="true" class="glyphicon glyphicon-envelope"></span> Ask a Question</a></li>
                            <li><a href="{{ url('/faq')}}" title="Frequently Asked Questions">FAQ</a></li>
                            <li>
                            @if(Auth::check())
                                <a href="{{ URL('/my-account/order')}}" title="Track your order">My Orders</a>
                            @else
                                <a href="javascript:void(0);" ng-click="login()" title="Track your order">My Orders</a>
                            @endif
                            </li>
                            
                            <li>
                                @if(Auth::check())
                                    <a id="my-account" href="{{ URL('/my-account')}}">My Account</a>
                                @else
                                <a id="my-account" href="javascript:void(0);" ng-click="login()">My Account</a>
                                @endif
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active mini-cart dropdown" id="desktop-mini-cart">
                                <a href="{{ URL('/cart') }}">
                                    <span class="fab-cirle am-bg-dark-blue">
                                        <span aria-hidden="true" class="glyphicon glyphicon-shopping-cart"></span>
                                    </span>
                                    <span class="mini-cart-count" ng-bind="cart_count" ng-init="cart_count='{{ $cart_count }}'"></span>  items in cart:
                                    <!--<span class="mini-cart-total">$0.00</span>-->
                                </a>
                            </li>
                            @if (Auth::guest())
                            <li><a class="login" href="javascript:void(0);" ng-click="login()">Login</a></li>
                            <li><a class="register" href="javascript:void(0);" ng-click="register()">Register</a></li>
                            @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->first_name.' '.Auth::user()->last_name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout')}}"> Logout</a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            <nav class="navbar logo-navbar navbar-default">
                <div class="container container-nav-search">
                    <div class="" id="navbar-lower">
                        <ul class="nav navbar-nav">
                            <li class="active am-logo"><a href="{{ url('/')}}" title="Auto-LightHouse"></a></li>
                        </ul>
                        <ul class="free-shipping">
                            <li>
                                <h3>&nbsp;{{ $header_content->custom_field1 or '' }}</h3>
                                <div class="order-by-text">{{ $header_content->custom_field2 or '' }}</div>
                            </li>
                        </ul>
                        <form action="{{ URL('products/search') }}" class="navbar-form navbar-right" id="search-form" method="get" role="search">
                           <div class="select-apperance">
                            <select class="form-control" name="cat">
                                <option value="">All Categories</option>
                                 @foreach($featured_category as $key=>$cat_value)
                                    <option @if(Request::get('cat') == $cat_value->id)selected @endif value="{{ $cat_value->id }}">{{ $cat_value->name  }}</option>
                                    @endforeach
                            </select>
                            </div>
                            <div class="input-group input-group-lg" id="search-phrase-container">
                                <input aria-label="Enter Search" autocomplete="off" class="form-control" id="search-phrase" name="q" placeholder="Search" type="text" value="{{ Request::get('q') }}" />
                                <span class="input-group-addon" id="search-glass">
                                    <span aria-hidden="true" class="glyphicon glyphicon-search"></span>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>
            <div>
                <nav class="navbar dropdowns-navbar navbar-default navbar-categories">
                    <div class="container">
                        <div class="navbar-header">
                            <div class="dropdown-categories-header">Auto Light Categories:</div>
                            <button aria-controls="dropdown-navbar-target" class="navbar-toggle collapsed" data-target="#dropdown-navbar-target" data-toggle="collapse" type="button">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="navbar-collapse collapse" id="dropdown-navbar-target">
                            <ul class="nav navbar-nav">
                                @if(isset($categories))
                                @foreach($categories as $key=>$cat_value)
                                <li>
                                    <a data-toggle="dropdown" href="javascript:void(0);">{{ $cat_value->name }}<span class="glyphicon glyphicon-triangle-bottom"></span></a>
                                    <div class="dropdown-menu">
                                        <h2 class="onea-page-header">{{ $cat_value->name }}</h2>
                                        <div class="row">
                                            <div class="category-lists">
                                                @foreach ($cat_value->sub_categories as $sub_key => $sub_value)
                                                 <div class="col-sm-4 single-li">
                                                        <a href="{{ url('/'.$sub_value->slug) }}"><span class="fa fa-angle-double-right"></span> {{ $sub_value->name }}</a>
                                                 </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </section>
        <!-- BEGIN CONTENT -->
        <!--for angular message-->
        <div class="alert-message">
            <div id="alert_loading" class="alert fade in alert-dismissable" ng-show="alert_loading" ng-class="alertClass" style="display: none;">
                <a href="javascript:void(0);" ng-click="alert_loading = false" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <strong><% alertLabel %> </strong><% alert_messages %>
            </div>
            @if(Session::has('success-message') || Session::has('error-message'))
            <div id="redirect_alert" class="alert @if(Session::has('success-message')) alert-success @elseif(Session::has('error-message')) alert-danger @endif fade in alert-dismissable">
                <a href="javascript:void(0);" onclick="$(this).parent().remove();" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <strong>@if(Session::has('success-message')) Success! @elseif(Session::has('error-message')) Error! @endif </strong>@if(Session::has('success-message')) {{ Session::pull('success-message') }} @elseif(Session::has('error-message')) {{ Session::pull('error-message') }} @endif
            </div>
            @endif
        </div>
        <div id="content">
            <!--<div class="animated"  @if(Request::is('/')) ng-bind-html="render_html" @endif ng-class="animated">-->
            @yield('content')
            <!--</div>-->
        </div><!-- /#content -->
<!--        <div class="modal" id="zipModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                      <h3 class="modal-title text-center">Want To Get The Best Deal ?</h3>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-center">Type In Your Zip Code!</h3>
                        <form name="zipForm" method="post" role="form" ng-submit="submitZipRegion(zipForm.$valid)" action="javascript:void(0);" novalidate>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="zipCode" ng-model="zipCode" required="" class="form-control input-lg" placeholder="Enter Your Zip Code">
                                    </div>
                                </div>
                                <div class="col-md-2"><button type="submit" class="btn am-orange btn-block btn-lg">Sign In</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>-->
        <footer class="footer">
            <div class="container">
                <div class="row">
                     <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3>Customer Service<span class="footer-header-border"></span></h3>
                        <ul>
                            <!-- <li>Chat with an                                        agent</li> -->
                            <li><a href="{{ URL('/about-us')}}" title="About Auto Light House">About Us</a></li>
                            <li>
                            @if(Auth::check())
                                <a href="{{ URL('/my-account/order')}}" title="Track your order">Track Your Order</a>
                            @else
                                <a href="javascript:void(0);" ng-click="login()" title="Track your order">Track Your Order</a>
                            @endif
                            </li>
                            <!--<li><a href="javascript:void(0);" title="Return a Part">Return a Part</a></li>-->
                            <li><a href="{{ URL('/contact-us') }}" title="Contact Us">Contact Us</a></li>
                            <li><a href="{{ URL('/shipping') }}" title="Shipping Policy">Shipping Policy</a></li>
                            <li><a href="{{ URL('/return') }}" title="Return Policy">Return Policy</a></li>
                        </ul>
                    </div>
                     <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3>Sign up For Special Deals<span class="footer-header-border"></span></h3>
                        <ul class="">
                            <li>Get Special Offers &amp; Discounts</li>
                            <li><form METHOD="POST" action="javascript:void(0);" class="subscription-form subscription-simple" name="subscribeForm">
                                    <table class="email-field" id="formTable">
                                        <tr>
                                            <td>Email:</td>
                                            <td><input name="email" required="" style="color:black" type="text" /><span></span></td>
                                        </tr>
                                    </table>
                                    <br />
                                    <input class="btn am-orange" type="submit" value="Subscribe" />
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h3>Secure Checkout<span class="footer-header-border"></span></h3>
                        <ul class="secure-checkout">
                            <li></li>
                        </ul>
                        <h3>We Accept<span class="footer-header-border"></span></h3>
                        <ul class="creditcards">
                            <li class="cc1">
                                <img src="{{ url('/images/accepted-credit-cards.png')}}" alt="PayPal, American Express, MasterCard, Discover, Visa" class="img lazy" height="60" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom-links">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <span class="copyright">Copyright © 2017 Auto Light House. All Rights Reserved.</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--AngularJS-->
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.2/angular.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.2/angular-sanitize.min.js"></script>
        <!--<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.2/angular-animate.min.js"></script>-->
        <script src="{{ URL::asset('/js/common.js') }}"></script>
        <script type="text/javascript">
                                            var BaseUrl = "<?php echo url('/') ?>";
                                            //remove alert box
                                            setTimeout(function () {
                                                $("#redirect_alert").remove();
                                            }, 8000);
                                           
                                           $(document).ready(function () {
//                                                $('#zipModal').on('hidden.bs.modal', function (e) {
//                                                   localStorage.setItem("checkZipModal",true); 
//                                                });
                                                $(document).on('click', '#am-ymm-home-form li a', function (e) {
                                                    e.preventDefault();
                                                    angular.element(this).scope().getProductVehicleData($(this));
                                                });
                                                $(document).on("click","#search-glass",function(){
                                                    $( "#search-form" ).submit();
                                                });
//                                                if(localStorage.getItem("checkZipModal") == null){
//                                                    setTimeout(function(){
//                                                        $("#zipModal").modal({ backdrop: 'static',keyboard: false });
//                                                        $('section').removeClass('scrollActive');
//                                                    },5000);
//                                                }
                                                
                                            });

        </script>
        <script src="{{ URL::asset('/js/angular/front.js') }}"></script>
        @stack('scripts')
    </body>
</html>
