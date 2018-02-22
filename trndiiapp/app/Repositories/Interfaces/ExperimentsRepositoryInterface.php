<?php
namespace App\Repositories\Interfaces;
 

interface ExperimentsRepositoryInterface {
	
    public function incrementExperimentAVisitors();
    public function incrementExperimentAPurchases();
    public function incrementExperimentBVisitors();
    public function incrementExperimentBPurchases();
	
}