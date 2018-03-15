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
    
    public function __construct(ItemRepositoryInterface $itemRepo, TransactionRepositoryInterface $transactionRepo, UserRepositoryInterface $userRepo)
    {
        $this->itemRepo=$itemRepo;
        $this->transactionRepo = $transactionRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Gets all items that expire today, and sets their status to expired. 
     * This method is ran by the task scheduler located in /app/Console/Kernel.php
     * @param  null
     * @return void
     */
    public function setExpired()
    {
        $expiredItems = $this->itemRepo->getExpiredItems();
        
        if(!empty($expiredItems)){
        
            foreach($expiredItems as $expiredItem){
        
            $item = $this->itemRepo->find($expiredItem->id);
                        
            $transactions = $this->transactionRepo->getAllByItemId($expiredItem->id);
        
            $this->itemRepo->setExpired($expiredItem->id);
        
            foreach($transactions as $transaction){
                                
                $user = $this->userRepo->findByEmail($transaction->email);
                Log::info("User " . $user->email . " has been sent an item expired email for " . $item->Name);
                Mail::to($transaction->email)->send(new ItemExpired($item, $user));
                        
            }      
        
        }
        
        }
    }

}