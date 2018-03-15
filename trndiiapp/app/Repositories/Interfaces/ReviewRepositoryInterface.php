<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;

interface ReviewRepositoryInterface {

    public function storeReview(Request $request);
    public function getItemReviews($itemId);
}