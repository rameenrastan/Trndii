<?php
namespace App\Domain;
use Auth;
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

class PaymentManager { 

    protected $userRepo;
    protected $transactionRepo;
    protected $itemRepo;
    protected $logger;
     
    public function __construct(Log $logger, UserRepositoryInterface $userRepo, TransactionRepositoryInterface $transactionRepo, ItemRepositoryInterface $itemRepo){
    
        $this->userRepo = $userRepo;
        $this->transactionRepo = $transactionRepo;
        $this->itemRepo = $itemRepo;
        $this->logger = $logger;
    
    }

    /**
     * Charges a user's credit card
     *
     * @param  $amount, $customer
     * @return void
     */
    public function charge($amount, $customerId){
                try {
                $this->logger::info(session()->getId() . ' | [Charge Customer Started] | ' . $customerId);
        
                $amount = $amount * 100; 
                
                Stripe::setApiKey(env('STRIPE_SECRET'));    
        
                $charge = Charge::create([
        
                    "amount" => $amount,
                    "currency" => "cad",
                    "customer" => $customerId
        
                ]);
                $this->logger::info(session()->getId() . ' | [Charge Customer Finished] | ' . $customerId);
                } catch (Exception $e)
                {
                    $this->logger::error(session()->getId() . ' | [Charge Failed] | ' . $customerId);
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

            $this->charge($item->Price, $user->stripe_id);

            $transaction_log->addInfo("User " . $user->email . " was charged $" . $item->Price);

            app('App\Http\Controllers\TransactionsController')->updatePurchaseHistory($user->email, $id);

            Log::info("User " . $user->email . " has been sent a transaction confirmation email for " . $item->Name);
            Mail::to($transaction->email)->send(new PurchaseCompleted($item, $user));
        }
    }


}