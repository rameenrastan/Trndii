<?php

namespace App\Http\Controllers;

use App\item;
use Auth;
use Illuminate\Support\Facades\DB;  
use Illuminate\Http\Request;
use Log;
use App\Repositories\Interfaces\ItemRepositoryInterface as ItemRepositoryInterface;

class SupplierController extends Controller
{

    protected $itemRepo;
    protected $logger;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ItemRepositoryInterface $itemRepo, Log $logger)
    {
        $this->middleware('auth:supplier');
        $this->itemRepo=$itemRepo;
        $this->logger=$logger;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->logger::info("A supplier is viewing their home page.");
        return view('supplier-home');
    }

    public function viewItemsStatus(Request $request)
    {
        $supplierItems = $this->itemRepo->getSupplierItems();
        $this->logger::info("A supplier is viewing the progress and status of their items.");
        return view('supplier.viewItemsStatus', compact('supplierItems'));
    }
}
