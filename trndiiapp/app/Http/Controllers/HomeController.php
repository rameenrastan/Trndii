<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Bart\Ab\Ab;
use Auth;
use Feature;
use App\Repositories\Interfaces\ExperimentsRepositoryInterface;

class HomeController extends Controller
{

    protected $experimentsRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Ab $ab, ExperimentsRepositoryInterface $experimentsRepo)
    {
        $this->experimentsRepo = $experimentsRepo;
        $this->ab= $ab;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(Auth::user()->segment == "")
        {
            Auth::user()->segment = $this->ab->getCurrentTest();
            Auth::user()->save();
        }
        else if(Auth::user()->segment== "A"){
            Feature::add('Cancel Purchase', false);
            $this->experimentsRepo->incrementExperimentAFrontPageHits();
        }
        else if(Auth::user()->segment== "B"){
            Feature::add('Cancel Purchase', true);
            $this->experimentsRepo->incrementExperimentBFrontPageHits();
        };
        Log::info("User " . Auth::user()->email . " is viewing the home page.");
        return view('home');
    }

}
