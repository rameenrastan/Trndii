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
    }

    public function storeReviewLike(Request $request){

        $reviewLike = new ReviewLike;

        $reviewLike->user_id = Auth::user()->id;
        $reviewLike->review_id = $request->reviewId;

        $reviewLike->save();
    }

    public function storeReviewDislike(Request $request){

        $reviewDislike = new ReviewDislike;

        $reviewDislike->user_id = Auth::user()->id;
        $reviewDislike->review_id = $request->reviewId;

        $reviewDislike->save();
    }

    public function getItemReviews($itemId){

        return DB::table('reviews')->where('item_id', '=',  $itemId)->get();
    }

    public function getReviewsForSupplier(){

        return DB::table('reviews')->join('items', 'reviews.item_id' , '=', 'items.id')->select('items.*', 'reviews.*')->where('reviews.supplier_name', '=', Auth::user()->name)->get();
    }
}