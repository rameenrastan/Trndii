<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Your purchase has been completed!</h2>

        <div>
            Hi {{ $userName }},<br><br>
            Thank you for your interest in this item! This message is to inform you that it has reached the desired number of orders, and will therefore be shipped shortly.
            You will be notified in another email for the shipping confirmation. 
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