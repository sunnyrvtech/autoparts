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
        <h3>New inquiry email has been placed ,details mentioned below :-</h3>

        <ul style="list-style: none;">
            <li><label>Nature Of Inquiry:-</label> <span>{{ $inquiry }}</span></li>

            <li><label>Name:-</label> <span>{{ $name or '-----' }}</span></li>

            <li><label>Email Address:-</label> <span>{{ $email }}</span></li>

            <li><label>Order Number:-</label> <span>{{ $order_number or '-----' }}</span></li>

            <li><label>Item Number:-</label> <span>{{ $item_number or '-----' }}</span></li>

            <li><label>Message:-</label> <span>{{ $comment or '-----' }}</span></li>
        </ul>
    </body>
</html>
