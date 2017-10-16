<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Trndii') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
    @include('inc.messages')
    <h3 style='text-align:center'>Preregister for Trndii!</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Please fill out the form below to be notified when the website goes live.</div>

                    <div class="panel-body">
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
                            {{Form::email('email', '', ['class' => 'form-control'])}}
                        </div>
                        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                        {!! Form::close() !!}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>
