@extends('layouts.app')

@section('content')
    <h1>Shopping Cart</h1>

<div class="container">
        <div class="row">
            <div class="col-md-7 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Items in your shopping cart</div>
                    <div class="panel-body">

                        @if(Cart::count() > 0)

                            @foreach(Cart::content() as $item)

                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="item/{{$item->id}}">
                                            <img alt="{{$item->name}}" src="{{$item->Picture_URL}}" class="img-thumbnail"/>
                                        </a>
                                    </div>
                                    <div class="col-md-8" style="text-align: left">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2 style="margin-top: 5px;">
                                                    <a href="item/{{$item->id}}"> {{$item->name}}</a>
                                                </h2>
                                                {{$item->Short_Description}}
                                                <h3>
                                                    ${{$item->price}}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>
                                                    Receive <strong>{{$item->Tokens_Given}}</strong> tokens upon purchase
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            @endforeach
                        @else
                            <p>There are no items in your shopping cart.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection