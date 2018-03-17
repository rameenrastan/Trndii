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
use App\Mail\PurchaseCompleted;
use Illuminate\Support\Facades\Mail;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface as TransactionRepositoryInterface;
use App\Repositories\Interfaces\ItemRepositoryInterface as ItemRepositoryInterface;
use Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class PaymentsController extends Controller
{

    protected $userRepo;
    protected $transactionRepo;
    protected $itemRepo;
    protected $logger;
     
    public function __construct(Log $logger, UserRepositoryInterface $userRepo, TransactionRepositoryInterface $transactionRepo, ItemRepositoryInterface $itemRepo){
        
        $this->logger = $logger;
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

        try {
        $this->logger::info(session()->getId() . ' | [Update Credit Card Started] | ' . Auth::user()->email); 

       Stripe::setApiKey('sk_test_NT3PRUGQkLOj8cnPlp1X2APb');
       
       $auth = Auth::user();
       $user = $this->userRepo->findByEmail($auth->email);

       $customer = Customer::create([

        'email' => request('stripeEmail'),
        'source' => request('stripeToken') 

       ]);

        $this->userRepo->updateCreditCard($auth->email, $customer->id);
        $this->logger::info(session()->getId() . ' | [Update Credit Card Finished] | ' . Auth::user()->email);
        
        return redirect('/editDetails')->with('success', 'Credit Card Updated');
       } catch (Exception $e) { 
            $this->logger::error(session()->getId() . ' | [Update Credit Card Failed] | ' . Auth::user()->email);
            return $e->getMessage();
       }

    }

}
