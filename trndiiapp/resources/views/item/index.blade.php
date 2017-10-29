@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')
    <h1>Items</h1>
    @if(count($items)>0)

        @foreach($items as $item)
            <div class="well">
                <h6>
                    <a href="item/{{$item->id}}"> {{$item->Name}}</a>
                </h6>
            </div>
            @endforeach

        {{$items->links()}}
            @else
                <p>No items in database</p>
            @endif

@endsection
