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
                    <div class="col-md-5 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">All Transactions</div>
                            <div class="panel-body" >
                                @if(count($items) > 0)
                                    @foreach($items as $item)
                                        <div style="border: 3px solid #ccfff0;">
                                         <div>
                                            <a href="item/{{$item->id}}">
                                                 <img alt="{{$item->Name}}" src="{{$item->Picture_URL}}" class="img-thumbnail" style="max-width:300px" />
                                             </a>            
                                        </div>
                                        <div class="display-group">
                                            <div><h2 align="left" style="padding-left:10px; text-decoration:bold"><a href="item/{{$item->id}}">{{$item->Name}}</a></h2></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px">${{$item->Price}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px">{{$item->Short_Description}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px">Status: <b>{{$item->Status}}</b></p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px">Sale ends <b>{{\Carbon\Carbon::parse($item->End_Date)->format('d/m/Y')}}</b></p></div>
                                        </div>
                                        <div class="progress" style="margin: 20px;">
                                         <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                            aria-valuemin="0" aria-valuemax="100" style="width:{{$item->Number_Transactions/$item->Threshold*100}}%; background-color: #14A989;">
                                         </div>
                                        </div>
                                        <div class="row" style="font-size: 16px;">
                                            <div class="col-md-12 text-center">
                                              {{$item->Number_Transactions}} / {{$item->Threshold}} Orders Placed <br><br>
                                            </div>
                                        </div>   
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px">Order placed on <b>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</b></p></div>
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
                                            <div><p align="left" style="padding-left:10px"><b>Name: </b>{{$item->Name}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Bulk Price: </b>{{$item->Bulk_Price}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Short Description: </b>{{$item->Short_Description}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Start Date: </b>{{$item->Start_Date}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>End Date: </b>{{$item->End_Date}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Status: </b>{{$item->Status}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Current Number of Customers Commited: </b>{{$item->Number_Transactions}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Threshold: </b>{{$item->Threshold}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Order Placed Date: </b>{{$item->created_at}}</p></div>
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
                                            <div><p align="left" style="padding-left:10px"><b>Name: </b>{{$item->Name}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Bulk Price: </b>{{$item->Bulk_Price}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Short Description: </b>{{$item->Short_Description}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Start Date: </b>{{$item->Start_Date}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>End Date: </b>{{$item->End_Date}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Status: </b>{{$item->Status}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Current Number of Customers Commited: </b>{{$item->Number_Transactions}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Threshold: </b>{{$item->Threshold}}</p></div>
                                        </div>
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px"><b>Order Placed Date: </b>{{$item->created_at}}</p></div>
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