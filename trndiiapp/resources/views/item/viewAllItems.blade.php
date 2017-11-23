
@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2> 
                <span style='font-weight: bold;'>
                    Number of items <font style="font-size: 20px;">(Total: {{count($items)}})</font>
                </span>
            </h2>
        </div>
    </div>

    @if(count($items)>0)

        @foreach($items as $item)
            <div class="row">
                <div class="col-md-2">
                    <img alt="{{$item->Name}}" src="{{$item->Picture_URL}}" class="img-thumbnail" />           
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 style="margin-top: 5px;">{{$item->Name}}</h2>
                            <h4>Short Description: {{$item->Short_Description}}</h4>
                            <h4>Long Description: {{$item->Long_Description}}</h4>
                            <h4>Price: <strong>${{$item->Price}}</strong></h4>
                            <h4>Bulk Price: <strong>${{$item->Bulk_Price}}</strong></h4>
                            <h4>Received tokens upon purchase: <strong>{{$item->Tokens_Given}}</strong></h4>
                            <h4>Number of commited users: <strong>{{$item->Number_Transactions}}</strong></h4>
                            <h4>Threshold: <strong>{{$item->Threshold}}</strong></h4>
                            <h4>Status: <strong>{{$item->Status}}</strong></h4>
                            @if($item->Status == 'pending' || $item->Status == 'threshold reached')
                                {!! Form::open(['action' => ['ItemsController@update', $item->id], 'method' => 'POST', 'onsubmit' => "return confirm('Are you sure you want to delete this item?')"]) !!}
                                    {{Form::hidden('_method','PUT')}}
                                    {{Form::submit('Delete', ['class'=>'btn btn-primary'])}}
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        </div>
                    </div>
                </div>
            </div>
            <br>
        @endforeach
            @else
                <p>No items in database</p>
            @endif
@endsection
