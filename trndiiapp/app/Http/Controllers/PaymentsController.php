<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use DB;
use Stripe\{Stripe, Charge, Customer};
use App\Transaction;
use Carbon\Carbon;
use App\item;
use App\User;
use App\Mail\ItemExpired;
use App\Mail\PurchaseCompleted;
use Illuminate\Support\Facades\Mail;

class PaymentsController extends Controller
{

    /**
     * Updates a user's credit card info
     * @param null
     * @return \Illuminate\Http\Response
     */
    public function updateCard(){


       Stripe::setApiKey('sk_test_NT3PRUGQkLOj8cnPlp1X2APb');
       
       $user = Auth::user();
       
       $customer = Customer::create([

        'email' => request('stripeEmail'),
        'source' => request('stripeToken') 

       ]);

   
        $user->stripe_id = $customer->id;
        $user->save();
        
        return redirect('/editDetails')->with('success', 'Credit Card Updated');

    }


    /**
     * Creates a transaction and adds it to the database
     * 
     * @param $customerId, $itemId
     * @return void
     */
    public function commitPurchase($customerId, $itemId){

        $transaction = new Transaction(['customer_id' => $customerId, 'item_id' => $itemId]);
        $transaction -> save();

    }

    /**
     * Charges a user's credit card
     *
     * @param  $amount, $customer
     * @return void
     */
    public function charge($amount, $customerId){

        $amount = $amount * 100; 
        
        Stripe::setApiKey('sk_test_NT3PRUGQkLOj8cnPlp1X2APb');    

        $charge = Charge::create([

            "amount" => $amount,
            "currency" => "cad",
            "customer" => $customerId

        ]);

    }
    
    /**
     * Runs daily by Task Scheduler in Kernel.php
     * Checks if any item expires today, and charges all users if threshold is reached.
     * @param null
     * @return void
     */
    public function chargeCustomers(){
        
        $expiredItems = DB::table('items')->whereRaw('date(End_Date) = ?', [Carbon::today()])->get();

        if(!empty($expiredItems)){

            foreach($expiredItems as $expiredItem){

                $item = item::find($expiredItem->id);   
                
                $transactions = DB::table('transactions')->where('item_fk', $expiredItem->id)->get();

                if($expiredItem->Number_Transactions == $expiredItem->Threshold ){

                    DB::table('items')->where('id', $expiredItem->id)->update(['status' => 'threshold reached']);

                    foreach($transactions as $transaction){

                        $user = DB::table('users')->where('email', $transaction->email)->first();

                        app('App\Http\Controllers\PaymentsController')->charge($expiredItem->Price, $user->stripe_id);

                        app('App\Http\Controllers\TransactionsController')->updatePurchaseHistory($user->email, $expiredItem->id);

                        $user = User::where('email', $transaction->email)->first();
                        Mail::to($transaction->email)->send(new PurchaseCompleted($item, $user));

                 }

                 }else{

                    DB::table('items')->where('id', $expiredItem->id)->update(['status' => 'expired']);

                    foreach($transactions as $transaction){
                        
                        $user = User::where('email', $transaction->email)->first();
                        Mail::to($transaction->email)->send(new ItemExpired($item, $user));
                    }    

                  }

            }

        }

    }


}
