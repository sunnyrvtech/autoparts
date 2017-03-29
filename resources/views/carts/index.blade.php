@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="container">
    <div class="container-fluid page-header-wrapper cart-header">
        <div class="row">
            <div class="col-md-12 col-sm-8 col-xs-12">
                <h1 class="onea-page-header">View Cart</h1>
            </div>
        </div>
    </div>
    <div class="container-fluid order-container">
        <div class="row cart-list material" elevation="1">
            <div class="col-md-12">
                <div class="table-responsive order-items">
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
                                    <div class="product-image"><img src="https://db08le7w43ifw.cloudfront.net/partimage/SSP/AM-1913640939/075d1d6e8fa94c01a782f729f006c9cb_386.jpg" alt="00-08 Audi A4 Exc Sport Suspension Front Shock Absorber Pair" width="120" height="120"></div>
                                </td>
                                <td>
                                    <a class="ga-product-link" href="/products/shocks-and-struts/AM-1913640939.html?m=770&amp;y=2007">2000-2008 Audi A4 Front Shock Absorber Pair for Models without Sport Suspension</a>
                                    <div class="product-shipping-text">In Stock Ships Within 1 Business Day FREE SHIPPING AND HANDLING!
                                    </div>
                                    <div class="product-sku">Part Number: AM-1913640939</div>
                                    <div class="product-fit">Make: Audi / Model: A4 / Year: 2007</div>
                                </td>
                                <td>
                                    <select class="order-quantity-dropdown form-control">
                                        <option>1</option>
                                        <option selected="selected">2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                    </select>
                                </td>
                                <td>
                                    <div>$60.10</div>
                                </td>
                                <td>
                                    <div class="">$120.20</div>
                                </td>
                                <td>
                                    <a class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></a>
                                    <a class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="product-image"><img src="https://db08le7w43ifw.cloudfront.net/partimage/FAC/AM-27141763/6af033d36d434885a8bdeb24f4336244_386.jpg" alt="00-05 Chevy GMC Full Size PU &amp; SUV Accelerator Pedal Sensor" width="120" height="120"></div>
                                </td>
                                <td>
                                    <a class="ga-product-link" href="/products/accelerator-pedal-position-sensor/AM-27141763.html?m=772&amp;y=2003">2003-2003 Cadillac Escalade ESV Accelerator Pedal Position Sensor without Adjustable Pedals</a>
                                    <div class="product-shipping-text">In Stock Ships Within 1 Business Day FREE SHIPPING AND HANDLING!
                                    </div>
                                    <div class="product-sku">Part Number: AM-27141763</div>
                                    <div class="product-fit">Make: Cadillac / Model: Escalade ESV / Year: 2003</div>
                                </td>
                                <td>
                                    <select class="order-quantity-dropdown form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option selected="selected">3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                    </select>
                                </td>
                                <td>
                                    <div>$39.90</div>
                                </td>
                                <td>
                                    <div class="">$119.70</div>
                                </td>
                                <td>
                                    <a class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></a>
                                    <a class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mobile-carts-items">
                    <div class="image-and-title">
                        <div class="image">
                            <img src="https://db08le7w43ifw.cloudfront.net/partimage/SSP/AM-1913640939/075d1d6e8fa94c01a782f729f006c9cb_386.jpg" alt="00-08 Audi A4 Exc Sport Suspension Front Shock Absorber Pair" width="120" height="120">
                        </div>
                        <div class="title">
                            <a class="ga-product-link" href="/products/shocks-and-struts/AM-1913640939.html?m=770&amp;y=2007">2000-2008 Audi A4 Front Shock Absorber Pair for Models without Sport Suspension</a>
                        </div>
                    </div>
                    <div class="product-shipping-text">
                        In Stock Ships Within 1 Business Day<br>
                        FREE SHIPPING AND HANDLING!
                    </div>
                    <div class="product-sku">Part Number: AM-1913640939</div>
                    <div class="product-fit">Make: Audi / Model: A4 / Year: 2007</div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="order-quantity-dropdown form-control" data-sku-id="1457199" data-product-id="1457199" data-order-item-id="1314016">
                                        <option>1</option>
                                        <option selected="selected">2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                    </select>
                                </td>
                                <td>
                                    <div>$60.10</div>
                                </td>
                                <td>
                                    <div class="">$120.20</div>
                                </td>
                                <td>
                                    <button class="remove-item-button close" type="button">
                                        <span>×</span>
                                    </button>
                                </td>
                            </tr>   
                        </tbody>
                    </table>
                    <div class="image-and-title">
                        <div class="image">
                            <div><img src="https://db08le7w43ifw.cloudfront.net/partimage/FAC/AM-27141763/6af033d36d434885a8bdeb24f4336244_386.jpg" alt="00-05 Chevy GMC Full Size PU &amp; SUV Accelerator Pedal Sensor" width="120" height="120"></div>
                        </div>
                        <div class="title">
                            <a class="ga-product-link" href="/products/accelerator-pedal-position-sensor/AM-27141763.html?m=772&amp;y=2003">2003-2003 Cadillac Escalade ESV Accelerator Pedal Position Sensor without Adjustable Pedals</a>
                        </div>
                    </div>

                    <div class="product-shipping-text">
                        In Stock Ships Within 1 Business Day<br>
                        FREE SHIPPING AND HANDLING!
                    </div>
                    <div class="product-sku">Part Number: AM-27141763</div>
                    <div class="product-fit">Make: Cadillac / Model: Escalade ESV / Year: 2003</div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="order-quantity-dropdown form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option selected="selected">3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                    </select>
                                </td>
                                <td>
                                    <div>$39.90</div>
                                </td>
                                <td>
                                    <div class="">$119.70</div>
                                </td>
                                <td>
                                    <button aria-label="Close" class="remove-item-button close" type="button">
                                        <span>×</span>
                                    </button>
                                </td>
                            </tr>   
                        </tbody>
                    </table>       
                </div>
            </div>
        </div>
        <div class="row shipping-section material" elevation="1">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label">Shipping To: </label>
                    </div>
                    <div class="col-md-6">
                        <span>sad</span><span>adasda</span>,
                        <span>asdasd</span>,
                        <span>
                            <span>asdasda</span>,
                        </span>
                        <span>chandigarh</span>,
                        <span>NY</span>
                        <span>16004</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <form method="post" action="javascript:void(0);">
                        <select class="form-control">
                            <option>Select Shipping Method</option>
                            <option>Ground</option>
                            <option>UPS Next Day Air</option>
                            <option>UPS 2nd Day Air</option>
                        </select>
                    </form>
                </div>
                <div class="row total-price-section material" elevation="1">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <label>Tax: </label>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <span>$0.00</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <label>Subtotal:</label>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <span>$239.90</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <label>Total:</label>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <span class="price">$267.56</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button class="btn btn-success btn-block" type="submit">Checkout</button>
                </div>`
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush
