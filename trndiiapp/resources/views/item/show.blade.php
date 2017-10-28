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

@endsection
