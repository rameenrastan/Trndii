@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>Browse Items By Category</h2>
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">All</a></li>
            @for($i = 0; $i < count($categories); $i++)
                <li><a data-toggle="pill" href="#menu{{$i + 1}}">{{$categories[$i]}}</a></li>
            @endfor
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">All Items</div>
                            <div class="panel-body" style="padding: 25px">
                                @if(count($items) > 0)
                                    <?php $counter = 1 ?>

                                    @foreach($items as $item)
                                        @if($counter % 4 == 1)
                                            <div class="row is-flex">
                                                @endif

                                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"
                                                     style="border: 3px solid #ccfff0; padding: 15px;">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <a href="item/{{$item->id}}">
                                                                <img alt="{{$item->Name}}" src="{{$item->Picture_URL}}"
                                                                     class="img-thumbnail"/>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-12" align="center">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h2 style="margin-top: 5px;">
                                                                        <a href="item/{{$item->id}}"> {{$item->Name}}</a>
                                                                    </h2>
                                                                    {{$item->Short_Description}}
                                                                    <h3>
                                                                        ${{$item->Price}}
                                                                    </h3>
                                                                    <form action="item/{{$item->id}}">
                                                                        <input class="btn" type="submit" value="Go to page" style="color: white; background-color: #14A989;"/>
                                                                    </form>
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
                                                    <div class="display-group">
                                                        <div><p align="left" style="padding-left:10px">Category:
                                                                <b>{{$item->Category}}</b></p></div>
                                                    </div>
                                                    <div class="progress" style="margin: 20px;">
                                                        <div class="progress-bar" role="progressbar"
                                                             aria-valuenow="70"
                                                             aria-valuemin="0" aria-valuemax="100"
                                                             style="width:{{$item->Number_Transactions/$item->Threshold*100}}%; background-color: #14A989;">
                                                        </div>
                                                    </div>
                                                    <div class="row" style="font-size: 16px;">
                                                        <div class="col-md-12 text-center">
                                                            {{$item->Number_Transactions}} / {{$item->Threshold}}
                                                            Orders Placed
                                                            <br><br>
                                                        </div>
                                                    </div>
                                                    <div class="display-group">
                                                        <div>
                                                            <form action="{!! route('ItemController', ['itemid'=>$item->id]) !!}">
                                                                <input class="btn btn-default" type="submit" value="View comments"/>
                                                            </form>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <div class="display-group">
                                                        <div>
                                                            <p align="left" style="padding-left:10px">Order placed
                                                                on
                                                                <b>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if(++$counter % 4 == 1)
                                            </div>
                                        @endif
                                    @endforeach
                                    @if($counter % 4 != 1)
                            </div>
                            @endif
                            @else
                                <p>There are currently no items.</p>
                            @endif

                            @if($items->count()>0)
                                <div>
                                    {{ $items->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @for($i = 0; $i < count($categories); $i++)
            <div id="menu{{$i + 1}}" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">{{$categories[$i]}}</div>
                            <div class="panel-body" style="padding: 25px;">
                                @if(count($items->where('Category', $categories[$i])) > 0)
                                    <?php $counter = 1 ?>
                                    @foreach($items->where('Category', $categories[$i]) as $item)
                                        @if($item->Category == $categories[$i])
                                            @if($counter % 4 == 1)
                                                <div class="row is-flex">
                                                    @endif

                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"
                                                         style="border: 3px solid #ccfff0; padding: 15px;">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <a href="item/{{$item->id}}">
                                                                    <img alt="{{$item->Name}}" src="{{$item->Picture_URL}}"
                                                                         class="img-thumbnail"/>
                                                                </a>
                                                            </div>
                                                            <div class="col-md-12" align="center">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <h2 style="margin-top: 5px;">
                                                                            <a href="item/{{$item->id}}"> {{$item->Name}}</a>
                                                                        </h2>
                                                                        {{$item->Short_Description}}
                                                                        <h3>
                                                                            ${{$item->Price}}
                                                                        </h3>
                                                                        <form action="item/{{$item->id}}">
                                                                            <input class="btn" type="submit" value="Go to page" style="color: white; background-color: #14A989;"/>
                                                                        </form>
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
                                                        <div class="display-group">
                                                            <div><p align="left" style="padding-left:10px">Category:
                                                                    <b>{{$item->Category}}</b></p></div>
                                                        </div>
                                                        <div class="progress" style="margin: 20px;">
                                                            <div class="progress-bar" role="progressbar"
                                                                 aria-valuenow="70"
                                                                 aria-valuemin="0" aria-valuemax="100"
                                                                 style="width:{{$item->Number_Transactions/$item->Threshold*100}}%; background-color: #14A989;">
                                                            </div>
                                                        </div>
                                                        <div class="row" style="font-size: 16px;">
                                                            <div class="col-md-12 text-center">
                                                                {{$item->Number_Transactions}} / {{$item->Threshold}}
                                                                Orders Placed
                                                                <br><br>
                                                            </div>
                                                        </div>
                                                        <div class="display-group">
                                                            <div>
                                                                <form action="{!! route('ItemController', ['itemid'=>$item->id]) !!}">
                                                                    <input class="btn btn-default" type="submit" value="View comments"/>
                                                                </form>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="display-group">
                                                            <div>
                                                                <p align="left" style="padding-left:10px">Order placed
                                                                    on
                                                                    <b>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</b>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if(++$counter % 4 == 1)
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                    @if($counter % 4 != 1)
                            </div>
                            @endif
                            @else
                                <p>There are currently no items.</p>
                            @endif

                            @if($items->count()>0)
                                <div>
                                    {{ $items->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </div>

    @endfor
    </div>

@endsection