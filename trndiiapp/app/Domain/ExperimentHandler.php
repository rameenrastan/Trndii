<?php
namespace App\Domain;
use App\User;
use Log;
use Bart\Ab\Ab;
use Feature;
use App\Repositories\Interfaces\ExperimentsRepositoryInterface;

class ExperimentHandler { 

    protected $experimentsRepo;
    
    public function __construct(Ab $ab, ExperimentsRepositoryInterface $experimentsRepo)
    {
        $this->experimentsRepo = $experimentsRepo;
        $this->ab= $ab;
    }

    public function handleExperiment(User $user, $userSegment)
    {
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
    }

}