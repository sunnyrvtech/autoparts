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

        <title>Laravel</title>
        <link rel="shortcut icon" href="assets/images/gt_favicon.png">
        <!-- Styles -->
        <link href="{{ URL::asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/css/style.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/css/animate.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet" type="text/css" />
        <script>
            window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?>
        </script>
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
        <section>
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

                        <a class="mini-cart pull-right hidden-md hidden-lg" id="mobile-mini-cart" href="javascript:void(0);">
                            <span class="fab-cirle am-bg-dark-blue">
                                <span aria-hidden="true" class="glyphicon glyphicon-shopping-cart"></span>
                            </span>
                            <span class="mini-cart-count">0</span>
                            <span class="hidden-xxs"> items in cart:</span>
                            <span class="visible-xxs-inline"> / </span>
                            <span class="mini-cart-total">$0.00</span>
                        </a>

                        <a class="navbar-brand" title="Auto-LightHouse" href="/"></a>
                    </div>
                    <div class="navbar-collapse collapse" id="navbar">
                        <ul class="nav navbar-nav">
                            <li><a href="javascript:void(0);" title="Email Customer Care"><span aria-hidden="true" class="glyphicon glyphicon-envelope"></span> Ask a Question</a></li>
                            <li><a href="javascript:void(0);" title="Frequently Asked Questions">FAQ</a></li>
                            <li><a href="javascript:void(0);" title="Track your order">Order Tracking</a></li>

                            <li>
                                <a id="my-account" href="javascript:void(0);">My Account</a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active mini-cart dropdown" id="desktop-mini-cart">
                                <a href="javascript:void(0);">
                                    <span class="fab-cirle am-bg-dark-blue">
                                        <span aria-hidden="true" class="glyphicon glyphicon-shopping-cart"></span>
                                    </span>
                                    <span class="mini-cart-count">0</span>  items
                                    in
                                    cart:
                                    <span class="mini-cart-total">$0.00</span>
                                </a>
                            </li>
                            <li><a class="login" href="javascript:void(0);" ng-click="login()">Login</a></li>
                            <li><a class="register" href="javascript:void(0);" ng-click="login()">Register</a></li>
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
                                <h3>Always Free Shipping!</h3>
                                <div class="order-by-text">Order by 5 P.M. EST M-F and your order ships same day</div>
                            </li>
                        </ul>
                        <div class="bottom-phone-and-mini-cart">

                        </div>
                        <form action="javascript:void(0);" class="navbar-form navbar-right" id="search-form" method="get" role="search">
                            <div class="input-group input-group-lg" id="search-phrase-container">
                                <input aria-label="Enter Search" autocomplete="off" class="form-control" id="search-phrase" name="q" placeholder="Search" type="text" value="" />
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
                            <div class="dropdown-categories-header">Auto Parts Categories:</div>
                            <button aria-controls="dropdown-navbar-target" class="navbar-toggle collapsed" data-target="#dropdown-navbar-target" data-toggle="collapse" type="button">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="navbar-collapse collapse" id="dropdown-navbar-target">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a data-target-container="li" href="#" data-target="#nav-dropdown-0">Exterior, Body Parts & Mirrors</a>
                                    <span aria-hidden="true" class="glyphicon glyphicon-triangle-bottom"></span>
                                </li>
                                <li>
                                    <a data-target-container="li" href="#" data-target="#nav-dropdown-1">Interior Parts and Accessories</a>
                                    <span aria-hidden="true" class="glyphicon glyphicon-triangle-bottom"></span>
                                </li>
                                <li>
                                    <a data-target-container="li" href="#" data-target="#nav-dropdown-2">Engine Parts</a>
                                    <span aria-hidden="true" class="glyphicon glyphicon-triangle-bottom"></span>
                                </li>
                                <li>
                                    <a data-target-container="li" href="#" data-target="#nav-dropdown-3">Drivetrain Parts</a>
                                    <span aria-hidden="true" class="glyphicon glyphicon-triangle-bottom"></span>
                                </li>
                                <li>
                                    <a data-target-container="li" href="#" data-target="#nav-dropdown-4">Headlights & Lighting</a>
                                    <span aria-hidden="true" class="glyphicon glyphicon-triangle-bottom"></span>
                                </li>
                                <li>
                                    <a data-target-container="li" href="#" data-target="#nav-dropdown-5">Heating & Cooling</a>
                                    <span aria-hidden="true" class="glyphicon glyphicon-triangle-bottom"></span>
                                </li>
                                <li>
                                    <a data-target-container="li" href="#" data-target="#nav-dropdown-6">Brakes, Steering & Suspension Parts</a>
                                    <span aria-hidden="true" class="glyphicon glyphicon-triangle-bottom"></span>
                                </li>
                                <li>
                                    <a data-target-container="li" href="#" data-target="#nav-dropdown-7">Fuel, Exhaust & Emissions Parts</a>
                                    <span aria-hidden="true" class="glyphicon glyphicon-triangle-bottom"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </section>
        <!-- BEGIN CONTENT -->
        <div id="content">
            <div class="container animated" @if(Request::is('/')) ng-bind-html="render_html" @endif ng-class="animated"><!-- /#content.container -->
                 @yield('content')
        </div><!-- /#content.container -->
    </div><!-- /#content -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <h3>Customer Service<span class="footer-header-border"></span></h3>
                    <ul>
                        <!-- <li>Chat with an agent</li> -->
                        <li><a href="javascript:void(0);" title="About Auto Light House">About Us</a></li>
                        <li><a href="javascript:void(0);" title="Track Your Order">Track Your Order</a></li>
                        <li><a href="javascript:void(0);" title="Return a Part">Return a Part</a></li>
                        <li><a href="javascript:void(0);" title="Email Customer Care">Email Customer Care</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
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
                <div class="col-lg-4 col-md-6 col-sm-6">
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

    <!-- Scripts -->
    <script src="{{ URL::asset('/js/app.js') }}"></script>
    <!--AngularJS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.2/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.2/angular-sanitize.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.2/angular-animate.min.js"></script>-->
    <script>
                                        var BaseUrl = "<?php echo url('/') ?>";
    </script>
    <script src="{{ URL::asset('/js/front.js') }}"></script>
</body>
</html>
