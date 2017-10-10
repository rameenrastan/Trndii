<html>
    <body>

        <form action="/updatecard" method="POST">

            {{ csrf_field() }}

            <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key='pk_test_Cax3lDd4RBr7Ov434NFqc1Mw'
                data-name="{{ config('app.name', 'Trndii') }}"
                data-panel-label="Update Card Details"
                data-label="Update Card Details"
                data-allow-remember-me=false
                data-locale="auto">
            </script>
        
        </form>

    </body>
</html>