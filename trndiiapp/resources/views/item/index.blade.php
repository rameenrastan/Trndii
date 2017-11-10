@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

{{--This section consists of each item listing, which is actually a row with 2 columns. The column on the left has the item's picture while the 
row on the right is composed of 3 rows, each row containing part of the item information.--}}

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2> 
                    <span style='font-weight: bold;'>
                        Browsing Items
                    </span>
                </h2>
            </div>
        </div>

        @if(count($items)>0)

            @foreach($items as $item)
            <div class="row">
            <div class="col-md-2">
                <img alt="Bootstrap Image Preview" src="http://lorempixel.com/140/140/" class="img-thumbnail" />
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            Item Name: <a href="item/{{$item->id}}"> {{$item->Name}}</a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            Item Price: {{$item->Price}} $
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            Tokens Given: {{$item->Tokens_Given}} Tokens
                        </p>
                    </div>
                </div>
            </div>
            </div>
                @endforeach

            {{$items->links()}}
                @else
                    <p>No items in database</p>
                @endif

    </div>
@endsection
