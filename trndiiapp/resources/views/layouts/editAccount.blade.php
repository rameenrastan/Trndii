@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit your account information</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phoneNumber" class="col-md-4 control-label">Phone Number</label>

                                <div class="col-md-6">
                                    <input id="phoneNumber" type="text" class="form-control" name="phoneNumber" value="{{ old('email') }}" required>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-md-4 control-label">Address</label>

                                <div class="col-md-6">
                                    <input id="Address" type="text" class="form-control" name="Address" value="{{ old('email') }}" required>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="postalCode" class="col-md-4 control-label">Postal Code</label>

                                <div class="col-md-6">
                                    <input id="postalCode" type="text" class="form-control" name="postalCode" value="{{ old('email') }}" required>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="country" class="col-md-4 control-label">Country</label>

                                <div class="col-md-6">
                                    <input id="country" type="text" class="form-control" name="country" value="{{ old('email') }}" required>

                                </div>
                            </div>


                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit Edit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
