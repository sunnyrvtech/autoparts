<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
    <div class="btn-group btn-group-vertical">
         <div class="btn-group"> 
             <a class="btn btn-nav @if(Request::segment(2) == '')active @endif" href="{{ route('my-account') }}">
                <span class="glyphicon glyphicon-user"></span>
                <p>Profile</p>
            </a>
        </div>
        <div class="btn-group">
            <a class="btn btn-nav @if(Request::segment(2) == 'shipping')active @endif" href="{{ route('shipping') }}">
                <span class="glyphicon fa fa-address-card"></span>
                <p>Shipping Address</p>
            </a>
        </div>
        <div class="btn-group">
            <a class="btn btn-nav @if(Request::segment(2) == 'billing')active @endif" href="{{ route('billing') }}">
                <span class="glyphicon fa fa-address-card"></span>
                <p>Billing Address</p>
            </a>
        </div>
        <div class="btn-group">
            <a class="btn btn-nav @if(Request::segment(2) == 'order')active @endif" href="{{ route('order') }}">
                <span class="glyphicon fa fa-cart-arrow-down"></span>
                <p>My Orders</p>
            </a>
        </div>
        <div class="btn-group">
            <a class="btn btn-nav @if(Request::segment(2) == 'change-password')active @endif" href="{{ route('change-password') }}">
                <span class="glyphicon fa fa-cogs"></span>
                <p>Change Password </p>
            </a>
        </div>
    </div>
</div>