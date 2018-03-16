@extends('layouts.app')

@section('content')

    <div class="col-md-8 col-md-offset-2">
    @foreach($itemComments as $com)
        <p>{{ $com->comment }} </p>
        <p>{{ $com->username }} </p>
        <br/>
        <br/>
    @endforeach

    </div>


    <div class="row">
        <div id ="comment-form"  class="col-md-8 col-md-offset-2">


            {{ Form::open(['route' => ['ItemController.addComment', $item->id], 'method' => 'POST']) }}

            <div class="row">

                <div class="col-md-12">
                    {{ Form::label('comment', "Comment:") }}
                    {{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}

                    {{ Form::submit('Add Comment', ['class' => 'btn btn-success btn-block', 'style' => 'margin-top:15px;']) }}
                </div>
            </div>

            {{ Form::close() }}



        </div>
    </div>
@endsection