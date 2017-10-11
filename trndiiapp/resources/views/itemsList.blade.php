@extends('layouts.app')

@section('content')
<ul>
    @foreach($items as $item )
        <li>
            {{$item}}
        </li>
    @endforeach
</ul>
@endsection
