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

    /**
     * Gets all categories in the database.
     * @param  null
     * @return Category[]
     */
    public function getCategories(){
        Log::info(session()->getId() . ' | [Database Query: Retrieving Categories]');
        return Category::pluck('Name')->toArray();
    }
}