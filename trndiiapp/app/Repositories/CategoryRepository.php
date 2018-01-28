<?php

namespace App\Repositories;

use App\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Log;

class CategoryRepository implements CategoryRepositoryInterface{

    public function getCategories(){
        Log::info("Database query: retrieving all item categories.");
        return Category::pluck('Name')->toArray();
    }
}