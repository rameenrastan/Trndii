<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>An item you ordered has expired.</h2>

        <div>
            Hi {{ $userName }},<br><br>
            Thank you for your commitment in this item. Unfortunately it has expired and did not
            reach the number of required orders, and therefore will not be shipped. 
            Please note that you will not be charged for any items that don't successfully complete. 
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