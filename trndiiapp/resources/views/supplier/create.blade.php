@extends('layouts.app')

<!-- $table->increments('id');
            $table->string('name');
            $table->string('phone')->default("Enter a phone number");
            $table->string('addressline1')->default("Enter an address line");
            $table->string('addressline2')->nullable();
            $table->string('postalcode')->default("Enter a postal code");
            $table->string("city")->default("Enter a city");
            $table->string('country')->default("Enter a country");
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps(); -->

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Supplier</div>

                    <div class="panel-body">

                        {!! Form::open(array('action' => 'AdminController@storeSupplier'))!!}

                        <div class="form-group">
                            {{Form::label('name', 'Supplier Name',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{Form::text('name',null , array('class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('phone','Phone number',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{Form::number('phone',null, array('placeholder'=>'5143334444','class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('addressline1','Address line 1',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{Form::text('addressline1',null, array('class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('addressline2','Address line 2',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{Form::text('addressline2',null, array('class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('postalcode','Postal code',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{Form::text('postalcode',null, array('class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('city','City',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{Form::text('city',null, array('class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('country','Country',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{ Form::select('country', ['Canada'=>'Canada', 'United States'=>'United States'], null, array('class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('email','Email',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{Form::email('email',null, array('class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('password','Password',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{ Form::password('password', array('class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{Form::submit('Submit', array('class' => 'btn btn-primary', 'id' => 'create-supplier'))}}
                            </div>
                        </div>


                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
