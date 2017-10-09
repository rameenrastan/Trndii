@extends('layouts.app')
@section('content')
    <h1>Add Credit Card</h1>
    <form class="form" action="/charge" method="post" id="payment-form">
        <div class="form-row">
            <label for="card-element">
            Credit Card Info
            </label>
            <div id="card-element">
            <!-- a Stripe Element will be inserted here. -->
            </div>
            <!-- Used to display Element errors -->
            <div id="card-errors" role="alert"></div>
        </div>
        <br>
        <button>Submit Payment</button>
    </form>
    <script>
        var stripe = Stripe('pk_test_6pRNASCoBOKtIshFeQd4XMUh');
        var elements = stripe.elements();

        var card = elements.create('card');
        card.mount('#card-element');

        var promise = stripe.createToken(card);
        promise.then(function(result) {
        // result.token is the card token.
        });
    </script>
@endsection