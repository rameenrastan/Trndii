<?php
namespace App\Repositories;
use App\Transaction; 
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Auth;
use DB;

class TransactionRepository implements TransactionRepositoryInterface {

    protected $transaction;
    
    public function __construct(Transaction $transaction){

        $this->transactionr = $transaction;

    }

    public function index(){

        $itemsfk = DB::table('transactions')->where('email', Auth::user()->email)->pluck('item_fk');
        
        return DB::table('items')
                        ->join('transactions', 'items.id', '=', 'transactions.item_fk')
                        ->select('items.id', 'items.Name', 'items.Price', 'items.Bulk_Price', 'items.Short_Description', 'items.Start_Date', 'items.End_Date', 'items.Status', 'items.Threshold', 'items.Number_Transactions', 'items.Status', 'items.Picture_URL', 'transactions.created_at')
                        ->where('transactions.email', Auth::user()->email)
                        ->orderBy('transactions.created_at', 'DESC')
                        ->get();

    }

}