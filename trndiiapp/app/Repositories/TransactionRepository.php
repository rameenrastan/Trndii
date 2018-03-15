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
    
    public function __construct(Transaction $transaction, ItemRepository $itemRepository){

        $this->transactionr = $transaction;
        $this->itemRepo= $itemRepository;

    }

    /**
     * Getting all transactions associated with a user from the database.
     * @param  null
     * @return Transaction[]
     */
    public function index(){

        Log::info('Database query: getting transactions of user ' . Auth::user()->email);
        $itemsfk = DB::table('transactions')->where('email', Auth::user()->email)->pluck('item_fk');
        
        Log::info('Database query: getting items associated with user ' . Auth::user()->email);
        return DB::table('items')
                        ->join('transactions', 'items.id', '=', 'transactions.item_fk')
                        ->select('items.id', 'items.Name', 'items.Price', 'items.Bulk_Price', 'items.Short_Description', 'items.Start_Date', 'items.End_Date', 'items.Status', 'items.Threshold', 'items.Number_Transactions', 'items.Status', 'items.Picture_URL', 'transactions.created_at', 'items.Supplier')
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

        Log::info('Database query: inserting a new transaction in the transactions table, User: ' . Auth::user()->email . ' and Item: ' . $itemId);
        DB::table('transactions')->insert([

               ['email' => $email, 'item_fk' => $itemId]
            
            ]);
    }

    /**
     * Get all transactions associated to an item.
     * @param  int $id
     * @return Transaction[]
     */
    public function getAllByItemId($id){
        Log::info('Database query: retrieving all transactions associated with item ' . $id);
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