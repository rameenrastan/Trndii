@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12 text-center">
            <h3>
                Comments on <strong><a href="../item/{{$item->id}}"> {{$item->Name}}</a></strong>
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
                Displaying 
                {{1 + $itemComments->perPage() * ($itemComments->currentPage() - 1)}}
                - 
                {{($itemComments->currentPage() - 1) * $itemComments->perPage() + count($itemComments)}}
                of 
                {{$itemComments->total()}} 
                @if (($itemComments->total()) > 1)
                    comments
                @else
                    comment
                @endif
            </p>

                @foreach($itemComments as $com)
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
        @if($itemComments->count()>0)
            <div>
                {{ $itemComments->links() }}
            </div>
        @endif
    </div>
@endsection
