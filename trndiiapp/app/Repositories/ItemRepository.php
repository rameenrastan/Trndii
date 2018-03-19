<?php

namespace App\Repositories;

use App\item;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Log;
use App\Comment;
class ItemRepository implements ItemRepositoryInterface{

    /**
     * Inserts an item in the database.
     * @param  $request
     * @return void
     */
    public function store(Request $request)
    {

        Log::info(session()->getId() . ' | [Database Query: Item Creation Started] | ' . $request->Name);

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
        
        Log::info(session()->getId() . ' | [Database Query: Item Creation Completed] | ' . $request->Name);

    }

    /**
     * Returns all active items in alphabetical order.
     * @param  null
     * @return item[]
     */
    public function index()
    {
        Log::info(session()->getId() . ' | [Database Query: Retrieving Active Items] | ' . Auth::user()->email);
        return item::orderby('Name','asc')->where('Status', '!=', 'cancelled')->paginate(10);
    }

    /**
     * Gets search results of a user search bar input.
     * @param  null
     * @return item[]
     */
    public function viewAllItems()
    {
        Log::info(session()->getId() . ' | [Database Query: Item Search Results]');
        return item::orderby('Name','asc')->paginate(12);
    }

    /**
     * Changes an item's status to cancelled.
     * @param  int $id
     * @return void
     */
    public function update($id)
    {
        Log::info(session()->getId() . ' | [Started Database Query: Item Cancelled]');
        $item = item::find($id);

        $item->Status = 'cancelled';
        $item->save();
        Log::info(session()->getId() . ' | [Finished Database Query: Item Cancelled]');
    }

    /**
     * Updates an item's number of transactions.
     * @param  int $id
     * @return void
     */
    public function numTransactions($id)
    {
        
        Log::info(session()->getId() . ' | [Number Transactions Update Started] | ' . $id);
        
        $numTransactions = DB::table('transactions')->where('item_fk', $id)->count();
        DB::table('items')
            ->where('id', $id)
            ->update(['Number_Transactions' => $numTransactions]);
            
        Log::info(session()->getId() . ' | [Number Transactions Update Finished] | ' . $id);
    }

    /**
     * Finds an item by its id.
     * @param  int $id
     * @return item
     */
    public function find($id)
    {
        Log::info(session()->getId() . ' | [Number Transactions Update Started] | ' . $id);
        return item::find($id);
    }

    /**
     * Returns the number of users commited to an item.
     * @param  $item
     * @return int
     */
    public function checkCommit($item)
    {
        Log::info(session()->getId() . ' | [Retrieving Number of Commits] | ' . $item->id);;
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
        Log::info(session()->getId() . ' | [Threshold Reached Started] | ' . $id);
        DB::table('items')->where('id', $id)->update(['status' => 'threshold reached']);
        Log::info(session()->getId() . ' | [Threshold Reached Finished] | ' . $id);
    }

    /**
     * Retrieves all items expiring today from the database.
     * @param  null
     * @return item[]
     */
    public function getExpiredItems()
    {
        return DB::table('items')->whereRaw('date(End_Date) = ?', [Carbon::today()])->get();
    }

    /**
     * Sets an item's status to expired.
     * @param  int $id
     * @return void
     */
    public function setExpired($id)
    {
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
        Log::info(session()->getId() . ' | [Search Query Started] | ' . $name);
        return item::search($name)->paginate(15);
    }


    public function addCommentToItem(Request $request, $itemId)
    {

        $comment = new Comment();
        $comment->username = Auth::user()->name;
        $comment->itemId = $itemId;
        $comment->comment = $request->comment;

        $comment->save();


    }

    public function getCommentsForItem($itemId)
    {
        $comments = DB::table('comments')->where('itemId', $itemId);
        $comments->orderBy('created_at', 'desc');   //Reverses the order so that most recent comments appear first
        return $comments->paginate(10);
    }


    public function addTotalTokens($nbTokens, $id)
    {
        Log::info('Database query: Adding ' . $nbTokens . ' tokens to total.'); 
        DB::table('items')->where('id', $id)->increment('Total_Tokens_Spent', $nbTokens);

    }
}