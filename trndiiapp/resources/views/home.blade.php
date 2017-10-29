@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        
                    You are logged in!

                        <br>
                        <a href="item">BROWSE ITEMS</a>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
