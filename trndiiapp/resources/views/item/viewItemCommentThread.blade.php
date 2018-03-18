@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="col-md-12 text-center">
        <h3>
            Comments on <font color="#14A989"><strong>{{$item->Name}}</strong></font>
        </h3>
        <br>
        <!--Comment Box-->
        <div class="row">
            <div id ="comment-form"  class="col-md-8 col-md-offset-2">
                {{ Form::open(['route' => ['ItemController.addComment', $item->id, "itemCommentThreadOnly"], 'method' => 'POST']) }}
                <div class="row">
                    <div class="col-md-12">
                        {{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5', 'columns' => '5', 'placeholder' => 'Leave a comment...', 'resize' => 'none']) }}

                        {{ Form::submit('Add Comment', ['class' => 'btn btn-success', 'style' => 'margin-top:15px']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <br>
    </div>

    <!--Displaying all comments -->
        @if (count($itemComments) > 0)
            <div class="col-md-8 col-md-offset-2">
            <p style="font-weight: bold; color: #14A989;">
                {{count($itemComments)}}
                @if (count($itemComments) > 1)
                    comments
                @else
                    comment
                @endif
            </p>

                @foreach($itemComments->reverse() as $com)
                <hr>
                    <div>
                        <p>
                            <font style="font-weight: bold; line-height: 200%;">{{ $com->username }}</font> &nbsp {{ Carbon\Carbon::parse($com->created_at)->diffForHumans()}}                           
                        </p>
                        <p>{{ $com->comment }} </p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="col-md-12 text-center">
                <br>
                <h4 class="row">
                    No comments have been made for this item
                </h4>
            </div>
        @endif
    </div>
@endsection
