@extends('layouts.app')

@section('content')








    <div class="container">
        <h2>Your Orders</h2>
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">Active Transactions</a></li>
            <li><a data-toggle="pill" href="#menu1">Purchase History</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <h3>Active Transactions</h3>







            </div>
            <div id="menu1" class="tab-pane fade">
                <h3>Purchase History</h3>

                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">Purchase History</div>
                            <div class="panel-body">
                                @if(count($items) > 0)
                                    @foreach($items as $item)
                                        @if($item->Status == 'expired' || $item->Status == 'threshold reached')
                                            <div class="display-group">
                                                <h4><b>Name</b></h4>
                                                <div>{{$item->Name}}</div>
                                                <br/>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Bulk Price</b></h4>
                                                <div>{{$item->Bulk_Price}}</div>
                                                <br/>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Short Description</b></h4>
                                                <div>{{$item->Short_Description}}</div>
                                                <br/>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>Start Date</b></h4>
                                                <div>{{$item->Start_Date}}</div>
                                                <br/>
                                            </div>
                                            <div class="display-group">
                                                <h4><b>EndDate</b></h4>
                                                <div>{{$item->End_Date}}</div>
                                                <br/>
                                            </div>
                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>
                                        @else
                                            <p>You have yet to purchase an item!</p>
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


@endsection