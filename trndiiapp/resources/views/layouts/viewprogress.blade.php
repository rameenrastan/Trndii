@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">View Progress</div>
                    <div class="panel-body">
                        @if(count($transactions) > 0)
                        @foreach($transactions as $transaction)
                                <div class="display-group">
                                    <h4><b>Name</b></h4>
                                    <div>{{$transaction->Name}}</div>
                                    <br/>
                                </div>
                                <div class="display-group">
                                    <h4><b>Bulk Price</b></h4>
                                    <div>{{$transaction->Bulk_Price}}</div>
                                    <br/>
                                </div>
                                <div class="display-group">
                                    <h4><b>Short Description</b></h4>
                                    <div>{{$transaction->Short_Description}}</div>
                                    <br/>
                                </div>
                                <div class="display-group">
                                    <h4><b>Start Date</b></h4>
                                    <div>{{$transaction->Start_Date}}</div>
                                    <br/>
                                </div>
                                <div class="display-group">
                                    <h4><b>EndDate</b></h4>
                                    <div>{{$transaction->End_Date}}</div>
                                    <br/>
                                </div>
                                <div class="display-group">
                                    <h4><b>Progress</b></h4>
                                    <div>{{$transaction->status}}</div>
                                    <br/>
                                </div>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                        @endforeach
                        @else
                        <p>You have no current transactions!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection