<?php
namespace App\Repositories;
use App\Transaction; 
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\ItemRepository;
use Auth;
use DB;
use Log;

class TransactionRepository implements TransactionRepositoryInterface {

    protected $transaction;
    protected $itemRepo;
    protected $logger;
    
    public function __construct(Transaction $transaction, ItemRepository $itemRepository, Log $logger){

        $this->transactionr = $transaction;
        $this->itemRepo = $itemRepository;
        $this->logger = $logger;
    }

    /**
     * Getting all transactions associated with a user from the database.
     * @param  null
     * @return Transaction[]
     */
    public function index(){

        $this->logger::info(session()->getId() . ' | [Started Number of Transactions] | ' . Auth::user()->email);
        $itemsfk = DB::table('transactions')->where('email', Auth::user()->email)->pluck('item_fk');
        $this->logger::info(session()->getId() . ' | [Completed Number of Transactions] | ' . Auth::user()->email);
        
        $this->logger::info(session()->getId() . ' | [Retrieve Associated Items] | ' . Auth::user()->email);
        return DB::table('items')
                        ->join('transactions', 'items.id', '=', 'transactions.item_fk')
                        ->select('items.id', 'items.Name', 'items.Price', 'items.Bulk_Price', 'items.Short_Description', 'items.Start_Date', 'items.End_Date', 'items.Status', 'items.Threshold', 'items.Number_Transactions', 'items.Status', 'items.Picture_URL', 'transactions.created_at')
                        ->where('transactions.email', Auth::user()->email)
                        ->orderBy('transactions.created_at', 'DESC')
                        ->get();

    }

    /**
     * Inserts a new transaction associating a user with an item.
     * @param  $email, $itemId
     * @return void
     */
    public function insert($email, $itemId){

        $this->logger::info(session()->getId() . ' | [Insert Transaction Started] | ' . Auth::user()->email);
        DB::table('transactions')->insert([

               ['email' => $email, 'item_fk' => $itemId]
            
            ]);
        $this->logger::info(session()->getId() . ' | [Insert Transaction Completed] | ' . Auth::user()->email);
    }

    /**
     * Get all transactions associated to an item.
     * @param  int $id
     * @return Transaction[]
     */
    public function getAllByItemId($id){
        return DB::table('transactions')->where('item_fk', $id)->get();

    }

    /**
     * Deletes a transaction associated with a specific user and item.
     * @param  $itemId
     * @return void
     */
    public function destroy($itemId)
    {
        DB::table('transactions')
            ->where('item_fk', $itemId)
            ->where('email', Auth::user()->email)
            ->delete();
        $this->itemRepo->numTransactions($itemId);
    }

}