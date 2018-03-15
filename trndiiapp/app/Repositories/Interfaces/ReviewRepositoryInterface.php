<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;

interface ReviewRepositoryInterface {

    public function storeReview(Request $request);
    public function getItemReviews($itemId);
    public function getReviewsForSupplier();
    public function storeReviewLike(Request $request);
    public function storeReviewDislike(Request $request);

}