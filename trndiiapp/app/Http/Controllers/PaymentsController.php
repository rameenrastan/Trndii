<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use DB;
use Stripe\{Stripe, Charge, Customer};
use App\Transaction;
use Carbon\Carbon;
use App\item;

class PaymentsController extends Controller
{

    /**
     * Updates a user's credit card info
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
     */
    public function commitPurchase($customerId, $itemId){

        $transaction = new Transaction(['customer_id' => $customerId, 'item_id' => $itemId]);
        $transaction -> save();

    }

    /**
     * Charges a user's credit card
     *
     * @param  $amount, $customer
     */
    public function charge($amount, $customerId){

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
     */
    public function chargeCustomers(){
        
        $expiredItems = DB::table('items')->whereRaw('date(End_Date) = ?', [Carbon::today()])->get();

        if(!empty($expiredItems)){

            foreach($expiredItems as $expiredItem){
                
                $transactions = DB::table('transactions')->where('item_fk', $expiredItem->id)->get();

                foreach($transactions as $transaction){

                    $user = DB::table('users')->where('email', $transaction->email)->first();
        
                    app('App\Http\Controllers\PaymentsController')->charge($expiredItem->Price, $user->stripe_id);

                }

            }

        }

    }


}
