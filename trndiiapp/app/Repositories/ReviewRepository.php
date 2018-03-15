<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Review;
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
}