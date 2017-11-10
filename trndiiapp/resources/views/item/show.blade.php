
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


    <div class="row">
        <div class="col-md-2">

                {{$item->Price}} $

        </div>
        <div class="col-md-2 col-md-offset-8 ">

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
        </div>
    </div>

        <hr>

    <img alt="Bootstrap Image Preview" src="http://lorempixel.com/140/140/" class="img-responsive center-block" />

             <hr>

     <div class="row">
                <div class="col-md-4 text-center">

                        <strong>{{$item->Name}}</strong>

                </div>
                <div class="col-md-4 text-center">

                        Shipping time: 1 month

                </div>
                <div class="col-md-4 text-center">

                        Tokens gained: {{$item->Tokens_Given}}

                </div>
     </div>
             <hr>
             <h4 class="text-center">
                 Time remaining for sale
             </h4>

             <hr>

             <div class="progress">
                 <div class="progress-bar" role="progressbar" aria-valuenow="70"
                      aria-valuemin="0" aria-valuemax="100" style="width:70%">
                     70%
                 </div>
             </div>

             <hr>



             <hr>

            <p>
                {{$item->Long_Description}}
            </p>


         </div>
         <div class="col-md-offset-2">

         </div>
     </div>
 </div>




@endsection
