
@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')
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

@endsection
