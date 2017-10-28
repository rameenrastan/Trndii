@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')

    <div class="panel-heading">ADMIN Dashboard</div>

        <div class="panel-body">
            You are logged in as ADMIN
            <a href="/item/create">Click here to add item</a>
        </div>
    </div>
@endsection
