@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>Your Orders</h2>
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">All</a></li>
            <li><a data-toggle="pill" href="#menu1">Active</a></li>
            <li><a data-toggle="pill" href="#menu2">Past</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">All Transactions</div>
                            <div class="panel-body" >
                                @if(count($items) > 0)
                                    @foreach($items as $item)
                                        <div style="border: 3px solid #ccfff0;">
                                        <div class="display-group">
                                            <h4><b>Name</b></h4>
                                            <div>{{$item->Name}}</div>
                                        </div>
                                        <div class="display-group">
                                            <h4><b>Bulk Price</b></h4>
                                            <div>{{$item->Bulk_Price}}</div>
                                        </div>
                                        <div class="display-group">
                                            <h4><b>Short Description</b></h4>
                                            <div>{{$item->Short_Description}}</div>
                                        </div>
                                        <div class="display-group">
                                            <h4><b>Start Date</b></h4>
                                            <div>{{$item->Start_Date}}</div>
                                        </div>
                                        <div class="display-group">
                                            <h4><b>EndDate</b></h4>
                                            <div>{{$item->End_Date}}</div>
                                        </div>
                                        <div class="display-group">
                                            <h4><b>Progress</b></h4>
                                            <div>{{$item->Status}}</div>
                                        </div>
                                        <div class="display-group">
                                            <h4><b>Current Number of Customers Commited</b></h4>
                                            <div>{{$item->Number_Transactions}}</div>
                                        </div>
                                        <div class="display-group">
                                            <h4><b>Threshold</b></h4>
                                            <div>{{$item->Threshold}}</div>
                                        </div>
                                        </div>
                                            <br/>
                                    @endforeach
                                @else
                                    <p>You have yet to purchase an item!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="menu1" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">Active Transactions</div>
                            <div class="panel-body">
                                @if(count($items) > 0)
                                    @foreach($items as $item)
                                        @if($item->Status == 'pending')
                                            <div style="border: 3px solid #ccfff0;">
                                            <div class="display-group">
                                                <h4><b>Name</b></h4>
                                                <div>{{$item->Name}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Bulk Price</b></h4>
                                                <div>{{$item->Bulk_Price}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Short Description</b></h4>
                                                <div>{{$item->Short_Description}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Start Date</b></h4>
                                                <div>{{$item->Start_Date}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>EndDate</b></h4>
                                                <div>{{$item->End_Date}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Progress</b></h4>
                                                <div>{{$item->Status}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Current Number of Customers Commited</b></h4>
                                                <div>{{$item->Number_Transactions}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Threshold</b></h4>
                                                <div>{{$item->Threshold}}</div>
                                            </div>
                                            </div>
                                            <br/>
                                        @endif
                                    @endforeach
                                @else
                                    <p>You have yet to purchase an item!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div id="menu2" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">Past Transactions</div>
                            <div class="panel-body">
                                @if(count($items) > 0)
                                    @foreach($items as $item)
                                        @if($item->Status == 'expired' || $item->Status == 'threshold reached')
                                            <div style="border: 3px solid #ccfff0;">
                                            <div class="display-group">
                                                <h4><b>Name</b></h4>
                                                <div>{{$item->Name}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Bulk Price</b></h4>
                                                <div>{{$item->Bulk_Price}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Short Description</b></h4>
                                                <div>{{$item->Short_Description}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Start Date</b></h4>
                                                <div>{{$item->Start_Date}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>EndDate</b></h4>
                                                <div>{{$item->End_Date}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Progress</b></h4>
                                                <div>{{$item->Status}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Current Number of Customers Commited</b></h4>
                                                <div>{{$item->Number_Transactions}}</div>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Threshold</b></h4>
                                                <div>{{$item->Threshold}}</div>
                                            </div>
                                            </div>
                                            <br/>
                                        @endif
                                    @endforeach
                                @else
                                    <p>You have yet to purchase an item!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

@endsection