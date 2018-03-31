@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="panel-heading">Reviews for item: <a href="/item/{{$item->id}}"><strong>{{ $item->Name }}</strong></a></div>

        <div class="panel-body">

            @if($reviewsForSupplier->count() > 0)
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>User Name</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Likes</th>
                    <th>Dislikes</th>
                    <th>Timestamp</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reviewsForSupplier as $review)
                    <tr>
                        <td>{{ $review->user_name }}</td>
                        <td>
                            @for($i = 0; $i < $review->rating; $i++)
                                <span class="glyphicon glyphicon-star" value="1"><p hidden="hidden">1</p></span>
                            @endfor
                            @for($i = $review->rating; $i < 5; $i++)
                                <span class="glyphicon glyphicon-star-empty" value="1"><p hidden="hidden">1</p></span>
                            @endfor
                        </td>
                        <td>{{ $review->comment }}</td>
                        <td>{{ $review->likes }}</td>
                        <td>{{ $review->dislikes }}</td>
                        <td>{{ $review->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @else
                <p>No reviews were left for this product.</p>
            @endif
        </div>
    </div>
@endsection