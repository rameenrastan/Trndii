<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Auth;
use App\Domain\ExperimentHandler;

class HomeController extends Controller
{

    protected $experimentHandler;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ExperimentHandler $experimentHandler)
    {
        $this->experimentHandler = $experimentHandler;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $this->experimentHandler->handleExperiment(Auth::user(), Auth::user()->segment);
        Log::info("User " . Auth::user()->email . " is viewing the home page.");
        return view('home');
    }

}
