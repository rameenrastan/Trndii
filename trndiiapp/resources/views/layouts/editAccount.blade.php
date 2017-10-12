
@extends('layouts.app')

@section('content')
    <h1>Edit your account information!</h1>

    {!! Form::open(['action' => 'UsersController@update', 'method' => 'POST']) !!}
    <div class="form-group">
        {{--{{Form::label('name', 'First Name')}}--}}
        {{Form::label('name', 'Name')}}
        {{Form::text('name', Auth::user()->name, ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{Form::label('email', 'E-Mail')}}
        {{Form::email('email', Auth::user()->email, ['class' => 'form-control'])}}
    </div>
    <div class="form-group">
        {{Form::label('phoneNumber', 'Phone Number')}}
        {{Form::text('phoneNumber',Auth::user()->phonenumber , ['class' => 'form-control'])}}
    </div>
    <div class="form-group">
        {{Form::label('address', 'Address')}}
        {{Form::text('address', Auth::user()->address, ['class' => 'form-control'])}}
    </div>
    <div class="form-group">
        {{Form::label('postalCode', 'Postal Code')}}
        {{Form::text('postalCode', Auth::user()->postalcode, ['class' => 'form-control'])}}
    </div>
    <div class="form-group">
        {{Form::label('country', 'Country')}}
        {{Form::text('country', Auth::user()->country, ['class' => 'form-control'])}}
    </div>
    {{Form::submit('Update', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection







{{--@extends('layouts.app')--}}

{{--@section('content')--}}
    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-8 col-md-offset-2">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">Edit your account information</div>--}}

                    {{--<div class="panel-body">--}}
                        {{--<form class="form-horizontal" method="POST" action="{{ route('register') }}">--}}

                            {{--{{ csrf_field() }}--}}

                            {{--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">--}}
                                {{--<label for="name" class="col-md-4 control-label">Name</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>--}}


                                    {{--@if ($errors->has('name'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('name') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}



                            {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
                                {{--<label for="email" class="col-md-4 control-label">E-Mail Address</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input id="email" type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>--}}

                                    {{--@if ($errors->has('email'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<label for="phoneNumber" class="col-md-4 control-label">Phone Number</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input id="phoneNumber" type="text" class="form-control" name="phoneNumber" value="{{ Auth::user()->name }}" required>--}}

                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<label for="address" class="col-md-4 control-label">Address</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input id="Address" type="text" class="form-control" name="Address" value="{{ Auth::user()->name }}" required>--}}

                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<label for="postalCode" class="col-md-4 control-label">Postal Code</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input id="postalCode" type="text" class="form-control" name="postalCode" value="{{ Auth::user()->name }}" required>--}}

                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<label for="country" class="col-md-4 control-label">Country</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input id="country" type="text" class="form-control" name="country" value="{{ Auth::user()->name }}" required>--}}

                                {{--</div>--}}
                            {{--</div>--}}


                                {{--<div class="col-md-6 col-md-offset-4">--}}
                                    {{--<button type="submit" class="btn btn-primary">--}}
                                        {{--Submit Edit--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endsection--}}
