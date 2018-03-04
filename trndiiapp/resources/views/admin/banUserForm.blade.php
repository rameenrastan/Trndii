@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Item</div>

                    <div class="panel-body">

                        {!! Form::open(['action' => 'AdminController@banUser','class'=>'form-horizontal'])!!}



                        <div class="form-group">
                            {{Form::label('Email','Email',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{ Form::select('Email', $userEmails, null, array('class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('Comment','Comment',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{Form::textarea('Comment', null, array('class' => 'form-control','size'=>'30x3'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('Ban Type','Ban Type',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{ Form::select('Ban_Type', ['Ban'=>'Ban', 'Suspension'=>'Suspension', 'Unban'=>'Unban'], null, array('class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('Suspension Time','Suspension Time (In Days)',array('class'=>'col-md-4 control-label'))}}
                            <div class="col-md-6">
                                {{ Form::select('Suspension_Time', ['1'=>'1', '7'=>'7', '14'=>'14'], null, array('class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{Form::submit('Submit', array('class' => 'btn btn-primary', 'id' => 'ban user'))}}
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
