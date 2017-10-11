@extends('layouts.app')

@section('content')
    <h1>Welcome to the Trndii Pre-Registration page!</h1>
    <h3>Please fill out the form below!</h3>
    {!! Form::open(['action' => 'PreregisteredUsersController@store', 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('firstName', 'First Name')}}
            {{Form::text('firstName', '', ['class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('lastName', 'Last Name')}}
            {{Form::text('lastName', '', ['class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'E-Mail')}}
            {{Form::text('email', '', ['class' => 'form-control'])}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
