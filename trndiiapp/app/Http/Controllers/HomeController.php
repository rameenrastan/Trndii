<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info("User " . Auth::user()->email . " is viewing the home page.");
        return view('home');
    }
}
