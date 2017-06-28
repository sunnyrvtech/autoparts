<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
    <div class="btn-group btn-group-vertical" <?php if($order_details == ''): ?> ng-init="selectedTab = 'shipping-address'" <?php else: ?> ng-init="selectedTab = 'orders'" <?php endif; ?>>
         <div class="btn-group"> 
            <a class="btn btn-nav" ng-class="{'active':selectedTab === 'profile'}" ng-click="selectedTab = 'profile'" href="#profile" data-toggle="tab">
                <span class="glyphicon glyphicon-user"></span>
                <p>Profile</p>
            </a>
        </div>
        <div class="btn-group">
            <a class="btn btn-nav" ng-class="{'active':selectedTab === 'shipping-address'}" ng-click="selectedTab = 'shipping-address'" href="#shipping-address" data-toggle="tab">
                <span class="glyphicon fa fa-address-card"></span>
                <p>Shipping Address</p>
            </a>
        </div>
        <div class="btn-group">
            <a class="btn btn-nav" ng-class="{'active':selectedTab === 'billing-address'}" ng-click="selectedTab = 'billing-address'" href="#billing-address" data-toggle="tab">
                <span class="glyphicon fa fa-address-card"></span>
                <p>Billing Address</p>
            </a>
        </div>
        <div class="btn-group">
            <a class="btn btn-nav" ng-class="{'active':selectedTab === 'orders'}" ng-click="selectedTab = 'orders'" href="#orders" data-toggle="tab">
                <span class="glyphicon fa fa-cart-arrow-down"></span>
                <p>My Orders</p>
            </a>
        </div>
        <div class="btn-group">
            <a class="btn btn-nav" ng-class="{'active':selectedTab === 'change-password'}" ng-click="selectedTab = 'change-password'" href="#change-password" data-toggle="tab">
                <span class="glyphicon fa fa-cogs"></span>
                <p>Change Password </p>
            </a>
        </div>
    </div>
</div>