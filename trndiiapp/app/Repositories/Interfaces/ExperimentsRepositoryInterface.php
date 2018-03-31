<?php
namespace App\Repositories\Interfaces;
 

interface ExperimentsRepositoryInterface {
	
    public function incrementExperimentAFrontPageHits();
    public function incrementExperimentAPurchases();
    public function incrementExperimentBFrontPageHits();
    public function incrementExperimentBPurchases();
    public function getExperiments();
    public function getTotalPopulation();

}