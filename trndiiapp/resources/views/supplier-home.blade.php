@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')

    <div class="panel-heading">Supplier Homepage</div>

        <div class="panel-body">
            You are logged in as a supplier
            <br>
            <a href="/supplier/items">Click here to view your items' progress</a>
        </div>
    </div>
@endsection
