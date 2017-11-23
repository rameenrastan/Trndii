
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
                    <a href="item/{{$item->id}}">
                        <img alt="{{$item->Name}}" src="{{$item->Picture_URL}}" class="img-thumbnail" />
                    </a>            
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 style="margin-top: 5px;">
                            <a href="item/{{$item->id}}"> {{$item->Name}}</a>
                            </h2>
                                {{$item->Short_Description}}
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
                    <div class="row">
                        <div class="col-md-12">
                            <h4>
                                Status: <strong>{{$item->Status}}</strong>
                            </h4>
                        </div>
                    </div>
                    @if($item->Status == 'pending')
                        {!! Form::open(['action' => ['ItemsController@update', $item->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','PUT')}}
                            {{Form::submit('Delete', ['class'=>'btn btn-primary'])}}
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
            <br>
        @endforeach
            @else
                <p>No items in database</p>
            @endif
@endsection
