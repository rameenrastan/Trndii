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
use App\Domain\TokenManager;
use \SplFixedArray;

class PaymentManager { 

    protected $userRepo;
    protected $transactionRepo;
    protected $itemRepo;
    protected $logger;
    protected $mail;
    protected $tokenManager;
     
    public function __construct(Mail $mail, Log $logger, UserRepositoryInterface $userRepo,
                                TransactionRepositoryInterface $transactionRepo,
                                ItemRepositoryInterface $itemRepo, TokenManager $tokenManager ){
    
        $this->userRepo = $userRepo;
        $this->transactionRepo = $transactionRepo;
        $this->itemRepo = $itemRepo;
        $this->logger = $logger;
        $this->mail = $mail;
        $this->tokenManager=$tokenManager;
    
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
                
                $chargeId = $charge->id;

                $this->logger::info(session()->getId() . ' | [Charge Customer Finished] | ' . $customerId);
                
                return $chargeId;

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
        try{
        $this->logger::info(session()->getId() . ' | [Charging All Customers Started] | ' . $id);
        $item = $this->itemRepo->find($id);
                
        $transactions = $this->transactionRepo->getAllByItemId($id);

        $transaction_log = new Logger('Transaction Logs');
        $transaction_log->pushHandler(new StreamHandler('storage/logs/transactions/item_' . $item->id . '_transactions.log', Logger::INFO));
        $transaction_log->addInfo("Item " . $item->id . " transactions: listing all users charged for the purchase of this item...");

        $noTokenUsers=new SplFixedArray(0);
        $noTokenUsersCounter=0;

        foreach($transactions as $transaction){

            $user = $this->userRepo->findByEmail($transaction->email);

            //$this->charge($item->Price, $user->stripe_id);

            $this->userRepo->addTokens($user, $item->Tokens_Given);

            if($transaction->tokens_spent==0){
                $noTokenUsers->setSize($noTokenUsersCounter+1);
                $noTokenUsers[$noTokenUsersCounter]=$user;
                $noTokenUsersCounter=$noTokenUsersCounter+1;
            }

            $transaction_log->addInfo("User " . $user->email . " was charged $" . $item->Price);

            app('App\Http\Controllers\TransactionsController')->updatePurchaseHistory($user->email, $id);

            $this->mail::to($transaction->email)->send(new PurchaseCompleted($item, $user));
        }

        //Chose random winner from noTokenUsers
        $winner=$this->tokenManager->chooseNoTokenWinner($noTokenUsers);
        $this->refundWinner($item,$winner);

        $this->logger::info(session()->getId() . ' | [Charging All Customers Completed] | ' . $id);

        } catch (Exception $e) {
        $this->logger::error(session()->getId() . ' | [Charging All Customers Failed] | ' . $id);
        return $e->getMessage();
    }
    }

    public function refundWinner($item, $user){
        $refundAmount=$item->Price;

        dd($user,$item,$refundAmount);
        //refund $user here
    }


}