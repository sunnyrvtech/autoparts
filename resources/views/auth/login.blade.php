@extends('layouts.app')

@section('content')
<!--<div class="container-fluid page-header-wrapper">
    <div class="row">
        <h1 class="onea-page-header">Login or Register</h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row login-or-register">
        <div class="col-md-6 col-sm-12">
            <div>
                <h3>Log In</h3>

                <div>

                    <div>
                        <h4>Welcome Back to AM Autoparts!</h4>
                    </div>
                    <div>
                        <form id="login" method="POST" action="/login_post.htm">
                            <div class="form-group">
                                <label for="j_username">Email: <span class="required">*</span></label>
                                <input class="form-control" id="j_username" name="j_username" required="" type="text">
                            </div>
                            <div class="form-group">
                                <label for="j_password">Password: <span class="required">*</span></label>
                                <input class="form-control" id="j_password" name="j_password" required="" type="password">
                            </div>
                            <input name="successUrl" value="/my_account.html" type="hidden">
                            <a class="link pull-right" id="recover-password" href="/forgot-password.html">Recover Password</a>
                            <br>
                            <button class="btn am-orange hover material" elevation="1" type="submit" value="submit">
                                Log In
                            </button>
                            <input name="csrfToken" value="SV1B-CVDN-5SKJ-61ZS-K8SO-UVG1-YI3G-7ZRE" type="hidden"></form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div><h3>Register</h3>
                <div class="register-form">
                    <form id="register" method="POST" action="/register">

                        <div class="form-group">
                            <label for="customer.emailAddress">Email: <span class="required">*</span></label>
                            <input class="form-control" required="" id="customer.emailAddress" name="customer.emailAddress" value="" type="text">
                        </div>
                        <div class="form-group">
                            <label for="password">Password: <span class="required">*</span></label>
                            <input class="form-control" required="" id="password" name="password" value="" type="password">
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="redirectUrl" name="redirectUrl" value="/my_account.html" type="hidden">
                        </div>
                        <button class="btn am-orange hover material" elevation="1" type="submit" value="submit">Register</button>
                        <input name="csrfToken" value="SV1B-CVDN-5SKJ-61ZS-K8SO-UVG1-YI3G-7ZRE" type="hidden"></form>
                    <br>
                </div>
                <div>
                    <p>Registering with AM Autoparts is quick and easy. It will allow you to have access to your order information and save you time when placing future orders with our site.</p>
                </div></div>
        </div>
    </div>
</div>-->
<div class="container"><!-- /#content.container -->    
    <div class="row">
        <h2>Please Login or Register <small>Welcome Back to Auto Light House!</small></h2>
        <hr class="colorgraph">
        <div class="col-xs-12 col-md-6">
            <form role="form">
                <h2>Login In <small>It's free and always will be.</small></h2>
                <hr class="colorgraph">
                <div class="form-group">
                    <input type="email" name="email" required=""  class="form-control input-lg" placeholder="Email Address" tabindex="3">
                </div>
                <div class="form-group">
                    <input type="password" name="password" required=""  class="form-control input-lg" placeholder="Password" tabindex="4">
                </div>
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><a href="#" class="btn btn-success btn-block btn-lg">Sign In</a></div>
                </div>
            </form>
        </div>
        <div class="col-xs-12 col-md-6">
            <form role="form">
                <h2>Register<small></small></h2>
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="first_name" required=""  id="first_name" class="form-control input-lg" placeholder="First Name" tabindex="1">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="last_name" required=""  id="last_name" class="form-control input-lg" placeholder="Last Name" tabindex="2">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="email" name="email" required=""  id="email" class="form-control input-lg" placeholder="Email Address" tabindex="4">
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="password" name="password" required=""  id="password" class="form-control input-lg" placeholder="Password" tabindex="5">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="password" name="password_confirmation" required=""  id="password_confirmation" class="form-control input-lg" placeholder="Confirm Password" tabindex="6">
                        </div>
                    </div>
                </div>
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><input type="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
