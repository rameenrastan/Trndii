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

        try {
        Log::info(session()->getId() . ' | [Update Credit Card Started] | ' . Auth::user()->email); 

        Stripe::setApiKey('sk_test_NT3PRUGQkLOj8cnPlp1X2APb');
       
        $auth = Auth::user();
        $user = $this->userRepo->findByEmail($auth->email);

        $customer = Customer::create([

        'email' => request('stripeEmail'),
        'source' => request('stripeToken') 

       ]);

        $this->userRepo->updateCreditCard($auth->email, $customer->id);
        Log::info(session()->getId() . ' | [Update Credit Card Finished] | ' . Auth::user()->email);
        
        return redirect('/editDetails')->with('success', 'Credit Card Updated');
       } catch (Exception $e) { 
            Log::error(session()->getId() . ' | [Update Credit Card Failed] | ' . Auth::user()->email);
            return $e->getMessage();
       }

    }
    
    /**
     * Charges all customers and sends confirmation if the threshold of the item has been reached.
     * @param int $id
     * @return void
     */
    public function chargeCustomers($id){
        
        $item = $this->itemRepo->find($id);



        $transactions = $this->transactionRepo->getAllByItemId($id);

        $transaction_log = new Logger('Transaction Logs');
        $transaction_log->pushHandler(new StreamHandler('storage/logs/transactions/item_' . $item->id . '_transactions.log', Logger::INFO));
        $transaction_log->addInfo("Item " . $item->id . " transactions: listing all users charged for the purchase of this item...");

        foreach($transactions as $transaction){

            $user = $this->userRepo->findByEmail($transaction->email);

            //Add tokens to users
            $this->userRepo->addTokens($user, $item->Tokens_Given);

            app('App\Http\Controllers\PaymentsController')->charge($item->Price, $user->stripe_id);

            $transaction_log->addInfo("User " . $user->email . " was charged $" . $item->Price);

            app('App\Http\Controllers\TransactionsController')->updatePurchaseHistory($user->email, $id);

    }

}
