<?php
$review = \App\Review::where('item_id', $item->id)->where('user_name', Auth::user()->name)->first();
?>

@if(!$review)
    <div class="display-group">
        <form action="{{ route('review.store') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="itemId" value="{{ $item->id }}">
            <input type="hidden" name="Supplier" value="{{ $item->Supplier}}">
            <div class="form-group">
                <p>Rate this product out of 5</p>
                <div>
                    <span class="star_1 ratings-stars glyphicon glyphicon-star-empty" value="1"><p hidden="hidden">1</p></span>
                    <span class="star_2 ratings-stars glyphicon glyphicon-star-empty" value="2"><p hidden="hidden">2</p></span>
                    <span class="star_3 ratings-stars glyphicon glyphicon-star-empty" value="3"><p hidden="hidden">3</p></span>
                    <span class="star_4 ratings-stars glyphicon glyphicon-star-empty" value="4"><p hidden="hidden">4</p></span>
                    <span class="star_5 ratings-stars glyphicon glyphicon-star-empty" value="5"><p hidden="hidden">5</p></span>
                </div>

                <input name="Rating" type="number" hidden="hidden" required="required">
            </div>
            <div class="form-group">
                <p>Comment</p>
                <textarea name="Comment" cols="30" rows="3" maxlength="191" style="resize: none;"></textarea>
            </div>
            <input type="submit" value="Submit Review" class="btn btn-success">
        </form>
    </div>
@else
    You already left a review for this product.

    @for($i = 0; $i < $review->rating; $i++)
        <span class="glyphicon glyphicon-star" value="1"><p hidden="hidden">1</p></span>
    @endfor
    @for($i = $review->rating; $i < 5; $i++)
        <span class="glyphicon glyphicon-star-empty" value="1"><p hidden="hidden">1</p></span>
    @endfor
@endif

@section('scripts')
    <script type="text/javascript">
        var clicked = false;

        $('.ratings-stars').click(
            // Handles the mouse click
            function () {
                $(this).removeClass('glyphicon-star-empty');
                $(this).addClass('glyphicon-star');
                $(this).prevAll().removeClass('glyphicon-star-empty');
                $(this).prevAll().addClass('glyphicon-star');
                $(this).nextAll().removeClass('glyphicon-star');
                $(this).nextAll().addClass('glyphicon-star-empty');
                $('[name="Rating"]').val($(this).text());
                $('[name="sendReview"]').removeClass('btn-disabled');
                $('[name="sendReview"]').addClass('btn-primary');
                clicked = true;
            }
        );

        $('.ratings-stars').hover(
            // Handles the on mouse enter
            function () {
                if(!clicked) {
                    $(this).removeClass('glyphicon-star-empty');
                    $(this).addClass('glyphicon-star');
                    $(this).prevAll().removeClass('glyphicon-star-empty');
                    $(this).prevAll().addClass('glyphicon-star');
                    $(this).nextAll().removeClass('glyphicon-star');
                    $(this).nextAll().addClass('glyphicon-star-empty');
                    $('[name="Rating"]').val(null);
                    $('[name="sendReview"]').removeClass('btn-primary');
                    $('[name="sendReview"]').addClass('btn-disabled');
                }
            },

            // Handles the on mouse exit
            function () {
                if (!clicked) {
                    $(this).removeClass('glyphicon-star-empty');
                    $(this).addClass('glyphicon-star');
                    $(this).prevAll().removeClass('glyphicon-star-empty');
                    $(this).prevAll().addClass('glyphicon-star');
                    $(this).nextAll().removeClass('glyphicon-star');
                    $(this).nextAll().addClass('glyphicon-star-empty');
                    $('[name="Rating"]').val(null);
                    $('[name="sendReview"]').removeClass('btn-primary');
                    $('[name="sendReview"]').addClass('btn-disabled');
                }
            });
    </script>
@endsection

@section('scripts')
    <script type="text/javascript">
        var clicked = false;

        $('.ratings-stars').click(
            // Handles the mouse click
            function () {
                $(this).removeClass('glyphicon-star-empty');
                $(this).addClass('glyphicon-star');
                $(this).prevAll().removeClass('glyphicon-star-empty');
                $(this).prevAll().addClass('glyphicon-star');
                $(this).nextAll().removeClass('glyphicon-star');
                $(this).nextAll().addClass('glyphicon-star-empty');
                $('[name="Rating"]').val($(this).text());
                $('[name="sendReview"]').removeClass('btn-disabled');
                $('[name="sendReview"]').addClass('btn-primary');
                clicked = true;
            }
        );

        $('.ratings-stars').hover(
            // Handles the on mouse enter
            function () {
                if(!clicked) {
                    $(this).removeClass('glyphicon-star-empty');
                    $(this).addClass('glyphicon-star');
                    $(this).prevAll().removeClass('glyphicon-star-empty');
                    $(this).prevAll().addClass('glyphicon-star');
                    $(this).nextAll().removeClass('glyphicon-star');
                    $(this).nextAll().addClass('glyphicon-star-empty');
                    $('[name="Rating"]').val(null);
                    $('[name="sendReview"]').removeClass('btn-primary');
                    $('[name="sendReview"]').addClass('btn-disabled');
                }
            },

            // Handles the on mouse exit
            function () {
                if (!clicked) {
                    $(this).removeClass('glyphicon-star-empty');
                    $(this).addClass('glyphicon-star');
                    $(this).prevAll().removeClass('glyphicon-star-empty');
                    $(this).prevAll().addClass('glyphicon-star');
                    $(this).nextAll().removeClass('glyphicon-star');
                    $(this).nextAll().addClass('glyphicon-star-empty');
                    $('[name="Rating"]').val(null);
                    $('[name="sendReview"]').removeClass('btn-primary');
                    $('[name="sendReview"]').addClass('btn-disabled');
                }
            });
    </script>
@endsection