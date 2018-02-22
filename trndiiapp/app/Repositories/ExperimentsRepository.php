<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ExperimentsRepositoryInterface;
use Log;

class ExperimentsRepository implements ExperimentsRepositoryInterface
{

    public function incrementExperimentAVisitors(){
        DB::table('experiments')->where("name", "A")->increment('number_visitors');
        Log::info("1 new visitor has logged into Experiment A.");
    }

    public function incrementExperimentAPurchases(){
        DB::table('experiments')->where("name", "A")->increment('number_purchases');
        Log::info("1 new purchase has been made in Experiment A.");
    }

    public function incrementExperimentBVisitors(){
        DB::table('experiments')->where("name", "B")->increment('number_visitors');
        Log::info("1 new visitor has logged into Experiment B.");
    }

    public function incrementExperimentBPurchases(){
        DB::table('experiments')->where("name", "B")->increment('number_purchases');
        Log::info("1 new purchase has been made in Experiment B.");
    }
}