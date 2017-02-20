@extends('layouts.app')

@section('content')
<div class="row ymm-con">
    <div class="col-md-0"></div>
    <div class="col-md-12 material" elevation="1">
        <div class="am-ymm horizontal hide-header full-width">
            <h2>Select your vehicle</h2>
            <div class="am-ymm-inner">
                <h3 id="ymm-header">Find parts for your car</h3>
                <form id="am-ymm-home-form">
                    <div class="btn-group year-select ymm-select">
                        <button class="btn btn-default dropdown-toggle input-xlg" data-toggle="dropdown" type="button">
                            <span class="select-text">Select Vehicle Year</span><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu scrollable-menu">
                            <li><a role="button">Select Vehicle Year</a></li>
                        </ul>
                    </div>

                    <div class="btn-group make-select ymm-select">
                        <button class="btn btn-default dropdown-toggle input-xlg" data-toggle="dropdown" type="button">
                            <span class="select-text">Select Vehicle Make</span><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu scrollable-menu">
                            <li><a role="button">Select Vehicle Make</a></li>
                        </ul>
                    </div>

                    <div class="btn-group model-select ymm-select">
                        <button class="btn btn-default dropdown-toggle input-xlg" data-toggle="dropdown" type="button">
                            <span class="select-text">Select Vehicle Model</span><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu scrollable-menu">
                            <li><a role="button">Select Vehicle Model</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-xlg am-orange hover material ymm-submit" elevation="1" type="submit">Search</button>
                    <br class="clearfix" />
                </form>
                <a class="clear-vehicle hidden">Clear Vehicle</a>
            </div>
        </div>
    </div>
    <div class="col-md-0"></div>
</div>
<div class="row featured-cats-con">
    <div class="col-md-12 material" elevation="1">
        <!-- Featured Categories -->
        <div class="home-page-card-con">
            <div class="home-page-card-con-inner">
                <h3>Featured Categories</h3>
<!--                <div class="carousel-loading">
                    <i class="glyphicon glyphicon-repeat gly-spin"></i>
                </div>-->
                <div class="carousel-con">
                    <!-- repeat this div-->
                    <div class="thumbnail-wrapper">
                        <a class="thumbnail" href="/headlight-assemblies.html">
                            <div class="img-wrapper">
                                <img class="" src="https://db08le7w43ifw.cloudfront.net/catimage/19/main.JPG" alt="Headlight Assemblies" />
                            </div>  
                            <div class="caption">
                                <div class="caption-text truncate">Headlight Assemblies</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="full-list-widget">
                    <div class="full-list-con container-fluid hidden-xs hidden">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row catalog-list hidden-xs">
                                        <div class="col-xs-4">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="javascript:void(0);">4WD Axle Actuator Housing</a>
                                                </div>
                                            </div>



                                        </div>
                                        <div class="col-xs-4">
                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/egr-pressure-feedback-sensor.html">EGR Valve Pressure Feedback Sensor</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-4">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/power-steering-oil-cooler.html">Power Steering Oil Cooler</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row catalog-list hidden-xxs visible-xs">
                                        <div class="col-xs-6">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/4wd-axle-actuator-housing.html">4WD Axle Actuator Housing</a>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-xs-6">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/drive-belt-pulleys.html">Idler & Tensioner Pulleys</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row catalog-list visible-xxs">
                                        <div class="col-xs-12">
                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/4wd-axle-actuator-housing.html">4WD Axle Actuator Housing</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="actions hidden-xs">
                        <a class="btn am-orange hover material full-list-control-show" elevation="1" href="#">View All</a>
                        <a class="btn am-orange hover material full-list-control-hide hidden" elevation="1" href="#">Hide All</a>
                    </div>
                    <div class="actions visible-xs">
                        <a class="btn am-orange hover material" elevation="1" href="shop-by-category.html">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row popular-brands-con">
    <div class="col-md-0"></div>
    <div class="col-md-12 material" elevation="1">
        <!-- Popular Brands -->
        <div class="home-page-card-con">
            <div class="home-page-card-con-inner">
                <h3>Popular Brands</h3>
<!--                <div class="carousel-loading">
                    <i class="glyphicon glyphicon-repeat gly-spin"></i>
                </div>-->
                <div class="carousel-con" type="TOP_BASIC_BRAND" var-name="brands" vehicle-context="false">
                    <!--//repeat this div-->
                    <div class="thumbnail-wrapper">
                        <a class="thumbnail" href="/search.html?brandName=Timken">
                            <div class="img-wrapper">
                                <img class="" src="https://db08le7w43ifw.cloudfront.net/brandimage/10/main.JPG" alt="Timken" />
                            </div>
                            <div class="caption">
                                <div class="caption-text truncate">Timken</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="full-list-widget">
                    <div class="full-list-con container-fluid hidden-xs hidden" type="BASIC_BRAND" var-name="brands">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row catalog-list hidden-xs">
                                        <div class="col-xs-4">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/search.html?brandName=A1+Cardone">A1 Cardone</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-4">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/search.html?brandName=A1+Cardone">A1 Cardone</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-4">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/search.html?brandName=A1+Cardone">A1 Cardone</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row catalog-list hidden-xxs visible-xs">
                                        <div class="col-xs-6">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/search.html?brandName=A1+Cardone">A1 Cardone</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/search.html?brandName=A1+Cardone">A1 Cardone</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row catalog-list visible-xxs">
                                        <div class="col-xs-12">
                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/search.html?brandName=A1+Cardone">A1 Cardone</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="actions hidden-xs">
                        <a class="btn am-orange hover material full-list-control-show" elevation="1" href="#">View All</a>
                        <a class="btn am-orange hover material full-list-control-hide hidden" elevation="1" href="#">Hide All</a>
                    </div>
                    <div class="actions visible-xs">
                        <a class="btn am-orange hover material" elevation="1" href="shop-by-brand.html">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-0"></div>
</div>

<div class="row shop-by-make-con">
    <div class="col-md-0"></div>
    <div class="col-md-12 material" elevation="1">
        <!-- Shop by Vehicle Make -->
        <div class="home-page-card-con">
            <div class="home-page-card-con-inner">
                <h3>Shop by Vehicle Make</h3>
<!--                <div class="carousel-loading">
                    <i class="glyphicon glyphicon-repeat gly-spin"></i>
                </div>-->
                <div class="carousel-con">
                    <!--repeat this div-->
                    <div class="thumbnail-wrapper">
                        <a class="thumbnail" href="/Chevy.html">
                            <!--<div class="img-wrapper">-->
                            <!--<onea:img media="*{images['primary']}" class="" disable-wrap/>-->
                            <!--</div>-->
                            <div class="caption">
                                <div class="caption-text truncate">Chevy</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="full-list-widget">
                    <div class="full-list-con container-fluid hidden-xs hidden">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row catalog-list hidden-xs">
                                        <div class="col-xs-4">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/Acura.html">Acura</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-4">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span aria-hidden="true" class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/Acura.html">Acura</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-4">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/Acura.html">Acura</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row catalog-list hidden-xxs visible-xs">
                                        <div class="col-xs-6">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/Acura.html">Acura</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">

                                            <!--repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span aria-hidden="true" class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/Acura.html">Acura</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row catalog-list visible-xxs">
                                        <div class="col-xs-12">
                                            <!--//repeat this div-->
                                            <div class="row">
                                                <div class="col-xs-12 col-xxs catalog-list-item truncate">
                                                    <span class="glyphicon glyphicon-menu-right"></span>
                                                    <a href="/Acura.html">Acura</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="actions hidden-xs">
                        <a class="btn am-orange hover material full-list-control-show" elevation="1" href="#">View All</a>
                        <a class="btn am-orange hover material full-list-control-hide hidden" elevation="1" href="#">Hide All</a>
                    </div>
                    <div class="actions visible-xs">
                        <a class="btn am-orange hover material" elevation="1" href="shop-by-make.html">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-0"></div>
</div>

<div class="row about-us-con">
    <div class="col-md-0"></div>
    <div class="col-md-12 material" elevation="1">
        <br />
        <h1 class="welcome-msg">Welcome to Auto Light House!</h1>
        <p>
            We've all been to a parts website thinking, "I'm here to get a part that fits my car - this should be easy!" Thirty minutes later, you get up from your computer, without auto parts and dejected. That won't happen here. The guesswork has been taken out of our shopping experience. The parts we sell are guaranteed to fit the applications we list. It should only take a minute or two to find what you need. Here, every part is in stock, has a picture, a terrific price, and will be shipped within 24 hours. No muss, no fuss and most importantly, no dejection.
        </p>
        <p>
            We stock a full range of replacement mirrors, power window regulators, power window motors, replacement door lock actuators, door handles, turn signal switches, headlights, tail lights and everything else you can imagine. Our parts are an inexpensive alternative to overpriced dealer parts. Our selection of domestic car, light truck, van, SUV and crossover replacement parts is unrivaled. Our selection of parts for your Japanese, Korean or European import is as extensive as you'll find. We also offer a vast number of replacement parts for your vintage and antique vehicle restoration projects. If you can think up a car part, chances are good that we sell it at a discount you'd have to see to believe.
        </p>
        <p>
            Our warehouse is always ready for your order.  If you place an order on a weekday, before 5 P.M. EST your order will be shipped that same day! Our trained, professional customer service staff offers prompt and courteous service. It's a combination of the most efficient warehouse crew, knowledgeable customer service representatives and our super fast FREE SHIPPING that keeps our customers coming back to us! Welcome to the best place to find replacement parts online: <a href="{{ url('.') }}">AUTOLIGHTHOUSE.COM</a>!
        </p>
    </div>
    <div class="col-md-0"></div>
</div>
@endsection
