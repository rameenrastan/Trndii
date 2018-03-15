<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;

interface ReviewRepositoryInterface {

    public function storeReview(Request $request);
}