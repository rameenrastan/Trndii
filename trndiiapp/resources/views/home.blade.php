@extends('layouts.app')

@section('content')
    <!-- Load non-dynamic html in case that the items table is empty. -->
    @if(count($items) == 0)
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <img src="images/logo_full.png" width="100%">

                        @test('teaser1')
                        <h3 align="center">
                             Welcome to Trndii! If you're not sure where to start, click <a href="#"> here </a>
                        </h3>
                        @endtest

                        @test('teaser2')
                        <h3 align="center">
                            Welcome to Trndii! Click here for more information <a href="#"> here </a>
                        </h3>
                        @endtest
                    </div>
                    <div class="panel-body" style="border:none;">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h2 align="center" style="margin-top: 0;">
                            Featured Items
                        </h2>
                        <div class="col-md-12">
                            <div class="thumbnail">
                                <a href="#" target="_blank">
                                    <img src="images/placeholders/botw_wide.jpg" alt="PLACEHOLDER" style="width:100%">
                                </a>
                                <div class="caption" style="position: relative">
                                    <p>
                                        Breath of the Wild: Explorer's Edition.<br>
                                        Threshold: 20
                                    </p>
                                    <button type="button" class="btn btn-success" href="#">More Info</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="thumbnail">
                                    <a href="#" target="_blank">
                                        <img src="images/placeholders/inteli9.jpg" alt="PLACEHOLDER"
                                             style="width:100%;">
                                    </a>
                                    <div class="caption" style="position: relative">
                                        <p>
                                            Intel<sup>&reg;</sup> CORE<sup>&trade;</sup> i9 EXTREME Processor.<br>
                                            Threshold: 12
                                        </p>
                                        <button type="button" class="btn btn-success" href="#">More Info</button>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="thumbnail">
                                    <a href="#" target="_blank">
                                        <img src="images/placeholders/iphonex.jpg" alt="PLACEHOLDER"
                                             style="width: 100%;">
                                    </a>
                                    <div class="caption" style="position: relative">
                                        <p>
                                            iPhone X.<br>
                                            Threshold: 40
                                        </p>
                                        <a href = "">
                                        <button type="button" class="btn btn-success" href="#">More Info</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 align="left" style="margin-top: 0;">
                            <a href="/item">
                                See more items...
                            </a>
                        </h4>
                    </div>
                    <!-- END of class-panel-body -->
                </div>
            </div>
        </div>
    </div>
    <!-- Load dynamic html when items table is populated. -->
    @else
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <img src="images/logo_full.png" width="100%">
                        @test('teaser1')
                        <h3 align="center">
                             Welcome to Trndii! If you're not sure where to start, click <a href="#"> here </a>
                        </h3>
                        @endtest

                        @test('teaser2')
                        <h3 align="center">
                            Welcome to Trndii! Click here for more information <a href="#"> here </a>
                        </h3>
                        @endtest
                    </div>

                    <div class="panel-body" style="border:none;">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <!-- Start of Featured Items (highest number of transactions) -->
                        <div class="col-md-12" style="margin-bottom: 10px;">
                            <h2 align="center" style="margin-top: 0;">
                                Featured Items
                            </h2>
                        </div>
                        <div class="col-md-12">
                            <div class="thumbnail">
                                <a href="item/{{$items[0]->id}}" target="_blank">
                                    <img src="{{$items[0]->Picture_URL}}" alt="PLACEHOLDER" style="width:100%">
                                </a>
                                <div class="caption" style="position: relative">
                                    <p>
                                        {{$items[0]->Name}}<br>
                                        Threshold: {{$items[0]->Threshold}}
                                    </p>
                                    <button type="button" class="btn btn-success" onclick="window.location.href='item/{{$items[0]->id}}'">More Info</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @for($i = 1; $i < count($items); $i++)
                                <div class="col-md-6">
                                    <div class="thumbnail">
                                        <a href="item/{{$items[$i]->id}}" target="_blank">
                                            <img src="{{$items[$i]->Picture_URL}}" alt="PLACEHOLDER"
                                                style="width:100%;">
                                        </a>
                                        <div class="caption" style="position: relative">
                                            <p>
                                                {{$items[$i]->Name}}<br>
                                                Threshold: {{$items[$i]->Threshold}}
                                            </p>
                                            <a href="item/{{$items[$i]->id}}">
                                            <button type="button" class="btn btn-success">More Info</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="panel-body" style="border:none;">
                        <!-- Start of Newest Items -->
                        <div class="col-md-12" style="margin-bottom: 10px;">
                            <h2 align="center" style="margin-top: 0;"><!-- Start of Featured Items (highest number of transactions) -->
                                Check Out These New Additions!
                            </h2>
                        </div>
                        <div class="row">
                            @for($i = 0; $i < count($itemsNewest)-2; $i++)
                                <div class="col-md-6">
                                    <div class="thumbnail">
                                        <a href="item/{{$itemsNewest[$i]->id}}" target="_blank">
                                            <img src="{{$itemsNewest[$i]->Picture_URL}}" alt="PLACEHOLDER"
                                                style="width:100%;">
                                        </a>
                                        <div class="caption" style="position: relative">
                                            <p>
                                                {{$itemsNewest[$i]->Name}}<br>
                                                Threshold: {{$itemsNewest[$i]->Threshold}}
                                            </p>
                                            <a href="item/{{$itemsNewest[$i]->id}}">
                                            <button type="button" class="btn btn-success">More Info</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for($i = 2; $i < count($itemsNewest); $i++)
                                <div class="col-md-6">
                                    <div class="thumbnail">
                                        <a href="item/{{$itemsNewest[$i]->id}}" target="_blank">
                                            <img src="{{$itemsNewest[$i]->Picture_URL}}" alt="PLACEHOLDER"
                                                style="width:100%;">
                                        </a>
                                        <div class="caption" style="position: relative">
                                            <p>
                                                {{$itemsNewest[$i]->Name}}<br>
                                                Threshold: {{$itemsNewest[$i]->Threshold}}
                                            </p>
                                            <a href="item/{{$itemsNewest[$i]->id}}">
                                            <button type="button" class="btn btn-success">More Info</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <h4 align="left" style="margin-top: 0;">
                            <a href="/item">
                                See more items...
                            </a>
                        </h4>
                    </div>
                    <!-- END of class-panel-body -->
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection