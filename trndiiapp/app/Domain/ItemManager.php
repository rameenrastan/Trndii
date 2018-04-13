<?php
namespace App\Domain;
use Illuminate\Support\Facades\Mail;
use App\Mail\ItemExpired;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepositoryInterface;
use App\Repositories\Interfaces\ItemRepositoryInterface as ItemRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface as TransactionRepositoryInterface;
use Log;

class ItemManager {

    protected $itemRepo;
    protected $transactionRepo;
    protected $userRepo;
    protected $paymentManager;

    public function __construct(ItemRepositoryInterface $itemRepo, TransactionRepositoryInterface $transactionRepo, UserRepositoryInterface $userRepo, PaymentManager $paymentManager)
    {
        $this->itemRepo=$itemRepo;
        $this->transactionRepo = $transactionRepo;
        $this->userRepo = $userRepo;
        $this->paymentManager = $paymentManager;
    }

    /**
     * Gets all items that expire today, and sets their status to expired. 
     * This method is ran by the task scheduler located in /app/Console/Kernel.php
     * @param  null
     * @return void
     */
    public function setExpired()
    {
        
        try{

        Log::info(session()->getId() . ' | [Getting Expired Items Started]');

        $expiredItems = $this->itemRepo->getExpiredItems();
    
        if(!empty($expiredItems)){
        
            foreach($expiredItems as $expiredItem){
        
            $item = $this->itemRepo->find($expiredItem->id);
                        
            $transactions = $this->transactionRepo->getAllByItemId($expiredItem->id);
        
            $this->itemRepo->setExpired($expiredItem->id);
        
            foreach($transactions as $transaction){
                
                $user = $this->userRepo->findByEmail($transaction->email);
                
                $this->paymentManager->refund($item->Price, $transaction->charge_id);
                
                Mail::to($transaction->email)->send(new ItemExpired($item, $user));
                        
            }      
        }
        }
        Log::info(session()->getId() . ' | [Getting Expired Items Completed]');
        } catch (Exception $e) { 

        Log::error(session()->getId() . ' | [Getting Expired Items Failed]');
        return $e->getMessage();

         }
    }

}