<?php
namespace App\Domain;
use Auth;
use DB;
use Stripe\{Stripe, Charge, Customer, Refund};
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
     * Refunds a charge by a given amount
     *
     * @param  $amount, $chargeId
     * @return void
     */
    public function refund($amount, $chargeId){

        try {
            
        if($amount == 0){

            $this->logger::info(session()->getId() . ' | [Amount is 0, No Refund] | ' . $chargeId);
            return;
        }

        $this->logger::info(session()->getId() . ' | [Refund Started] | ' . $chargeId);

        Stripe::setApiKey(env('STRIPE_SECRET')); 

        $amount = $amount * 100;
        $amount = (int)$amount;

        $refund = Refund::create([
            "charge" => $chargeId,
            "amount" => $amount,
        ]);  

        $this->logger::info(session()->getId() . ' | [Refund Complete] | ' . $chargeId);

        } catch (Exception $e)
        {
            $this->logger::error(session()->getId() . ' | [Refund Failed] | ' . $chargeId);
            return $e->getMessage();
        }
        
    }

    /**
     * Charges a user's credit card
     *
     * @param  $amount, $customerId
     * @return $chargeId
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
                    $this->logger::error(session()->getId() . ' | [Charge Customer Failed] | ' . $customerId);
                    return $e->getMessage();
                }
        
            }

    /**
     * Handles all processing related to a purchase completion.
     * @param int $id
     * @return void
     */
    public function purchaseCompletion($id){
        try{
        $this->logger::info(session()->getId() . ' | [Purchase Completion Started] | ' . $id);
        $item = $this->itemRepo->find($id);
                
        $transactions = $this->transactionRepo->getAllByItemId($id);

        $transaction_log = new Logger('Transaction Logs');
        $transaction_log->pushHandler(new StreamHandler('storage/logs/transactions/item_' . $item->id . '_transactions.log', Logger::INFO));
        $transaction_log->addInfo("Item " . $item->id . " transactions: listing all users charged for the purchase of this item...");

        $noTokenUsers=new SplFixedArray(0);
        $noTokenUsersCounter=0;

        $moneyPool = $this->tokenManager->calculateMoneyPool($item);
        $totalTokens = $item->Total_Tokens_Spent;
        $itemPrice = $item->Price;

        foreach($transactions as $transaction){

            $user = $this->userRepo->findByEmail($transaction->email);
            $tokensSpent = $transaction->tokens_spent;

            //$this->charge($item->Price, $user->stripe_id);

            $this->userRepo->addTokens($user, $item->Tokens_Given);

            if($transaction->tokens_spent==0){
                $noTokenUsers->setSize($noTokenUsersCounter+1);
                $noTokenUsers[$noTokenUsersCounter]=$user;
                $noTokenUsersCounter=$noTokenUsersCounter+1;
            }

            $transaction_log->addInfo("User " . $user->email . " was charged $" . $item->Price);

            $moneyBack = $this->tokenManager->calculateCashBackFromTokens($itemPrice, $totalTokens, $tokensSpent, $moneyPool);
            $this->refund($moneyBack,$transaction->charge_id);
            $transaction_log->addInfo("User " . $user->email . " has gained $" . $moneyBack . " from spending tokens."); 

            app('App\Http\Controllers\TransactionsController')->updatePurchaseHistory($user->email, $id);

            $this->mail::to($transaction->email)->send(new PurchaseCompleted($item, $user));
        }

        //Chose random winner from noTokenUsers
        $winner=$this->tokenManager->chooseNoTokenWinner($noTokenUsers);
        $this->refundWinner($item,$winner);

        $this->logger::info(session()->getId() . ' | [Purchase Completion Completed] | ' . $id);

        } catch (Exception $e) {
        $this->logger::error(session()->getId() . ' | [Purchase Completion Failed] | ' . $id);
        return $e->getMessage();
    }
    }

    public function refundWinner($item, $user){
        $refundAmount=$item->Price;
        $transaction = $this->transactionRepo->get($user->email, $item->id);
        $this->refund($refundAmount, $transaction->charge_id);
    }

}