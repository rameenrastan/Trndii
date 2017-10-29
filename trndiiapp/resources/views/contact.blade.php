@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@section ('content')

    <div class="container"/>
    <h1>Contact us</h1>
    <form method="post" action="{{url('contact')}}">
        {{csrf_field()}}
        <div class="form-group">
            <label name="email">Email: </label>
            <input id="email" name="email" class="form-control">
        </div>

        <div class="form-group">
            <label name="subject">Subject: </label>
            <input id="subject" name="subject" class="form-control">
        </div>

        <div class="form-group">
            <label name="message">Message: </label>
            <textarea id="message" name="message" class="form-control">Type message here</textarea>
        </div>

        <input type="submit" value="Send Message" class="btn btn-success">
    </form>
    </div>

@endsection