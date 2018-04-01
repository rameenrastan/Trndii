<?php
namespace App\Domain;
use Auth;
use DB;
use App\Transaction;
use Carbon\Carbon;
use App\item;
use App\User;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface as TransactionRepositoryInterface;
use App\Repositories\Interfaces\ItemRepositoryInterface as ItemRepositoryInterface;

class TokenManager {

    protected $userRepo;
    protected $transactionRepo;
    protected $itemRepo;

    public function __construct(UserRepositoryInterface $userRepo, TransactionRepositoryInterface $transactionRepo, ItemRepositoryInterface $itemRepo){

        $this->userRepo = $userRepo;
        $this->transactionRepo = $transactionRepo;
        $this->itemRepo = $itemRepo;
    }

    /**
     * Randomly chooses a user from all the user that spent 0 tokens when buying an item.
     * This occurs after reaching the threshold of the item.
     * @param Array of User
     * @return User
     */
    public function chooseNoTokenWinner($noTokenUsers){

        $nbOfUsers=sizeof($noTokenUsers);
        $winner=random_int(0,$nbOfUsers-1);

        //refund the following user
        return $noTokenUsers[$winner];

    }

    /**
     * Calculates how much cash a customer receives from using tokens
     * @param $itemPrice, $totalTokens, $tokensSpent, $moneyPool
     * @return $moneyBack
     */
    public function calculateCashBackFromTokens($itemPrice, $totalTokens, $tokensSpent, $moneyPool){

        if($totalTokens == 0){
            return 0;
        }

        $moneyBack = ($tokensSpent/$totalTokens) * $moneyPool;
        
        //A customer may win at max 3x the item's base price
        if($moneyBack > ($itemPrice*3)){
            return (itemPrice*3);
        }
        else{
            return $moneyBack;
        }
    }

    /**
     * Calculates the total amount of money that can be redistributed to users
     * @param $item
     * @return $totalSavings
     */
    public function calculateMoneyPool($item){

        $totalSavings = ($item->Price - $item->Bulk_Price) * $item->Threshold; 

        return $totalSavings;
    }
}