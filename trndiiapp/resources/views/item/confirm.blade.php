@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>

    <link rel="stylesheet" href="{{ URL::asset('assets/css/app.css') }}">

@endsection

@section('content')

    <div class="panel-heading">Purchase Confirmation</div>

        <div class="panel-body">
            Confirmation page

            <p><strong>Item details: </strong></p>
                        <p>
                            {{$item->Name}}
                            <br> <img alt="{{$item->Name}}" src= "{{$item->Picture_URL}}" class="img-responsive center-block" style="margin-bottom: 20px;"/>
                            <br> Price: {{$item->Price}}$
                            <br> Tokens Gained: {{$item->Tokens_Given}}
                        </p>
                        <p>
                            <br> Do you wish to spend any tokens? You have {{Auth::user()->tokens}} tokens to use.
                                <div class="col-md-2 col-md-offset-5"> 
                                    {{Form::number('Tokens',null, array('placeholder'=>'0','step'=>'1','class' => 'form-control'))}}    
                                </div>
                        </p>
                        <p>
                        <br>
                        <br>
                        <div class="col-md-2 col-md-offset-5"> 
                            {!! Form::open(['action' => ['TransactionsController@update', $item->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method', 'PUT')}}
                            {{Form::submit('Purchase', ['class' => 'btn btn-primary'])}}
                            {!! Form::close() !!}
                        </div>    
                        </p>
        </div>
    </div>
@endsection
