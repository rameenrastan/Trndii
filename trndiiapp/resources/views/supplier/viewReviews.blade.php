@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2>
                <span style='font-weight: bold;'>
                    Number of reviews: <font style="font-size: 20px;">{{ count($reviewsForSupplier) }}</font>
                </span>
                </h2>
            </div>
        </div>
        @if(count($reviewsForSupplier) > 0)
            @foreach($reviewsForSupplier as $reviewForSupplier)
                <div class="row">
                    <div class="col-md-2">
                        <img alt="{{$reviewForSupplier->Name}}" src="{{$reviewForSupplier->Picture_URL}}" class="img-thumbnail"/>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 style="margin-top: 5px;">{{$reviewForSupplier->Name}}</h2>
                                <h4>Short Description: {{$reviewForSupplier->Short_Description}}</h4>
                                <h4>Long Description: {{$reviewForSupplier->Long_Description}}</h4>
                                <h4>Price: <strong>${{$reviewForSupplier->Price}}</strong></h4>
                                <h4>Bulk Price: <strong>${{$reviewForSupplier->Bulk_Price}}</strong></h4>
                                <h4>Received tokens upon purchase: <strong>{{$reviewForSupplier->Tokens_Given}}</strong></h4>
                                <h4>Number of committed users: <strong>{{$reviewForSupplier->Number_Transactions}}</strong></h4>
                                <h4>Threshold: <strong>{{$reviewForSupplier->Threshold}}</strong></h4>
                                <h3>Review</h3>
                                <h4>User: {{ $reviewForSupplier->user_name }}</h4>
                                <h4>Rating: {{ $reviewForSupplier->rating }}/5</h4>
                                <h4>Comment: {{ $reviewForSupplier->comment}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            @endforeach
        @endif
    </div>
@endsection