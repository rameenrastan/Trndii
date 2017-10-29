<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Your Order Has Been Placed!</h2>

        <div>
            Hi {{ $userName }},<br><br>
            Thank you for placing an order for this item! If it reaches the required number of orders
            you will get another email confirming that the item will be shipped.
            <br><br>
            Item info:<br><br>
            Name: {{ $itemName }}<br>
            Price: {{ $itemPrice }}<br>
            Bulk Price: {{ $itemBulkPrice }}<br>
            Orders required: {{ $threshold }}<br>
            Description: {{ $shortDescription }}<br>
            <br>
            Thank you,<br>
            Trndii
        </div>

    </body>
</html>