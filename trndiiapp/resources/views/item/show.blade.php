@extends('layouts.app')

@section('content')

    <div class="container" style="background-color:white ">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <img alt="{{$item->Name}}" src="{{$item->Picture_URL}}" class="img-responsive center-block"
                     style="margin-bottom: 20px;"/>

                <div class="row" style="font-size: 40px;">
                    <div class="col-md-12 text-center">
                        <strong>{{$item->Name}}</strong>
                    </div>
                </div>
                <div class="row" style="font-size: 20px;">
                    <div class="col-md-12 text-center">
                        <strong>Supplied by {{$item->Supplier}}</strong>
                    </div>
                </div>
                <div class="row" style="font-size: 20px;">
                    <div class="col-md-4 text-center">
                        Price: ${{$item->Price}}
                    </div>
                    <div class="col-md-4 text-center">
                        @if(Auth::user()->segment == "Token")
                            Tokens gained: {{$item->Tokens_Given}}
                        @endif
                    </div>
                    @if((\Carbon\Carbon::parse($item->End_Date))->diffInHours(\Carbon\Carbon::now()) > 48)
                        <div class="col-md-4 text-center">
                            Days
                            Remaining: {{ (\Carbon\Carbon::parse($item->End_Date))->diffInDays(\Carbon\Carbon::now())}}
                        </div>
                    @else
                        <div class="col-md-4 text-center">
                            Hours
                            Remaining: {{ (\Carbon\Carbon::parse($item->End_Date))->diffInHours(\Carbon\Carbon::now())}}
                        </div>
                    @endif
                </div>

                <!--Progress bar that fills when users commit to the item (and thus Number_Transaction increments) The text is not in the bar because
                Bootstrap has issues when the bar is at low % and doesn't display all the text.-->
                <div class="progress" style="margin: 20px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70"
                         aria-valuemin="0" aria-valuemax="100"
                         style="width:{{$item->Number_Transactions/$item->Threshold*100}}%; background-color: #14A989;">
                    </div>
                </div>

                <div class="row" style="font-size: 20px;">
                    <div class="col-md-12 text-center">
                        {{$item->Number_Transactions}} / {{$item->Threshold}} Orders Placed
                    </div>
                </div>

                <div class="row" style="font-size: 18px;">
                    <div class="col-md-12 text-center">
                        Item ships to {{$item->Shipping_To}}
                    </div>
                </div>

                <p>
                    {{$item->Long_Description}}
                </p>

                <div class="row" style="font-size: 20px;">
                    <div class="col-md-12 text-center">
                        @if(Auth::user())
                            @if(!(strpos($item->Shipping_To, Auth::user()->country)!==false))
                                <p style="background-color:#ffb049; color:black">
                                    <strong> Warning! This item does not ship to your country! </strong>
                                </p>
                            @endif
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="text-align: center; margin-bottom: 30px; margin-top: 10px;">
                @if(Auth::user())
                    @if(Auth::user()->segment == "Basic")
                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#BuyModal">
                            Purchase
                        </button>
                    @elseif(Auth::user()->segment == "Token")
                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#BuyModalTokens">
                            Token Purchase
                        </button>
                    @endif

                @else
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#BuyModal">Login
                        To Purchase
                    </button>
                @endif
            </div>
        </div>

    <div class="row">
        <div class="col-md-12" style="text-align: center; margin-bottom: 30px; margin-top: 10px;">
        <h3>User Reviews</h3>
        </div>
        @if(count($itemReviews) > 0)
            @foreach($itemReviews as $itemReview)
                <div class="col-md-12" style="text-align: left; margin-bottom: 30px; margin-top: 10px;">
                
                <h4>Rating: {{$itemReview->rating}}/5</h4>
                <h4>By <font color="#14A989">{{$itemReview->user_name}}</font> on {{ Carbon\Carbon::parse($itemReview->created_at)->format('F d, Y')}}</h4>
                <p>{{$itemReview->comment}}</p>
                <p>Likes: {{$itemReview->likes}}</p>
                <p>Dislikes: {{$itemReview->dislikes}}</p>
                <form action="{{ route('review.storeLikeDislike') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="reviewId" value="{{$itemReview->id}}">
                    <input type="submit" value="Like" name="LikeSubmit">
                </form>
                <br>
                <form action="{{ route('review.storeLikeDislike') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="reviewId" value="{{$itemReview->id}}">
                    <input type="submit" value="Dislike" name="DislikeSubmit">
                </form>
                </div>
            @endforeach
        @else
        <div class="col-md-12" style="text-align: center; margin-bottom: 30px; margin-top: 10px;">
            <h4>No reviews have been made for this item.</h4>
        </div>
        @endif
    </div>

    <!--Purchase button. When it is pressed it pops up a modal where user confirms their purchase.-->
        <div id="BuyModal" class="modal fade" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    @if(Auth::user())
                        <div class="modal-header">
                            <h3 class="modal-title">Are you sure you want to commit to this purchase?</h3>
                        </div>
                        <div class="modal-body">

                            @if(!(strpos($item->Shipping_To, Auth::user()->country)!==false))
                                <p>
                                    <strong> This item does not ship to {{Auth::user()->country}}! </strong>
                                    <!-- Remove this if/when we implement choosing shipping address-->
                                </p>
                            @else
                                <p><strong>Item details: </strong></p>
                                <p>
                                    {{$item->Name}}
                                    <br> Price: {{$item->Price}}$
                                    <br> Tokens Gained: {{$item->Tokens_Given}}
                                <!--
                    @if(!(strpos($item->Shipping_To, Auth::user()->country)!==false))
                                    <br> <strong> Warning! This item does not ship to {{Auth::user()->country}} </strong>
                    @endif
                                        -->
                                </p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            @if(strpos($item->Shipping_To, Auth::user()->country)!=false)
                                <button type="button" class="btn btn-default" data-dismiss="modal">Return</button>
                            @else
                                @if($checkCommit == 0 && $item->Threshold > $item->Number_Transaction)
                                    {!! Form::open(['action' => ['TransactionsController@createTransaction', $item->id], 'method' => 'POST']) !!}
                                    {{Form::hidden('_method', 'PUT')}}
                                    {{Form::submit('Confirm', ['class' => 'btn btn-primary'])}}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Return</button>
                                    {!! Form::close() !!}
                                @elseif($item->Threshold <= $item->Number_Transactions)
                                    <p>The threshold for this item has already been reached. Sorry!</p>
                                @else
                                    <p>You have already commited to this item. Stay tuned!</p>
                                @endif
                            @endif
                        </div>

                    @else
                        <div class="modal-header">
                            <h3 class="modal-title">Please login to continue.</h3>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password"
                                               required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Login
                                        </button>

                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>


        <div class="col-md-12 text-center">
            <h3>
                Comments
            </h3>
            <br>
            <!--Comment Box-->
            <div class="row">
                <div id="comment-form" class="col-md-8 col-md-offset-2">
                    {{ Form::open(['route' => ['ItemController.addComment', $item->id, "itemShow"], 'method' => 'POST']) }}
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

    <!--Modal with tokens-->
        <div id="BuyModalTokens" class="modal fade" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    @if(Auth::user())
                        <div class="modal-header">
                            <h3 class="modal-title">Are you sure you want to commit to this purchase?</h3>
                        </div>
                        <div class="modal-body">

                            @if(!(strpos($item->Shipping_To, Auth::user()->country)!==false))
                                <p>
                                    <strong> This item does not ship to {{Auth::user()->country}}! </strong>
                                    <!-- Remove this if/when we implement choosing shipping address-->
                                </p>
                            @else
                                <p><strong>Item details: </strong></p>
                                <p>
                                    {{$item->Name}}
                                    <br> Price: {{$item->Price}}$
                                    <br> Tokens Gained: {{$item->Tokens_Given}}
                                <!--
                    @if(!(strpos($item->Shipping_To, Auth::user()->country)!==false))
                                    <br> <strong> Warning! This item does not ship to {{Auth::user()->country}} </strong>
                    @endif
                                        -->
                                </p>
                            @endif
                        </div>
                        <div class="modal-footer">

                            @if(!(strpos($item->Shipping_To, Auth::user()->country)!==false))
                                <button type="button" class="btn btn-default" data-dismiss="modal">Return</button>
                            @else
                                @if($checkCommit == 0 && $item->Threshold > $item->Number_Transaction)
                                    <button type="button" class="btn btn-primary"
                                            onclick="location.href='{{ url('/confirm/' .$item->id) }}'">Go to
                                        confirmation
                                    </button>

                                    <button type="button" class="btn btn-default" data-dismiss="modal">Return</button>
                                @elseif($item->Threshold <= $item->Number_Transactions)
                                    <p>The threshold for this item has already been reached. Sorry!</p>
                                @else
                                    <p>You have already committed to this item. Stay tuned!</p>
                                @endif
                            @endif
                        </div>

                    @else
                        <div class="modal-header">
                            <h3 class="modal-title">Please login to continue.</h3>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password"
                                               required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Login
                                        </button>

                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
