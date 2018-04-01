<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Review;
use App\ReviewLike;
use App\ReviewDislike;
use Auth;
use DB;
use Illuminate\Http\Request;

class ReviewRepository implements ReviewRepositoryInterface {
    
    protected $reviewRepo;

    public function __construct(Review $review){
        $this->reviewRepo = $review;
    }

    public function storeReview(Request $request){

        $review = new Review;

        $review->item_id = $request->itemId;
        $review->user_name = Auth::user()->name;
        $review->supplier_name = $request->Supplier;
        $review->rating = $request->Rating;
        $review->comment = $request->Comment;

        $review->save();

        $itemRatingSum = 0;

        $itemReviews = DB::table('reviews')->where('item_id', '=', $request->itemId)->get();

        foreach($itemReviews as $itemReview)
        {
            $itemRatingSum += $itemReview->rating;
        }

        $itemRatingAverage = $itemRatingSum / count($itemReviews);

        DB::table('items')->where('id', '=', $request->itemId)->update(['Rating' => $itemRatingAverage]);
    }

    public function checkIfReviewExists(Request $request)
    {
        $reviews = DB::table('reviews')->select('*')->where([['item_id', '=', $request->itemId], ['user_name', '=', Auth::user()->name]])->get();

        if(count($reviews) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function storeReviewLike(Request $request){

        $savedLikes = DB::table('review_likes')->where([['user_id', '=', Auth::user()->id], ['review_id', '=', $request->reviewId],])->get();

        if(count($savedLikes) == 0){

            $savedDislike = DB::table('review_dislikes')->where([['user_id', '=', Auth::user()->id], ['review_id', '=', $request->reviewId],])->get();

            if(count($savedDislike) != 0){

                DB::table('review_dislikes')->where([['user_id', '=', Auth::user()->id], ['review_id', '=', $request->reviewId],])->delete();
                DB::table('reviews')->where('id', '=', $request->reviewId)->decrement('dislikes');
            }

            $reviewLike = new ReviewLike;

            $reviewLike->user_id = Auth::user()->id;
            $reviewLike->review_id = $request->reviewId;
    
            $reviewLike->save();

            DB::table('reviews')->where('id', '=', $request->reviewId)->increment('likes');

            return true;
        }
        else{
            return false;
        }
    }

    public function storeReviewDislike(Request $request){

        $savedDislikes = DB::table('review_dislikes')->where([['user_id', '=', Auth::user()->id], ['review_id', '=', $request->reviewId],])->get();

        if(count($savedDislikes) == 0){

            $savedLikes = DB::table('review_likes')->where([['user_id', '=', Auth::user()->id], ['review_id', '=', $request->reviewId],])->get();

            if(count($savedLikes) != 0){

                DB::table('review_likes')->where([['user_id', '=', Auth::user()->id], ['review_id', '=', $request->reviewId],])->delete();
                DB::table('reviews')->where('id', '=', $request->reviewId)->decrement('likes');
            }

            $reviewDislike = new ReviewDislike;

            $reviewDislike->user_id = Auth::user()->id;
            $reviewDislike->review_id = $request->reviewId;
    
            $reviewDislike->save();

            DB::table('reviews')->where('id', '=', $request->reviewId)->increment('dislikes');

            return true;
        }
        else{
            return false;
        }
    }

    public function getItemReviews($itemId){

        return DB::table('reviews')->where('item_id', '=',  $itemId)->get();
    }

    public function getReviewsForSupplier(){

        return DB::table('reviews')->join('items', 'reviews.item_id' , '=', 'items.id')->select('items.*', 'reviews.*')->where('reviews.supplier_name', '=', Auth::user()->name)->get();
    }
}