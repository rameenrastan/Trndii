<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Auth;
use App\Domain\ExperimentHandler;

class HomeController extends Controller
{

    protected $experimentHandler;
    protected $logger;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ExperimentHandler $experimentHandler, Log $logger)
    {
        $this->experimentHandler = $experimentHandler;
        $this->logger = $logger;
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
        $this->logger::info(session()->getId() . ' | [Homepage Visit] | ' . Auth::user()->email);
        return view('home');
    }

}
