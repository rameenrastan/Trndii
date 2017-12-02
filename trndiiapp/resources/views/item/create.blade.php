@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Item</div>

                        <div class="panel-body">

                            {!! Form::open(['route' => 'item.store','class'=>'form-horizontal'])!!}

                            <div class="form-group">
                                {{Form::label('Name', 'Item Name',array('class'=>'col-md-4 control-label'))}}
                                <div class="col-md-6">
                                    {{Form::text('Name', '', array('class' => 'form-control'))}}
                                </div>
                            </div>

                            <div class="form-group">
                                {{Form::label('Price','Price',array('class'=>'col-md-4 control-label'))}}
                                <div class="col-md-6">
                                    {{Form::number('Price',null, array('placeholder'=>'0.00','step'=>'0.01','class' => 'form-control'))}}
                                </div>
                            </div>

                            <div class="form-group">
                                {{Form::label('Bulk Price','Bulk Price',array('class'=>'col-md-4 control-label'))}}
                                <div class="col-md-6">
                                    {{Form::number('Bulk Price',null, array('placeholder'=>'0.00','step'=>'0.01','class' => 'form-control'))}}
                                </div>
                            </div>

                            <div class="form-group">
                                 {{Form::label('Tokens Given','Tokens Given', array('class'=>'col-md-4 control-label'))}}
                                  <div class="col-md-6">
                                    {{Form::number('Tokens Given', null, array('class' => 'form-control'))}}
                                  </div>
                            </div>

                            <div class="form-group">
                                {{Form::label('Threshold','Threshold',array('class'=>'col-md-4 control-label'))}}
                                <div class="col-md-6">
                                    {{Form::number('Threshold', null, array('class' => 'form-control'))}}
                                </div>
                            </div>

                            <div class="form-group">
                                {{Form::label('Short Description','Short Description',array('class'=>'col-md-4 control-label'))}}
                                <div class="col-md-6">
                                    {{Form::text('Short Description', null, array('class' => 'form-control'))}}
                                </div>
                            </div>

                            <div class="form-group">
                                {{Form::label('Long Description','Long Description',array('class'=>'col-md-4 control-label'))}}
                                <div class="col-md-6">
                                    {{Form::textarea('Long Description', null, array('class' => 'form-control','size'=>'30x3'))}}
                                </div>
                            </div>

                            <div class="form-group">
                                {{Form::label('Start Date','Start Date',array('class'=>'col-md-4 control-label'))}}
                                <div class="col-md-6">
                                    {{Form::date('Start Date', null, array('class' => 'form-control', 'id' => 'start-date'))}}
                                </div>
                            </div>

                            <div class="form-group">
                                {{Form::label('End Date','End Date',array('class'=>'col-md-4 control-label'))}}
                                <div class="col-md-6">
                                    {{Form::date('End Date', null, array('class' => 'form-control', 'id' => 'end-date'))}}
                                </div>
                            </div>

                            <div class="form-group">
                                {{Form::label('Picture URL','Picture URL',array('class'=>'col-md-4 control-label'))}}
                                <div class="col-md-6">
                                    {{Form::text('Picture URL', null, array('class' => 'form-control'))}}
                                </div>
                            </div>

                            <div class="form-group">
                                {{Form::label('Shipping To','Shipping To',array('class'=>'col-md-4 control-label'))}}
                                <div class="col-md-6">
                                    {{ Form::select('Shipping_To', ['Canada and United States'=>'Canada, United States', 'Canada'=>'Canada', 'United States'=>'United States'], null, array('class' => 'form-control'))}}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    {{Form::submit('Submit', array('class' => 'btn btn-primary', 'id' => 'create-item'))}}
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
