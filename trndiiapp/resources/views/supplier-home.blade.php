@extends('layouts.app')

@section('content')

    <div class="panel-heading">Supplier Homepage</div>

        <div class="panel-body">
            You are logged in as a supplier
            <br>
            <a href="/supplier/items">Click here to view your items' progress</a>
            <br>
            <a href="/supplier/reviews">Click here to view item reviews</a>
        </div>
    </div>
@endsection
