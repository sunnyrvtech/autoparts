<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <meta name="format-detection" content="telephone=no" /> <!-- disable auto telephone linking in iOS -->
                <title>Auto Light House</title>
                <style type="text/css">
                    /* RESET STYLES */
                    html { background-color:#E1E1E1; margin:0; padding:0; }
                    body, #bodyTable, #bodyCell, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica, Arial, "Lucida Grande", sans-serif;}
                    table{border-collapse:collapse;}
                    table[id=bodyTable] {width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal;}
                    img, a img{border:0; outline:none; text-decoration:none;height:auto; line-height:100%;}
                    a {text-decoration:none !important;border-bottom: 1px solid;}
                    h1, h2, h3, h4, h5, h6{color:#5F5F5F; font-weight:normal; font-family:Helvetica; font-size:20px; line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;}

                    /* CLIENT-SPECIFIC STYLES */
                    .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail/Outlook.com to display emails at full width. */
                    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height:100%;} /* Force Hotmail/Outlook.com to display line heights normally. */
                    table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} /* Remove spacing between tables in Outlook 2007 and up. */
                    #outlook a{padding:0;} /* Force Outlook 2007 and up to provide a "view in browser" message. */
                    img{-ms-interpolation-mode: bicubic;display:block;outline:none; text-decoration:none;} /* Force IE to smoothly render resized images. */
                    body, table, td, p, a, li, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; font-weight:normal!important;} /* Prevent Windows- and Webkit-based mobile platforms from changing declared text sizes. */
                    .ExternalClass td[class="ecxflexibleContainerBox"] h3 {padding-top: 10px !important;} /* Force hotmail to push 2-grid sub headers down */

                    /* /\/\/\/\/\/\/\/\/ TEMPLATE STYLES /\/\/\/\/\/\/\/\/ */

                    /* ========== Page Styles ========== */
                    h1{display:block;font-size:26px;font-style:normal;font-weight:normal;line-height:100%;}
                    h2{display:block;font-size:20px;font-style:normal;font-weight:normal;line-height:120%;}
                    h3{display:block;font-size:17px;font-style:normal;font-weight:normal;line-height:110%;}
                    h4{display:block;font-size:18px;font-style:italic;font-weight:normal;line-height:100%;}
                    .flexibleImage{height:auto;}
                    .linkRemoveBorder{border-bottom:0 !important;}
                    table[class=flexibleContainerCellDivider] {padding-bottom:0 !important;padding-top:0 !important;}

                    body, #bodyTable{background-color:#E1E1E1;}
                    #emailHeader{background-color:#E1E1E1;}
                    #emailBody{background-color:#FFFFFF;}
                    #emailFooter{background-color:#E1E1E1;}
                    .nestedContainer{background-color:#F8F8F8; border:1px solid #CCCCCC;}
                    .emailButton{background-color:#205478; border-collapse:separate;}
                    .buttonContent{color:#FFFFFF; font-family:Helvetica; font-size:18px; font-weight:bold; line-height:100%; padding:15px; text-align:center;}
                    .buttonContent a{color:#FFFFFF; display:block; text-decoration:none!important; border:0!important;}
                    .emailCalendar{background-color:#FFFFFF; border:1px solid #CCCCCC;}
                    .emailCalendarMonth{background-color:#205478; color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:16px; font-weight:bold; padding-top:10px; padding-bottom:10px; text-align:center;}
                    .emailCalendarDay{color:#205478; font-family:Helvetica, Arial, sans-serif; font-size:60px; font-weight:bold; line-height:100%; padding-top:20px; padding-bottom:20px; text-align:center;}
                    .imageContentText {margin-top: 10px;line-height:0;}
                    .imageContentText a {line-height:0;}
                    #invisibleIntroduction {display:none !important;} /* Removing the introduction text from the view */

                    /*FRAMEWORK HACKS & OVERRIDES */
                    span[class=ios-color-hack] a {color:#275100!important;text-decoration:none!important;} /* Remove all link colors in IOS (below are duplicates based on the color preference) */
                    span[class=ios-color-hack2] a {color:#205478!important;text-decoration:none!important;}
                    span[class=ios-color-hack3] a {color:#8B8B8B!important;text-decoration:none!important;}
                    /* A nice and clean way to target phone numbers you want clickable and avoid a mobile phone from linking other numbers that look like, but are not phone numbers.  Use these two blocks of code to "unstyle" any numbers that may be linked.  The second block gives you a class to apply with a span tag to the numbers you would like linked and styled.
                    Inspired by Campaign Monitor's article on using phone numbers in email: http://www.campaignmonitor.com/blog/post/3571/using-phone-numbers-in-html-email/.
                    */
                    .a[href^="tel"], a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:none!important;cursor:default!important;}
                    .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:auto!important;cursor:default!important;}


                    /* MOBILE STYLES */
                    @media only screen and (max-width: 480px){
                        /*////// CLIENT-SPECIFIC STYLES //////*/
                        body{width:100% !important; min-width:100% !important;} /* Force iOS Mail to render the email at full width. */

                        /* FRAMEWORK STYLES */
                        /*
                        CSS selectors are written in attribute
                        selector format to prevent Yahoo Mail
                        from rendering media query styles on
                        desktop.
                        */
                        /*td[class="textContent"], td[class="flexibleContainerCell"] { width: 100%; padding-left: 10px !important; padding-right: 10px !important; }*/
                        table[id="emailHeader"],
                        table[id="emailBody"],
                        table[id="emailFooter"],
                        table[class="flexibleContainer"],
                        td[class="flexibleContainerCell"] {width:100% !important;}
                        td[class="flexibleContainerBox"], td[class="flexibleContainerBox"] table {display: block;width: 100%;text-align: left;}
                        /*
                        The following style rule makes any
                        image classed with 'flexibleImage'
                        fluid when the query activates.
                        Make sure you add an inline max-width
                        to those images to prevent them
                        from blowing out.
                        */
                        td[class="imageContent"] img {height:auto !important; width:100% !important; max-width:100% !important; }
                        img[class="flexibleImage"]{height:auto !important; width:100% !important;max-width:100% !important;}
                        img[class="flexibleImageSmall"]{height:auto !important; width:auto !important;}


                        /*
                        Create top space for every second element in a block
                        */
                        table[class="flexibleContainerBoxNext"]{padding-top: 10px !important;}

                        /*
                        Make buttons in the email span the
                        full width of their container, allowing
                        for left- or right-handed ease of use.
                        */
                        table[class="emailButton"]{width:100% !important;}
                        td[class="buttonContent"]{padding:0 !important;}
                        td[class="buttonContent"] a{padding:15px !important;}

                    }

                    /*  CONDITIONS FOR ANDROID DEVICES ONLY
                    *   http://developer.android.com/guide/webapps/targeting.html
                    *   http://pugetworks.com/2011/04/css-media-queries-for-targeting-different-mobile-devices/ ;
                    =====================================================*/

                    @media only screen and (-webkit-device-pixel-ratio:.75){
                        /* Put CSS for low density (ldpi) Android layouts in here */
                    }

                    @media only screen and (-webkit-device-pixel-ratio:1){
                        /* Put CSS for medium density (mdpi) Android layouts in here */
                    }

                    @media only screen and (-webkit-device-pixel-ratio:1.5){
                        /* Put CSS for high density (hdpi) Android layouts in here */
                    }
                    /* end Android targeting */

                    /* CONDITIONS FOR IOS DEVICES ONLY
                    =====================================================*/
                    @media only screen and (min-device-width : 320px) and (max-device-width:568px) {

                    }
                    /* end IOS targeting */
                </style>
                </head>
                <body bgcolor="#E1E1E1" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
                    <center style="background-color:#E1E1E1;">
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
                            <tr>
                                <td align="center" valign="top" id="bodyCell">

                                    <!-- EMAIL BODY // -->
                                    <!--
                                            The table "emailBody" is the email's container.
                                            Its width can be set to 100% for a color band
                                            that spans the width of the page.
                                    -->
                                    <table bgcolor="#FFFFFF"  border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody">

                                        <!-- MODULE ROW // -->
                                        <!--
                                                To move or duplicate any of the design patterns
                                                in this email, simply move or copy the entire
                                                MODULE ROW section for each content block.
                                        -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CENTERING TABLE // -->
                                                <!--
                                                        The centering table keeps the content
                                                        tables centered in the emailBody table,
                                                        in case its width is set to 100%.
                                                -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="#3498db">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <!-- FLEXIBLE CONTAINER // -->
                                                            <!--
                                                                    The flexible container has a set width
                                                                    that gets overridden by the media query.
                                                                    Most content tables within can then be
                                                                    given 100% widths.
                                                            -->
                                                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                                <tr>
                                                                    <td align="center" valign="top" width="500" class="flexibleContainerCell">

                                                                        <!-- CONTENT TABLE // -->
                                                                        <!--
                                                                        The content table is the first element
                                                                                that's entirely separate from the structural
                                                                                framework of the email.
                                                                        -->
                                                                        <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                            <tr>
                                                                                <td align="center" valign="top" class="textContent">
                                                                                    @if(isset($carts['store_email']))
                                                                                    <h1 style="color:#FFFFFF;line-height:100%;font-family:Helvetica,Arial,sans-serif;font-size:30px;font-weight:normal;margin-bottom:5px;text-align:center;">New order has been placed from Auto Light House.</h1>
                                                                                    <div style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#FFFFFF;line-height:135%;">Order summary is below.Thank you again for your business.</div>
                                                                                    @else
                                                                                    <h1 style="color:#FFFFFF;line-height:100%;font-family:Helvetica,Arial,sans-serif;font-size:30px;font-weight:normal;margin-bottom:5px;text-align:center;">Thank you for your order from Auto Light House.</h1>
                                                                                    <div style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#FFFFFF;line-height:135%;">Your order summary is below. Thank you again for your business.</div>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <!-- // CONTENT TABLE -->
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- // FLEXIBLE CONTAINER -->
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>


                                        <!-- MODULE ROW // -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CENTERING TABLE // -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#F8F8F8">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <!-- FLEXIBLE CONTAINER // -->
                                                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                                <tr>
                                                                    <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                        <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                            <tr>
                                                                                <td align="center" valign="top">

                                                                                    <!-- CONTENT TABLE // -->
                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                                        <tr>
                                                                                            <td valign="top" class="textContent">
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:center;">Your Order #{{ $carts['other_cart_data']['transaction_id'] }}</h3>
                                                                                                <div mc:edit="body" style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">Placed on {{ $carts['other_cart_data']['order_time'] }}</div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <!-- // CONTENT TABLE -->

                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- // FLEXIBLE CONTAINER -->
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>
                                        <!-- // MODULE ROW -->

                                        <!-- MODULE DIVIDER // -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CENTERING TABLE // -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <!-- FLEXIBLE CONTAINER // -->
                                                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                                <tr>
                                                                    <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                        <table class="flexibleContainerCellDivider" border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                            <tr>
                                                                                <td align="center" valign="top" style="padding-top:0px;padding-bottom:0px;">

                                                                                    <!-- CONTENT TABLE // -->
                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                                        <tr>
                                                                                            <td align="center" valign="top" style="border-top:1px solid #C8C8C8;"></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <!-- // CONTENT TABLE -->

                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- // FLEXIBLE CONTAINER -->
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>
                                        <!-- // END -->

                                        <!-- MODULE ROW // -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CENTERING TABLE // -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 10px;">
                                                    <tr style="background: #F1F1F1;">
                                                        <th align="left" width="60%" style="padding: 10px;"><span style="color:#7a7a7a;font-weight: bold;">Item In Your Order</span></th>
                                                        <th width="10%" style="padding: 10px;"><span style="color:#7a7a7a;font-weight: bold;">Qty</span></th>
                                                        <th width="10%" style="padding: 10px;"><span style="color:#7a7a7a;font-weight: bold;">Price</span></th>
                                                        @if($carts['other_cart_data']['discount_status'] && $carts['other_cart_data']['coupon_type'] == 'per_product')
                                                        <th width="10%" style="padding: 10px;"><span style="color:#7a7a7a;font-weight: bold;">Discount</span></th>
                                                        @endif
                                                        <th width="10%" style="padding: 10px;"><span style="color:#7a7a7a;font-weight: bold;">Total</span></th>
                                                    </tr>
                                                    <?php $item_price = 0;$sub_total = 0; ?>
                                                    @foreach($carts['cart_data'] as $key => $value)
                                                    <?php
                                                        //calulate total price after coupan match and discount
                                                        if(isset($value['coupon_discount']) && $carts['other_cart_data']['discount_status'] && $carts['other_cart_data']['coupon_type'] == 'per_product'){
                                                            $item_price = $value['price']*$value['quantity'];
                                                            $item_price = $item_price-($item_price*$carts['other_cart_data']['coupon_discount']/100);
                                                            $sub_total += $item_price; 
                                                        }else{
                                                            $item_price = $value['price']*$value['quantity'];
                                                            $sub_total += $value['price']*$value['quantity'];
                                                        }
                                                    ?>
                                                    <tr style="border-bottom: 1px solid #C8C8C8;">
                                                        <td align="left" width="60%" style="padding: 15px;"><span style="font-weight: bold;">{{ $value['product_name'] }}</span><br><span>SKU: {{ $value['sku'] }}</span></td>
                                                        <td width="10%" style="padding: 15px;">{{ $value['quantity'] }}</td>
                                                        <td width="10%" style="padding: 15px;">${{ number_format($value['price'],2) }}</td>
                                                        @if($carts['other_cart_data']['discount_status'] && $carts['other_cart_data']['coupon_type'] == 'per_product')
                                                        <td width="10%" style="padding: 15px;">
                                                             @if(isset($value['coupon_discount']))
                                                             {{ number_format($value['coupon_discount'],2) }}%
                                                             @else
                                                             ---
                                                             @endif
                                                        </td>
                                                         @endif
                                                        <td width="10%" style="padding: 15px;">${{ number_format($item_price,2) }}</td>
                                                    </tr>
                                                    @endforeach

                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>
                                        <!-- // MODULE ROW -->

                                        <!-- MODULE ROW // -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CENTERING TABLE // -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#F8F8F8">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <!-- FLEXIBLE CONTAINER // -->
                                                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                                <tr>
                                                                    <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                        <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                            <tr>
                                                                                <td align="center" valign="top">

                                                                                    <!-- CONTENT TABLE // -->
                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                                        <tr>
                                                                                            <td>
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:right;">Sub Total</h3>
                                                                                            </td>
                                                                                            <td>
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:right;">${{ number_format($sub_total,2) }}</h3>
                                                                                            </td>
                                                                                        </tr>
                                                                                        @if($carts['other_cart_data']['discount_status'] && $carts['other_cart_data']['coupon_type'] == 'all_products')
                                                                                            <?php
                                                                                            $sub_total = $sub_total-($sub_total*$carts['other_cart_data']['coupon_discount']/100);
                                                                                            ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:right;">Discount</h3>
                                                                                            </td>
                                                                                            <td>
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:right;">{{ number_format($carts['other_cart_data']['coupon_discount'],2) }}%</h3>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:right;">Sub Total After Discount</h3>
                                                                                            </td>
                                                                                            <td>
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:right;">${{ number_format($sub_total,2) }}</h3>
                                                                                            </td>
                                                                                        </tr>
                                                                                        @endif
                                                                                        @if($carts['other_cart_data']['tax_rate'] != null)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:right;">Tax</h3>
                                                                                            </td>
                                                                                            <td>
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:right;">${{ $carts['other_cart_data']['tax_rate'] }}</h3>
                                                                                            </td>
                                                                                        </tr>
                                                                                        @endif
                                                                                        <tr>
                                                                                            <td>
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:right;">Shipping & Handling</h3>
                                                                                            </td>
                                                                                            <td>
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:right;">${{ number_format($carts['other_cart_data']['shipping_price'],2) }}</h3>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:right;">Grand Total</h3>
                                                                                            </td>
                                                                                            <td>
                                                                                                <h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:right;">${{ number_format($sub_total+$carts['other_cart_data']['shipping_price']+$carts['other_cart_data']['tax_rate'],2) }}</h3>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <!-- // CONTENT TABLE -->

                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- // FLEXIBLE CONTAINER -->
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>
                                        <!-- // MODULE ROW -->

                                        <!-- MODULE DIVIDER // -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CENTERING TABLE // -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <!-- FLEXIBLE CONTAINER // -->
                                                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                                <tr>
                                                                    <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                        <table class="flexibleContainerCellDivider" border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                            <tr>
                                                                                <td align="center" valign="top" style="padding-top:0px;padding-bottom:0px;">

                                                                                    <!-- CONTENT TABLE // -->
                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                                        <tr>
                                                                                            <td align="center" valign="top" style="border-top:1px solid #C8C8C8;"></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <!-- // CONTENT TABLE -->

                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- // FLEXIBLE CONTAINER -->
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>
                                        <!-- // END -->

                                        <!-- MODULE ROW // -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CENTERING TABLE // -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 10px;">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <!-- FLEXIBLE CONTAINER // -->
                                                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                                <tr>
                                                                    <td valign="top" width="500" class="flexibleContainerCell">

                                                                        <!-- CONTENT TABLE // -->
                                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                            <tr>
                                                                                <td align="left" valign="top" class="flexibleContainerBox">
                                                                                    <table border="0" cellpadding="30" cellspacing="0" width="100%" style="max-width:100%;">
                                                                                        <tr>
                                                                                            <td align="left" class="textContent">
                                                                                                <h3 style="line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">Billing Address</h3>
                                                                                                <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;line-height:135%;">
                                                                                                    <span>{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</span><br/>
                                                                                                    <span>{{ $billing_address->address1 }}</span><br/>
                                                                                                    <span>{{ $billing_address->address2 }}</span><br/>
                                                                                                    <span>{{ $billing_address->city.','.$billing_address->get_state->name.','.$billing_address->zip.' '.$billing_address->get_country->name }}</span>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                                <td align="right" valign="top" class="flexibleContainerBox">
                                                                                    <table class="flexibleContainerBoxNext" border="0" cellpadding="30" cellspacing="0" width="100%" style="max-width:100%;">
                                                                                        <tr>
                                                                                            <td align="left" class="textContent">
                                                                                                <h3 style="line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">Shipping Address</h3>
                                                                                                <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;line-height:135%;">
                                                                                                    <span>{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</span><br/>
                                                                                                    <span>{{ $shipping_address->address1 }}</span><br/>
                                                                                                    <span>{{ $shipping_address->address2 }}</span><br/>
                                                                                                    <span>{{ $shipping_address->city.','.$shipping_address->get_state->name.','.$shipping_address->zip.' '.$shipping_address->get_country->name }}</span>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left" valign="top" class="flexibleContainerBox">
                                                                                    <table border="0" cellpadding="30" cellspacing="0" width="100%" style="max-width:100%;">
                                                                                        <tr>
                                                                                            <td align="left" class="textContent">
                                                                                                <h3 style="line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">Shipping Method</h3>
                                                                                                <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;line-height:135%;">
                                                                                                    <span>{{ $carts['other_cart_data']['shipping_method'] }}</span><br/>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                                 <td align="right" valign="top" class="flexibleContainerBox">
                                                                                    <table class="flexibleContainerBoxNext" border="0" cellpadding="30" cellspacing="0" width="100%" style="max-width:100%;">
                                                                                        <tr>
                                                                                            <td align="left" class="textContent">
                                                                                                <h3 style="line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">Payment Method</h3>
                                                                                                <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;line-height:135%;">
                                                                                                    <span>{{ $carts['other_cart_data']['payment_method'] }}</span><br/>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <!-- // CONTENT TABLE -->

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- // FLEXIBLE CONTAINER -->
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>
                                        <!-- // MODULE ROW -->


                                        <!-- MODULE ROW // -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CENTERING TABLE // -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <!-- FLEXIBLE CONTAINER // -->
                                                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                                <tr>
                                                                    <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                        <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                            <tr>
                                                                                <td align="center" valign="top">

                                                                                    <!-- CONTENT TABLE // -->
                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                                        <tr>
                                                                                            <td valign="top" class="textContent">
                                                                                                <div style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">Thank you, Main Website Store!</div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <!-- // CONTENT TABLE -->

                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- // FLEXIBLE CONTAINER -->
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>
                                        <!-- // MODULE ROW -->

                                    </table>
                                    <!-- // END -->

                                    <!-- EMAIL FOOTER // -->
                                    <!--
                                            The table "emailBody" is the email's container.
                                            Its width can be set to 100% for a color band
                                            that spans the width of the page.
                                    -->
                                    <table bgcolor="#E1E1E1" border="0" cellpadding="0" cellspacing="0" width="500" id="emailFooter">

                                        <!-- FOOTER ROW // -->
                                        <!--
                                                To move or duplicate any of the design patterns
                                                in this email, simply move or copy the entire
                                                MODULE ROW section for each content block.
                                        -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CENTERING TABLE // -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <!-- FLEXIBLE CONTAINER // -->
                                                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                                <tr>
                                                                    <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                        <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                            <tr>
                                                                                <td valign="top" bgcolor="#E1E1E1">

                                                                                    <div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;">
                                                                                        <div>Copyright &#169; {{ date('Y') }}. All&nbsp;rights&nbsp;reserved.</div>
                                                                                    </div>

                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- // FLEXIBLE CONTAINER -->
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>

                                    </table>
                                    <!-- // END -->

                                </td>
                            </tr>
                        </table>
                    </center>
                </body>
                </html>
