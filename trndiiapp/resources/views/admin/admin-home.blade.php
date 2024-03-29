@extends('layouts.app')

@section('content')

    <div class="panel-heading">ADMIN Dashboard</div>

        <div class="panel-body">
            You are logged in as ADMIN
            <br>
            <a href="/item/create">Click here to add item</a>
            <br>
            <a href="/viewAllItems">Click here to view all items</a>
            <br>
            <a href="/supplier/create">Click here to add supplier</a>
            <br>
            <a href="/banUserForm">Click here to moderate users</a>
            <br>
            <a href="/getMetrics">Click here to get Metrics</a>
        </div>
    </div>
@endsection
