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
                    <div class="col-md-7 col-md-offset-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">All Transactions</div>
                            <div class="panel-body">
                                @if(count($items) > 0)
                                    @foreach($items as $item)
                                        <div style="border: 3px solid #ccfff0;">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <a href="item/{{$item->id}}">
                                                        <img alt="{{$item->Name}}" src="{{$item->Picture_URL}}"
                                                             class="img-thumbnail"/>
                                                    </a>
                                                </div>
                                                <div class="col-md-7" align="left">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h2 style="margin-top: 5px;">
                                                                <a href="item/{{$item->id}}"> {{$item->Name}}</a>
                                                            </h2>
                                                            {{$item->Short_Description}}
                                                            <h3>
                                                                ${{$item->Price}}
                                                            </h3>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <br>
                                            <div class="display-group">
                                                <div><p align="left" style="padding-left:10px">Status:
                                                        <b>{{$item->Status}}</b></p></div>
                                            </div>
                                            <div class="display-group">
                                                <div><p align="left" style="padding-left:10px">Sale ends
                                                        <b>{{\Carbon\Carbon::parse($item->End_Date)->format('d/m/Y')}}</b>
                                                    </p></div>
                                            </div>
                                            <div class="progress" style="margin: 20px;">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                     style="width:{{$item->Number_Transactions/$item->Threshold*100}}%; background-color: #14A989;">
                                                </div>
                                            </div>
                                            <div class="row" style="font-size: 16px;">
                                                <div class="col-md-12 text-center">
                                                    {{$item->Number_Transactions}} / {{$item->Threshold}} Orders Placed
                                                    <br><br>
                                                </div>
                                            </div>
                                            <div class="display-group">
                                                <div><p align="left" style="padding-left:10px">Order placed on
                                                        <b>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</b>
                                                    </p></div>
                                            </div>
                                            @feature('Cancel Purchase')
                                            @if($item->Status == 'pending')
                                                <div class="display-group">
                                                    <button type="button" class="btn btn-primary btn-lg"
                                                            data-toggle="modal" data-target="#CancelModal">Cancel
                                                    </button>
                                                </div>
                                                <p></p>
                                            @endif
                                            @endfeature
                                            <div class="display-group">
                                                <form action="{{ route('review.store') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="itemId" value="{{ $item->id }}">
                                                    <input type="hidden" name="Supplier" value="{{ $item->Supplier}}" >
                                                    <div class="form-group">
                                                        <p>Rate this produc out of 5</p>
                                                        <input type="radio" name="Rating" value=1>1
                                                        <input type="radio" name="Rating" value=2>2
                                                        <input type="radio" name="Rating" value=3>3
                                                        <input type="radio" name="Rating" value=4>4
                                                        <input type="radio" name="Rating" value=5>5
                                                    </div>
                                                    <div class="form-group">
                                                        <p>Comment</p>
                                                        <textarea name="Comment" cols="30" rows="3"></textarea>
                                                    </div>
                                                    <input type="submit" value="Submit Review">
                                                </form>
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
                    <div class="col-md-7 col-md-offset-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">Active Transactions</div>
                            <div class="panel-body">
                                @if(count($items) > 0)
                                    @foreach($items as $item)
                                        @if($item->Status == 'pending')
                                            <div style="border: 3px solid #ccfff0;">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <a href="item/{{$item->id}}">
                                                            <img alt="{{$item->Name}}" src="{{$item->Picture_URL}}"
                                                                 class="img-thumbnail"/>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-7" align="left">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h2 style="margin-top: 5px;">
                                                                    <a href="item/{{$item->id}}"> {{$item->Name}}</a>
                                                                </h2>
                                                                {{$item->Short_Description}}
                                                                <h3>
                                                                    ${{$item->Price}}
                                                                </h3>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <br>
                                                <div class="display-group">
                                                    <div><p align="left" style="padding-left:10px">Status:
                                                            <b>{{$item->Status}}</b></p></div>
                                                </div>
                                                <div class="display-group">
                                                    <div><p align="left" style="padding-left:10px">Sale ends
                                                            <b>{{\Carbon\Carbon::parse($item->End_Date)->format('d/m/Y')}}</b>
                                                        </p></div>
                                                </div>
                                                <div class="progress" style="margin: 20px;">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                         aria-valuemin="0" aria-valuemax="100"
                                                         style="width:{{$item->Number_Transactions/$item->Threshold*100}}%; background-color: #14A989;">
                                                    </div>
                                                </div>
                                                <div class="row" style="font-size: 16px;">
                                                    <div class="col-md-12 text-center">
                                                        {{$item->Number_Transactions}} / {{$item->Threshold}} Orders
                                                        Placed <br><br>
                                                    </div>
                                                </div>
                                                <div class="display-group">
                                                    <div><p align="left" style="padding-left:10px">Order placed on
                                                            <b>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</b>
                                                        </p></div>
                                                </div>
                                                @feature('Cancel Purchase')
                                                <div class="display-group">
                                                    <button type="button" class="btn btn-primary btn-lg"
                                                            data-toggle="modal" data-target="#CancelModal">Cancel
                                                    </button>
                                                </div>
                                                @endfeature
                                                <div class="display-group">
                                                <form action="{{ route('review.store') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="itemId" value="{{ $item->id }}">
                                                    <input type="hidden" name="Supplier" value="{{ $item->Supplier}}" >
                                                    <div class="form-group">
                                                        <p>Rate this produc out of 5</p>
                                                        <input type="radio" name="Rating" value=1>1
                                                        <input type="radio" name="Rating" value=2>2
                                                        <input type="radio" name="Rating" value=3>3
                                                        <input type="radio" name="Rating" value=4>4
                                                        <input type="radio" name="Rating" value=5>5
                                                    </div>
                                                    <div class="form-group">
                                                        <p>Comment</p>
                                                        <textarea name="Comment" cols="30" rows="3"></textarea>
                                                    </div>
                                                    <input type="submit" value="Submit Review">
                                                </form>
                                            </div>
                                                <p></p>
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
                    <div class="col-md-7 col-md-offset-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">Past Transactions</div>
                            <div class="panel-body">
                                @if(count($items) > 0)
                                    @foreach($items as $item)
                                        @if($item->Status == 'expired' || $item->Status == 'threshold reached' || $item->Status == 'cancelled')
                                            <div style="border: 3px solid #ccfff0;">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <a href="item/{{$item->id}}">
                                                            <img alt="{{$item->Name}}" src="{{$item->Picture_URL}}"
                                                                 class="img-thumbnail"/>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-7" align="left">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h2 style="margin-top: 5px;">
                                                                    <a href="item/{{$item->id}}"> {{$item->Name}}</a>
                                                                </h2>
                                                                {{$item->Short_Description}}
                                                                <h3>
                                                                    ${{$item->Price}}
                                                                </h3>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <br>
                                                <div class="display-group">
                                                    <div><p align="left" style="padding-left:10px">Status:
                                                            <b>{{$item->Status}}</b></p></div>
                                                </div>
                                                <div class="display-group">
                                                    <div><p align="left" style="padding-left:10px">Sale ends
                                                            <b>{{\Carbon\Carbon::parse($item->End_Date)->format('d/m/Y')}}</b>
                                                        </p></div>
                                                </div>
                                                <div class="progress" style="margin: 20px;">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                         aria-valuemin="0" aria-valuemax="100"
                                                         style="width:{{$item->Number_Transactions/$item->Threshold*100}}%; background-color: #14A989;">
                                                    </div>
                                                </div>
                                                <div class="row" style="font-size: 16px;">
                                                    <div class="col-md-12 text-center">
                                                        {{$item->Number_Transactions}} / {{$item->Threshold}} Orders
                                                        Placed <br><br>
                                                    </div>
                                                </div>
                                                <div class="display-group">
                                                    <div><p align="left" style="padding-left:10px">Order placed on
                                                            <b>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</b>
                                                        </p></div>
                                                </div>
                                                <div class="display-group">
                                                <form action="{{ route('review.store') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="itemId" value="{{ $item->id }}">
                                                    <input type="hidden" name="Supplier" value="{{ $item->Supplier}}" >
                                                    <div class="form-group">
                                                        <p>Rate this produc out of 5</p>
                                                        <input type="radio" name="Rating" value=1>1
                                                        <input type="radio" name="Rating" value=2>2
                                                        <input type="radio" name="Rating" value=3>3
                                                        <input type="radio" name="Rating" value=4>4
                                                        <input type="radio" name="Rating" value=5>5
                                                    </div>
                                                    <div class="form-group">
                                                        <p>Comment</p>
                                                        <textarea name="Comment" cols="30" rows="3"></textarea>
                                                    </div>
                                                    <input type="submit" value="Submit Review">
                                                </form>
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


    @if(count($items) > 0)
        <div id="CancelModal" class="modal fade" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Are you sure you want to cancel this purchase?</h3>
                    </div>
                    <div class="modal-body">
                        <p><strong>Item details: </strong></p>
                        <p>
                            {{$item->Name}}
                            <br> Price: {{$item->Price}}$
                        </p>
                    </div>
                    <div class="modal-footer">
                        {!! Form::open(['action' => ['TransactionsController@destroy', $item->id], 'method' => 'POST']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Confirm', ['class' => 'btn btn-primary'])}}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Return</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

    @endif
@endsection