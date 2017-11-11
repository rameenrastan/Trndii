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
                        Browsing Items <font style="font-size: 20px;">(Total: {{count($items)}})</font>
                    </span>
                </h2>
            </div>
        </div>

        @if(count($items)>0)

            @foreach($items as $item)
                <div class="row">
                    <div class="col-md-2">
                        <a href="item/{{$item->id}}">
                            <img alt="{{$item->Name}}" src="{{$item->Picture_URL}}" class="img-thumbnail" />
                        </a>            
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>
                                <a href="item/{{$item->id}}"> {{$item->Name}}</a>
                                </h2>
                                <h3>
                                    ${{$item->Price}}
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
            @endforeach

            {{$items->links()}}
                @else
                    <p>No items in database</p>
                @endif

    </div>
@endsection
