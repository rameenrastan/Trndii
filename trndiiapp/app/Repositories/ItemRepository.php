<?php

namespace App\Repositories;

use App\item;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Log;

class ItemRepository implements ItemRepositoryInterface{

    /**
     * Inserts an item in the database.
     * @param  $request
     * @return void
     */
    public function store(Request $request)
    {

        //Store in database
        $item= new item;

        $item->Name=$request->Name;
        $item->Price=$request->Price;
        $item->Bulk_Price=$request->Bulk_Price;
        $item->Tokens_Given=$request->Tokens_Given;
        $item->Total_Tokens_Spent=$request->Total_Tokens_Spent;
        $item->Threshold=$request->Threshold;
        $item->Short_Description=$request->Short_Description;
        $item->Long_Description=$request->Long_Description;
        $item->Category=$request->Category;
        $item->Start_Date=$request->Start_Date;
        $item->Status = 'pending';
        $item->End_Date=$request->End_Date;
        $item->Picture_URL=$request->Picture_URL;
        $item->Shipping_To=$request->Shipping_To;
        $item->Supplier=$request->Supplier;

        $item->save();
        Log::info('Database query: item ' . $item->id . ' created');

    }

    /**
     * Returns all active items in alphabetical order.
     * @param  null
     * @return item[]
     */
    public function index()
    {
        Log::info('Database query: getting all active items.');
        return item::orderby('Name','asc')->where('Status', '!=', 'cancelled')->paginate(10);
    }

    /**
     * Gets search results of a user search bar input.
     * @param  null
     * @return item[]
     */
    public function viewAllItems()
    {
        Log::info('Database query: getting all items.');
        return item::orderby('Name','asc')->paginate(12);
    }

    /**
     * Changes an item's status to cancelled.
     * @param  int $id
     * @return void
     */
    public function update($id)
    {
        Log::info('Database query: Item ' . $id . ' status changed to cancelled.');
        $item = item::find($id);

        $item->Status = 'cancelled';
        $item->save();
    }

    /**
     * Updates an item's number of transactions.
     * @param  int $id
     * @return void
     */
    public function numTransactions($id)
    {
        $numTransactions = DB::table('transactions')->where('item_fk', $id)->count();
        Log::info('Database query: Item ' . $id . ' number of transactions updated to : ' . $numTransactions);
        DB::table('items')
            ->where('id', $id)
            ->update(['Number_Transactions' => $numTransactions]);
    }

    /**
     * Finds an item by its id.
     * @param  int $id
     * @return item
     */
    public function find($id)
    {
        Log::info('Database query: retrieving item ' . $id);
        return item::find($id);
    }

    /**
     * Returns the number of users commited to an item.
     * @param  $item
     * @return int
     */
    public function checkCommit($item)
    {
        Log::info('Database query: finding the number of users commited to item ' . $item->id);
        if (!Auth::user()) {
            return;
        } else
            return DB::table('transactions')->where([['email', Auth::user()->email], ['item_fk', $item->id]])->count();
    }

    /**
     * Updates an item's status to threshold reached.
     * @param  int $id
     * @return void
     */
    public function setThresholdReached($id)
    {
        Log::info('Database query: updating item ' . $id . ' status to threshold reached');
        DB::table('items')->where('id', $id)->update(['status' => 'threshold reached']);
    }

    /**
     * Retrieves all items expiring today from the database.
     * @param  null
     * @return item[]
     */
    public function getExpiredItems()
    {
        Log::info('Database query: retrieving all items that expire today (on ' .  Carbon::today() . ')');
        return DB::table('items')->whereRaw('date(End_Date) = ?', [Carbon::today()])->get();
    }

    /**
     * Sets an item's status to expired.
     * @param  int $id
     * @return void
     */
    public function setExpired($id)
    {
        Log::info('Database query: changing status of item ' . $id . ' to expired.');
        DB::table('items')->where('id', $id)->update(['status' => 'expired']);
    }

    /**
     * Returns all items associated to a supplier.
     * @param  null
     * @return item[]
     */
    public function getSupplierItems()
    {
        return DB::table('items')->where('Supplier','=', Auth::user()->name)->get();
    }

    /**
     * Gets search results of a user search bar input.
     * @param  $request
     * @return item[]
     */
    public function getSearchResults(Request $request)
    {
        $name = $request->search;
        Log::info("Query: getting search results of " . $request->search);
        return item::search($name)->paginate(15);
    }

    public function addTotalTokens($nbTokens, $id)
    {
        Log::info('Database query: Adding ' . $nbTokens . ' tokens to total.'); 
        DB::table('items')->where('id', $id)->increment('Total_Tokens_Spent', $nbTokens);

    }
}