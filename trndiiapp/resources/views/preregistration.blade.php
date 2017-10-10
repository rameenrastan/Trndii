@extends('layouts.app')

@section('content')
    <h1>Welcome to the Trndii Pre-Registration page!</h1>
    <h3>Please fill out the form below!</h3>
    {!! Form::open(['action' => 'PreregisteredUsersController@store', 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('firstname', 'First Name')}}
            {{Form::text('firstname', '', ['class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('lastname', 'Last Name')}}
            {{Form::text('lastname', '', ['class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'E-Mail')}}
            {{Form::text('email', '', ['class' => 'form-control'])}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
