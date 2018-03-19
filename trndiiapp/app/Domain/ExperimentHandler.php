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
    
    public function __construct(Log $logger, Ab $ab, ExperimentsRepositoryInterface $experimentsRepo)
    {
        $this->experimentsRepo = $experimentsRepo;
        $this->ab = $ab;
        $this->logger = $logger;
    }

    public function handleExperiment(User $user, $userSegment)
    {
        try {
        $this->logger::info(session()->getId() . ' | [Assigning Experiment Started] | ' . $user->email);

        if($userSegment == "")
        {
            $user->segment = $this->ab->getCurrentTest();
            $user->save();
        }
        else if($userSegment == "A"){
            Feature::add('Cancel Purchase', false);
            $this->experimentsRepo->incrementExperimentAFrontPageHits();
        }
        else if($userSegment == "B"){
            Feature::add('Cancel Purchase', true);
            $this->experimentsRepo->incrementExperimentBFrontPageHits();
        };

        $this->logger::info(session()->getId() . ' | [Assigning Experiment Completed] | ' . $user->email);
        } catch (Exception $e) {
            $this->logger::error(session()->getId() . ' | [Assigning Experiment Failed] | ' . $user->email);
            return $e->getMessage();
        }
    }

}