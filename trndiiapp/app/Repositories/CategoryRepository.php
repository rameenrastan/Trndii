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
        return Category::pluck('Name')->toArray();
        //return Category::all();
    }
}