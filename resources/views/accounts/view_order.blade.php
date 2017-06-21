@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container"><!-- /#content.container -->   
    <table class="table order">
        <thead>
            <tr>
                <th></th>
                <th><label>Item Details</label></th>
                <th><label>Quantity</label></th>
                <th><label>Price</label></th>
                <th><label>Total</label></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="product-image"><img src="http://localhost/autoparts/public/product_images/default.jpg" alt="Chevrolet Pickup 88-97 Front Brake Rotor 2 500 (Each)" width="120" height="120"></div>
                </td>
                <td>
                    <a class="ga-product-link" href="http://localhost/autoparts/public/products/chevrolet-pickup-88-97-front-brake-rotor-2-500-each">Chevrolet Pickup 88-97 Front Brake Rotor 2 500 (Each)</a>
                    <!--<div class="product-shipping-text">In Stock Ships Within 1 Business Day FREE SHIPPING AND HANDLING!</div>-->
                    <div class="product-sku">Part Number: 017ROT</div>
                    <div class="product-fit">Make: Chevrolet / Model: Pickup / Year: 1988</div>
                </td>
                <td>
                    <input class="order-quantity-dropdown form-control" value="1" data-product-id="5863">
                    <input name="cart_id[]" value="5" autocomplete="off" type="hidden">
                </td>
                <td>
                    <div>$30.00</div>
                </td>
                <td>
                    <div class="">$30.00</div>
                </td>
                <td>
                    <a class="btn btn-danger btn-sm" ng-click="submitDeleteCart(5, 1)"><i class="fa fa-trash-o"></i></a>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="product-image"><img src="http://localhost/autoparts/public/product_images/default.jpg" alt="Cadillaccate 97-99 Radiator 3L V6 A/T" width="120" height="120"></div>
                </td>
                <td>
                    <a class="ga-product-link" href="http://localhost/autoparts/public/products/cadillaccate-97-99-radiator-3l-v6-at">Cadillaccate 97-99 Radiator 3L V6 A/T</a>
                    <!--<div class="product-shipping-text">In Stock Ships Within 1 Business Day FREE SHIPPING AND HANDLING!</div>-->
                    <div class="product-sku">Part Number: 00400-5</div>
                    <div class="product-fit">Make: Cadillac / Model: Catera / Year: 1997</div>
                </td>
                <td>
                    <input class="order-quantity-dropdown form-control" value="1" data-product-id="12513">
                    <input name="cart_id[]" value="6" autocomplete="off" type="hidden">
                </td>
                <td>
                    <div>$30.00</div>
                </td>
                <td>
                    <div class="">$30.00</div>
                </td>
                <td>
                    <a class="btn btn-danger btn-sm" ng-click="submitDeleteCart(6, 1)"><i class="fa fa-trash-o"></i></a>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="product-image"><img src="http://localhost/autoparts/public/product_images/default.jpg" alt="Cadillacdts 06-11 Radiator 4.6L V8" width="120" height="120"></div>
                </td>
                <td>
                    <a class="ga-product-link" href="http://localhost/autoparts/public/products/cadillacdts-06-11-radiator-46l-v8">Cadillacdts 06-11 Radiator 4.6L V8</a>
                    <!--<div class="product-shipping-text">In Stock Ships Within 1 Business Day FREE SHIPPING AND HANDLING!</div>-->
                    <div class="product-sku">Part Number: 00400-19</div>
                    <div class="product-fit">Make: Cadillac / Model: Dts / Year: 2006</div>
                </td>
                <td>
                    <input class="order-quantity-dropdown form-control" value="2" data-product-id="24165">
                    <input name="cart_id[]" value="7" autocomplete="off" type="hidden">
                </td>
                <td>
                    <div>$30.00</div>
                </td>
                <td>
                    <div class="">$60.00</div>
                </td>
                <td>
                    <a class="btn btn-danger btn-sm" ng-click="submitDeleteCart(7, 2)"><i class="fa fa-trash-o"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
@push('scripts')
@endpush
