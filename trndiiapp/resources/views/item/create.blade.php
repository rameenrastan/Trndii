@extends('layouts.admin.main')

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

    {{Form::label('Bulk Price')}}
    {{Form::number('Bulk Price','0.00', array('step'=>'0.01','class' => 'form-control'))}}

    {{Form::label('Tokens Given')}}
    {{Form::number('Tokens Given', null, array('class' => 'form-control'))}}

    {{Form::label('Threshold')}}
    {{Form::number('Threshold', null, array('class' => 'form-control'))}}

    {{Form::label('Short Description')}}
    {{Form::text('Short Description', null, array('class' => 'form-control'))}}

    {{Form::label('Long Description')}}
    {{Form::textarea('Long Description', null, array('class' => 'form-control'))}}

    {{Form::label('Start Date')}}
    {{Form::date('Start Date', null, array('class' => 'form-control', 'id' => 'start-date'))}}

    {{Form::label('End Date')}}
    {{Form::date('End Date', null, array('class' => 'form-control', 'id' => 'end-date'))}}

    {{Form::submit('Create Item', array('class' => 'btn', 'id' => 'create-item'))}}

    {!! Form::close() !!}

        </div>
    </div>


@endsection
