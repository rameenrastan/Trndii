<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ExperimentsRepositoryInterface;

class ExperimentsRepository implements ExperimentsRepositoryInterface
{

    public function incrementExperimentAFrontPageHits(){
        DB::table('experiments')->where("name", "A")->increment('front_page_hits');
    }

    public function incrementExperimentAPurchases(){
        DB::table('experiments')->where("name", "A")->increment('number_purchases');
    }

    public function incrementExperimentBFrontPageHits(){
        DB::table('experiments')->where("name", "B")->increment('front_page_hits');
    }

    public function incrementExperimentBPurchases(){
        DB::table('experiments')->where("name", "B")->increment('number_purchases');
    }
}