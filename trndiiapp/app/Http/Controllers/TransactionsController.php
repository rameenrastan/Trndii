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
use App\Repositories\Interfaces\TransactionRepositoryInterface as TransactionRepositoryInterface;

class TransactionsController extends Controller
{

    protected $transactionRepo;
    
    public function __construct(TransactionRepositoryInterface $transactionRepo){
    
        $this->transactionRepo = $transactionRepo;
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->transactionRepo->index();
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
        $user = Auth::user();
        if($stripeId != ''){

            $this->transactionRepo->insert(Auth::user()->email, $id);    

            app('App\Http\Controllers\ItemsController')->numTransactions($id);    
            
            $item = item::find($id);    
            Mail::to(Auth::user()->email)->send(new PurchaseConfirmation($item, Auth::user() ));

            Log::info('User ' . $user->email . ' successfully commited to purchasing ' . $item->name);
            return redirect('/')->with('success', 'You have successfully commited to this purchase. You will be notified if the item reaches its threshold. Thanks!');
            
        }
        
        else{

            Log::info('User ' . $user->email . ' was unable to commit to purchasing ' . $item->name);
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
