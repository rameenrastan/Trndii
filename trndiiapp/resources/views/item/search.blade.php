@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Results</b></div>
                    @if(count($items) > 0)
                    <div class="panel-heading"><b>Filters</b>
                        <form action="{{ route('items.ascendingPrice') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="search" value="{{$search}}">
                            <input type="submit" value="Ascending Price">
                        </form>
                        <form action="{{ route('items.descendingPrice') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="search" value="{{$search}}">
                            <input type="submit" value="Descending Price">
                        </form>
                        <form action="{{ route('items.newestToOldest') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="search" value="{{$search}}">
                            <input type="submit" value="Newest Items">
                        </form>
                        <form action="{{ route('items.oldestToNewest') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="search" value="{{$search}}">
                            <input type="submit" value="Oldest Items">
                        </form>
                        <form action="{{ route('items.highestRatings') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="search" value="{{$search}}">
                            <input type="submit" value="Highest Ratings">
                        </form>
                        <form action="{{ route('items.lowestRatings') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="search" value="{{$search}}">
                            <input type="submit" value="Lowest Ratings">
                        </form>
                    </div>
                    @endif
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>
                            <span style='font-weight: bold;'>
                                Browsing Items <font style="font-size: 20px;">(Total: {{count($items)}})</font>
                            </span>
                                </h2>
                            </div>
                        </div>
                        <br>

                        <div class="panel-body" style="padding: 25px">
                            @if(count($items) > 0)
                                <?php $counter = 1 ?>

                                @foreach($items as $item)
                                    @if($counter % 4 == 1)
                                        <div class="row is-flex">
                                    @endif

                                    <div class="col-md-3 col-sm-6"
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
                                                            <input class="btn" type="submit" value="Go to page"
                                                                   style="color: white; background-color: #14A989;"/>
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
                                        <div class="display-group">
                                            <div><p align="left" style="padding-left:10px">Ratings:
                                                    @if($item->Rating > 0)
                                                    <b>{{$item->Rating}} / 5</b></p></div>
                                                    @else
                                                    <b>No Ratings</b></p></div>
                                                    @endif
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
                                                    <input class="btn" type="submit"
                                                           value="View comments for this item"/>
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
                                <p>There are currently no items matching your search.</p>
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
@endsection
