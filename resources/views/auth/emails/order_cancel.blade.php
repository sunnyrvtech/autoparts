<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <meta name="format-detection" content="telephone=no" /> <!-- disable auto telephone linking in iOS -->
                <title>Auto Light House</title>
                </head>
                <body>
                    <h2>Order has been cancelled</h2>
                    <h4><span>Order Id #: {{ $order_id }}</span></h4>
                    <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                        <tr>
                            <td align="left" valign="top" class="flexibleContainerBox">
                                <table border="0" cellpadding="30" cellspacing="0" width="100%" style="max-width:100%;">
                                    <tr>
                                        <td align="left" class="textContent">
                                            <h3 style="line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">Shipping Address</h3>
                                            <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;line-height:135%;">
                                                <span>{{ $shipping_address->first_name.' '.$shipping_address->last_name }}</span><br/>
                                                <span>{{ $shipping_address->address1 }}</span><br/>
                                                <span>{{ $shipping_address->address2 }}</span><br/>
                                                <span>{{ $shipping_address->city.','.$shipping_address->state_name.','.$shipping_address->zip.' '.$shipping_address->country_name }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" valign="top" class="flexibleContainerBox">
                                <table class="flexibleContainerBoxNext" border="0" cellpadding="30" cellspacing="0" width="100%" style="max-width:100%;">
                                    <tr>
                                        <td align="left" class="textContent">
                                            <h3 style="line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">Billing Address</h3>
                                            <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;line-height:135%;">
                                                <span>{{ $billing_address->first_name.' '.$billing_address->last_name }}</span><br/>
                                                <span>{{ $billing_address->address1 }}</span><br/>
                                                <span>{{ $billing_address->address2 }}</span><br/>
                                                <span>{{ $billing_address->city.','.$billing_address->state_name.','.$billing_address->zip.' '.$billing_address->country_name }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
                </html>
