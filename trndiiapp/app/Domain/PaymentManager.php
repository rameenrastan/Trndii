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
                                ItemRepositoryInterface $itemRepo, TokenManager $tokenManager){
    
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
     * @param  $amount, $priceMax, $chargeId
     * @return void
     */
    public function refund($amount, $priceMax, $chargeId){

        try {
            
        if($amount == 0){

            $this->logger::info(session()->getId() . ' | [Amount is 0, No Refund] | ' . $chargeId);
            return;
        }
        else if($amount > $priceMax){

            $this->logger::info(session()->getId() . ' | [Refund Started] | ' . $chargeId);

            Stripe::setApiKey(env('STRIPE_SECRET')); 

            $extraAmount = ($amount - $priceMax) * 100;
            $extraAmount = (int)$extraAmount;

            $priceMax = $priceMax * 100;
            $priceMax = (int) $priceMax;

            $refund = Refund::create([
                "charge" => $chargeId,
                "amount" => $priceMax,
            ]);  

            //Refund the extraAmount into wallet or however desired.

            $this->logger::info(session()->getId() . ' | [Refund Complete] | ' . $chargeId);
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
     * Full refund used for getExpired() method in Item Manager
     *
     * @param  $amount, $chargeId
     * @return void
     */
    public function fullRefund($amount, $chargeId){

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $amount = (int)($amount * 100);

        $refund = Refund::create([
            "charge" => $chargeId,
            "amount" => $amount,
        ]);

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
        
                $amount = (int)($amount * 100); 
                
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

        $noTokenUsers=new SplFixedArray(0);
        $noTokenUsersCounter=0;

        $moneyPool = $this->tokenManager->calculateMoneyPool($item);
        $totalTokens = $item->Total_Tokens_Spent;
        $itemPrice = $item->Price;

        foreach($transactions as $transaction){

            $user = $this->userRepo->findByEmail($transaction->email);
            $tokensSpent = $transaction->tokens_spent;

            $this->userRepo->addTokens($user, $item->Tokens_Given);

            if($transaction->tokens_spent==0){
                $noTokenUsers->setSize($noTokenUsersCounter+1);
                $noTokenUsers[$noTokenUsersCounter]=$user;
                $noTokenUsersCounter=$noTokenUsersCounter+1;
            }

            $moneyBack = $this->tokenManager->calculateCashBackFromTokens($itemPrice, $totalTokens, $tokensSpent, $moneyPool);
            $this->refund($moneyBack, $itemPrice, $transaction->charge_id);

            app('App\Http\Controllers\TransactionsController')->updatePurchaseHistory($user->email, $id);

            $this->mail::to($transaction->email)->send(new PurchaseCompleted($item, $user));
        }

        //Chose random winner from noTokenUsers
        $winner=$this->tokenManager->chooseNoTokenWinner($noTokenUsers);
        $this->refundWinner($item, $winner);

        $this->logger::info(session()->getId() . ' | [Purchase Completion Completed] | ' . $id);

        } catch (Exception $e) {
        $this->logger::error(session()->getId() . ' | [Purchase Completion Failed] | ' . $id);
        return $e->getMessage();
    }
    }

    public function refundWinner($item, $user){
        $refundAmount=$item->Price;
        $transaction = $this->transactionRepo->get($user->email, $item->id);
        $this->refund($refundAmount, $item->Price, $transaction->charge_id);
    }

}