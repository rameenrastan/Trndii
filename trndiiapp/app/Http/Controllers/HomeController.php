<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Bart\Ab\Ab;

use Auth;

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
        if($this->ab->getCurrentTest()== "teaser1"){

            Log::info("User " . Auth::user()->email . " is viewing the home page.");
//          print $this->ab->getCurrentTest();
              return view('home');
        }

        if($this->ab->getCurrentTest()== "teaser2"){

            Log::info("User " . Auth::user()->email . " is viewing the home page.");
//            print $this->ab->getCurrentTest();
             return view('home');
        }

    }
}
