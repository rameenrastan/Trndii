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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ItemRepositoryInterface $itemRepo)
    {
        $this->middleware('auth:supplier');
        $this->itemRepo=$itemRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info("A supplier is viewing their home page.");
        return view('supplier-home');
    }

    public function viewReviews()
    {
        return view('supplier.viewReviews');
    }

    public function viewItemsStatus(Request $request)
    {
        $supplierItems = $this->itemRepo->getSupplierItems();
        Log::info("A supplier is viewing the progress and status of their items.");
        return view('supplier.viewItemsStatus', compact('supplierItems'));
    }
}
