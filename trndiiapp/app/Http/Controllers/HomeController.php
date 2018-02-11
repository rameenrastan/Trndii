<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Bart\Ab\Ab;

use Auth;
use Feature;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Ab $ab)
    {
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
        $this->ab->getCurrentTest();
        if($this->ab->getCurrentTest()== "A"){
            Feature::add('Cancel Purchase', false);
        }

        if($this->ab->getCurrentTest()== "B"){
            Feature::add('Cancel Purchase', true);
        };
        Log::info("User " . Auth::user()->email . " is viewing the home page.");
        return view('home');
    }

}
