<?php
namespace App\Domain;
use App\User;
use Log;
use Bart\Ab\Ab;
use Feature;
use App\Repositories\Interfaces\ExperimentsRepositoryInterface;

class ExperimentHandler { 

    protected $experimentsRepo;
    protected $logger;
    protected $experimentA;
    protected $experimentB;

    
    public function __construct(Log $logger, Ab $ab, ExperimentsRepositoryInterface $experimentsRepo)
    {
        $this->experimentsRepo = $experimentsRepo;
        $this->ab = $ab;
        $this->logger = $logger;
        $this->experimentA = "Basic";
        $this->experimentB = "Token";
    }

    public function handleExperiment(User $user, $userSegment)
    {
        try {
        $this->logger::info(session()->getId() . ' | [Assigning Experiment Started] | ' . $user->email);

        if($userSegment == "")
        {
            $user->segment = $this->ab->getCurrentTest();
            $user->save();

            if($user->segment == $this->experimentA)
            {
                $this->experimentsRepo->incrementExperimentAPopulation();
            }
            else if($user->segment == $this->experimentB)
            {
                $this->experimentsRepo->incrementExperimentBPopulation();
            }
        }
        else if($userSegment == $this->experimentA){
            //turn  off token system here
            //Feature::add('Token System', false);
            Feature::add('Cancel Purchase', false);
            $this->experimentsRepo->incrementExperimentAFrontPageHits();
        }
        else if($userSegment == $this->experimentB){
            //turn on token system here
            //Feature::add('Token System', true);
            Feature::add('Cancel Purchase', true);
            $this->experimentsRepo->incrementExperimentBFrontPageHits();
        };

        $this->logger::info(session()->getId() . ' | [Assigning Experiment Completed] | ' . $user->email);
        } catch (Exception $e) {
            $this->logger::error(session()->getId() . ' | [Assigning Experiment Failed] | ' . $user->email);
            return $e->getMessage();
        }
    }

    public function incrementNumPurchases($userSegment)
    {
        if($userSegment == $this->experimentA){
            $this->experimentsRepo->incrementExperimentAPurchases();
        }
        else if($userSegment == $this->experimentB){
            $this->experimentsRepo->incrementExperimentBPurchases();
        };
    }

}