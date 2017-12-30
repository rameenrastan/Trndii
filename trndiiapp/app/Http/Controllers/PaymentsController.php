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
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface as TransactionRepositoryInterface;
use App\Repositories\Interfaces\ItemRepositoryInterface as ItemRepositoryInterface;
use Log;

class PaymentsController extends Controller
{

    protected $userRepo;
    protected $transactionRepo;
    protected $itemRepo;
     
    public function __construct(UserRepositoryInterface $userRepo, TransactionRepositoryInterface $transactionRepo, ItemRepositoryInterface $itemRepo){
    
        $this->userRepo = $userRepo;
        $this->transactionRepo = $transactionRepo;
        $this->itemRepo = $itemRepo;
    
    }

    /**
     * Updates a user's credit card info
     * @param null
     * @return \Illuminate\Http\Response
     */
    public function updateCard(){


       Stripe::setApiKey('sk_test_NT3PRUGQkLOj8cnPlp1X2APb');
       
       $auth = Auth::user();
       $user = $this->userRepo->findByEmail($auth->email);

       $customer = Customer::create([

        'email' => request('stripeEmail'),
        'source' => request('stripeToken') 

       ]);

   
        $this->userRepo->updateCreditCard($auth->email, $customer->id);
        Log::info($user->email . " has updated their credit card.");
        return redirect('/editDetails')->with('success', 'Credit Card Updated');

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
        
        $expiredItems = $this->itemRepo->getExpiredItems();

        if(!empty($expiredItems)){

            foreach($expiredItems as $expiredItem){

                $item = $this->itemRepo->find($expiredItem->id);
                
                $transactions = $this->transactionRepo->getAllByItemId($expiredItem->id);

                if($expiredItem->Number_Transactions == $expiredItem->Threshold){

                    $this->itemRepo->setThresholdReached($expiredItem->id);

                    foreach($transactions as $transaction){

                        $user = $this->userRepo->findByEmail($transaction->email);

                        app('App\Http\Controllers\PaymentsController')->charge($expiredItem->Price, $user->stripe_id);

                        app('App\Http\Controllers\TransactionsController')->updatePurchaseHistory($user->email, $expiredItem->id);

                        Log::info($user->email . " has been sent a transaction confirmation email for " . $item->Name);
                        Mail::to($transaction->email)->send(new PurchaseCompleted($item, $user));

                 }

                 }else{

                    $this->itemRepo->setExpired($expiredItem->id);

                    foreach($transactions as $transaction){
                        
                        $user = $this->userRepo->findByEmail($transaction->email);
                        Log::info($user->email . " has been sent an item expired email for " . $item->Name);
                        Mail::to($transaction->email)->send(new ItemExpired($item, $user));
                    }    

                  }

            }

        }

    }


}
