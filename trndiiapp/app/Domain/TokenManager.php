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

class TokenManager {

    protected $userRepo;
    protected $transactionRepo;
    protected $itemRepo;
    protected $logger;
    protected $mail;

    public function __construct(Mail $mail, Log $logger, UserRepositoryInterface $userRepo, TransactionRepositoryInterface $transactionRepo, ItemRepositoryInterface $itemRepo){

        $this->userRepo = $userRepo;
        $this->transactionRepo = $transactionRepo;
        $this->itemRepo = $itemRepo;
        $this->logger = $logger;
        $this->mail = $mail;

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
}