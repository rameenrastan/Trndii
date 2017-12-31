<?php

namespace App\Http\Controllers;

use App\item;
use Auth;
use Illuminate\Support\Facades\DB;  
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:supplier');
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
        $supplierItems = DB::table('items')->where('Supplier','=', Auth::user()->name)->get();
        
        return view('supplier.viewItemsStatus', compact('supplierItems'));
    }
}
