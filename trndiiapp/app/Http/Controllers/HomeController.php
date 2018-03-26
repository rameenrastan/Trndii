<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Auth;
use App\Domain\ExperimentHandler;
use App\Repositories\Interfaces\ItemRepositoryInterface as ItemRepositoryInterface;

class HomeController extends Controller
{

    protected $experimentHandler;
    protected $itemRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ExperimentHandler $experimentHandler, ItemRepositoryInterface $itemRepo)
    {
        $this->itemRepo = $itemRepo;
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
        $items = $this->itemRepo->getHomePageItems();
        $this->experimentHandler->handleExperiment(Auth::user(), Auth::user()->segment);
        Log::info(session()->getId() . ' | [Homepage Visit] | ' . Auth::user()->email);
        return view('home')->with('items', $items);
    }

}
