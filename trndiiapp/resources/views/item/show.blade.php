
@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>

@endsection

@section('content')

    <!--
    <h1>{{$item->Name}}</h1>
    <p>Price :{{$item->Price}}</p>
    <p>Threshold: {{$item->Threshold}}</p>
    <p>Tokens given: {{$item->Tokens_Given}}</p>
    <p>Short Description: {{$item->Short_Description}}</p>
    <p>Long Description: {{$item->Long_Description}}</p>
    <p>Start Date: {{$item->Start_Date}}</p>
    <p>End Date: {{$item->End_Date}}</p>


    @if($checkCommit == 0 && $item->Threshold > $item->Number_Transaction)
    {!! Form::open(['action' => ['TransactionsController@update', $item->id], 'method' => 'POST']) !!}
    {{Form::hidden('_method', 'PUT')}}
    {{Form::submit('Purchase', ['class' => 'btn btn-primary', 'onclick' => 'return confirm("Are you sure you want to commit to this purchase?");'])}}
    {!! Form::close() !!}
    @elseif($item->Threshold <= $item->Number_Transactions)
        <p>The threshold for this item has already been reached. Sorry!</p>
    @else
        <p>You have already commited to this item. Stay tuned!</p>    
    @endif

    -->
 <div class="container" style="background-color:white ">
     <div class="row">
         <div class="col-md-offset-2 col-md-8">
            <img alt="{{$item->Name}}" src= "{{$item->Picture_URL}}" class="img-responsive center-block" style="margin-bottom: 20px;"/>

            <div class="row" style="font-size: 40px;">
                <div class="col-md-12 text-center">
                    <strong>{{$item->Name}}</strong>
                </div>
            </div>
            <div class="row" style="font-size: 20px;">
                <div class="col-md-4 text-center">
                    Price: ${{$item->Price}}
                </div>
                <div class="col-md-4 text-center">
                    Tokens gained: {{$item->Tokens_Given}}
                </div>
                @if((\Carbon\Carbon::parse($item->End_Date))->diffInHours(\Carbon\Carbon::now()) > 48)
                <div class="col-md-4 text-center">
                    Days Remaining: {{ (\Carbon\Carbon::parse($item->End_Date))->diffInDays(\Carbon\Carbon::now())}}
                </div>
                @else
                <div class="col-md-4 text-center">
                    Hours Remaining: {{ (\Carbon\Carbon::parse($item->End_Date))->diffInHours(\Carbon\Carbon::now())}}
                </div>
                @endif
            </div>

            <div class="progress" style="margin: 20px;">
                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                    aria-valuemin="0" aria-valuemax="100" style="width:{{$item->Number_Transactions/$item->Threshold*100}}%; background-color: #14A989;">
                    {{$item->Number_Transactions}} / {{$item->Threshold}} Orders Placed
                </div>
            </div>

            <p>
                {{$item->Long_Description}}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="text-align: center; margin-bottom: 30px; margin-top: 10px;">

            @if($checkCommit == 0 && $item->Threshold > $item->Number_Transaction)
                {!! Form::open(['action' => ['TransactionsController@update', $item->id], 'method' => 'POST']) !!}
                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Purchase', ['class' => 'btn btn-success', 'onclick' => 'return confirm("Are you sure you want to commit to this purchase?");'])}}
                {!! Form::close() !!}
            @elseif($item->Threshold <= $item->Number_Transactions)
                <p>The threshold for this item has already been reached. Sorry!</p>
            @else
                <p>You have already commited to this item. Stay tuned!</p>
            @endif
        </div>
    </div>
 </div>




@endsection
