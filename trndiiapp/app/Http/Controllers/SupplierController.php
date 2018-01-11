<?php

namespace App\Http\Controllers;

use App\item;
use Auth;
use Illuminate\Support\Facades\DB;  
use Illuminate\Http\Request;
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
        return view('supplier-home');
    }

    public function viewItemsStatus(Request $request)
    {
        $supplierItems = $this->itemRepo->getSupplierItems();
        
        return view('supplier.viewItemsStatus', compact('supplierItems'));
    }
}
