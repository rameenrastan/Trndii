@extends('layouts.app')

@section('content')
    {{--<h1>Purchase History</h1>--}}




    {{--@if(count($items) > 0)--}}
        {{--@foreach($items as $gas)--}}
        {{--<div>{{$gas->Name}}</div>--}}
        {{--<div>{{$gas->Price}}</div>--}}
        {{--<div>{{$gas->Bulk_Price}}</div>--}}
        {{--<div>{{$gas->Short_Description}}</div>--}}
        {{--<div>{{$gas->Start_Date}}</div>--}}
        {{--<div>{{$gas->End_Date}}</div>--}}
        {{--@endforeach--}}

    {{--@else--}}
        {{--<p>You have yet to purchase an item!</p>--}}
    {{--@endif--}}


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Purchase History</div>

                    <div class="panel-body">






                        @if(count($items) > 0)
                        @foreach($items as $gas)
                                <div class="display-group">
                                    <h4><b>Name</b></h4>
                                    <div>{{$gas->Name}}</div>
                                    <br/>
                                </div>
                                <div class="display-group">
                                    <h4><b>Bulk Price</b></h4>
                                    <div>{{$gas->Bulk_Price}}</div>
                                    <br/>
                                </div>
                                <div class="display-group">
                                    <h4><b>Short Description</b></h4>
                                    <div>{{$gas->Short_Description}}</div>
                                    <br/>
                                </div>
                                <div class="display-group">
                                    <h4><b>Start Date</b></h4>
                                    <div>{{$gas->Start_Date}}</div>
                                    <br/>
                                </div>
                                <div class="display-group">
                                    <h4><b>EndDate</b></h4>
                                    <div>{{$gas->End_Date}}</div>
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
                        <p>You have yet to purchase an item!</p>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection