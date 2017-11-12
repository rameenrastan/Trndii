<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Auth;
use Log;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Mail\PurchaseConfirmation;
use Illuminate\Support\Facades\Mail;
use App\item; 

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = DB::table('items')
                        ->join('transactions', 'items.id', '=', 'transactions.item_fk')
                        ->select('items.id', 'items.Name', 'items.Price', 'items.Bulk_Price', 'items.Short_Description', 'items.Start_Date', 'items.End_Date', 'items.Status', 'items.Threshold', 'items.Number_Transactions', 'items.Status', 'items.Picture_URL', 'transactions.created_at')
                        ->where('email', Auth::user()->email)
                        ->orderBy('transactions.created_at', 'DESC')
                        ->get();

        return view('layouts.purchasehistory')->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
       
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $stripeId = Auth::user()->stripe_id;

        if($stripeId != ''){

                DB::table('transactions')->insert([
                
                   ['email' => Auth::user()->email, 'item_fk' => $id]
                
                ]);

            app('App\Http\Controllers\ItemsController')->numTransactions($id);    
            
            $item = item::find($id);    
            Mail::to(Auth::user()->email)->send(new PurchaseConfirmation($item, Auth::user() ));

            return redirect('/')->with('success', 'You have successfully commited to this purchase. You will be notified if the item reaches its threshold. Thanks!');
            
        }
        
        else{

            return back()->with('error', 'You do not have a Credit Card registered with this account. Please go to the Edit Account page and register a payment option.');

        }           
    }

    public function updatePurchaseHistory($email, $itemId){


        DB::table('purchased_items')->insert([

            ['email' => $email, 'item_fk' => $itemId] 

        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
