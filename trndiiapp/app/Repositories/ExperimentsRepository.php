<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ExperimentsRepositoryInterface;

class ExperimentsRepository implements ExperimentsRepositoryInterface
{

    protected $experimentA;
    protected $experimentB;

    public function __construct()
    {
        $this->experimentA = "Basic";
        $this->experimentB = "Token";
    }

    public function incrementExperimentAFrontPageHits(){
        DB::table('experiments')->where("name", $this->experimentA)->increment('front_page_hits');
    }

    public function incrementExperimentAPurchases(){
        DB::table('experiments')->where("name", $this->experimentA)->increment('number_purchases');
    }

    public function incrementExperimentBFrontPageHits(){
        DB::table('experiments')->where("name", $this->experimentB)->increment('front_page_hits');
    }

    public function incrementExperimentBPurchases(){
        DB::table('experiments')->where("name", $this->experimentB)->increment('number_purchases');
    } 
    
    public function incrementExperimentAPopulation(){
        DB::table('experiments')->where("name", $this->experimentA)->increment('population_size');
    }

    public function incrementExperimentBPopulation(){
        DB::table('experiments')->where("name", $this->experimentB)->increment('population_size');
    }



                                                          
    public function getExperiments(){
        $experiments =  DB::table('experiments')->get();
        return $experiments;
    }

    public function getTotalPopulation(){
        $total_pop =  DB::table('experiments')->sum('population_size');
        return $total_pop;
    }

    public function getExperimentAFrontPageHits(){
        $frontPageHits =  DB::table('experiments')->where('name', $this->experimentA)->value('front_page_hits');
        return $frontPageHits;
    }
                                                               
    public function getExperimentBFrontPageHits(){
        $frontPageHits =  DB::table('experiments')->where('name', $this->experimentB)->value('front_page_hits');
        return $frontPageHits;                   
    }                                              
                                                 
    public function getExperimentAPurchases(){          
        $numberPurchases =  DB::table('experiments')->where('name', $this->experimentA)->value('number_purchases');
        return $numberPurchases;                      
    }                                                  
                                                      
    public function getExperimentBPurchases(){       
        $numberPurchases =  DB::table('experiments')->where('name', $this->experimentB)->value('number_purchases');
        return $numberPurchases;                    
    } 
    
    public function getExperimentAPopulation(){          
        $population =  DB::table('experiments')->where('name', $this->experimentA)->value('population_size');
        return $population;                      
    }                                                  
                                                      
    public function getExperimentBPopulation(){       
        $population =  DB::table('experiments')->where('name', $this->experimentB)->value('population_size');
        return $population;                    
    }                             
}                                                      