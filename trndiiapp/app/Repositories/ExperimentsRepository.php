<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ExperimentsRepositoryInterface;
use Log;

class ExperimentsRepository implements ExperimentsRepositoryInterface
{

    public function incrementExperimentAFrontPageHits(){
        DB::table('experiments')->where("name", "A")->increment('front_page_hits');
        Log::info("1 new front page hit on Experiment A.");
    }

    public function incrementExperimentAPurchases(){
        DB::table('experiments')->where("name", "A")->increment('number_purchases');
        Log::info("1 new purchase has been made in Experiment A.");
    }

    public function incrementExperimentBFrontPageHits(){
        DB::table('experiments')->where("name", "B")->increment('front_page_hits');
        Log::info("1 new front page hit on Experiment B.");
    }

    public function incrementExperimentBPurchases(){
        DB::table('experiments')->where("name", "B")->increment('number_purchases');
        Log::info("1 new purchase has been made in Experiment B.");
    }
}