@extends('layouts.app')

@section('content')
    <h1>Add Credit Card</h1>
    {!! Form::open(['action'] => 'UserController@storeCard', 'method' => 'POST') !!}
        <div class="form-group">

        </div>
    {!! Form::close() !!}

@end('section')