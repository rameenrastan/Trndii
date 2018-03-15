@extends('layouts.app')

@section('content')

    <div class="container">
            <h2>Item Reviews</h2>
            @if(count($reviewsForSupplier) > 0)
                <h3>Number of reviews: {{ count($reviewsForSupplier) }}</h3>
            @else
                <h3>You currently have no item reviews</h3>
            @endif
    </div>
@endsection