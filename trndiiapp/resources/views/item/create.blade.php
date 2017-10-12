@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Create item</h1>
            <hr>


    {!! Form::open(['route' => 'item.store']) !!}

    {{Form::label('Name', 'Item Name')}}
    {{Form::text('Name', '', array('class' => 'form-control'))}}


    {{Form::label('Price')}}
    {{Form::number('Price','0.00', array('step'=>'0.01','class' => 'form-control'))}}

    {{Form::label('Threshold')}}
    {{Form::number('Threshold', null, array('class' => 'form-control'))}}

    {{Form::submit('Create Item', array('class' => 'btn'))}}

    {!! Form::close() !!}

        </div>
    </div>


@endsection
