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

    public function store(Request $request)
    {

        //Store in database
        $item= new item;

        $item->Name=$request->Name;
        $item->Price=$request->Price;
        $item->Bulk_Price=$request->Bulk_Price;
        $item->Tokens_Given=$request->Tokens_Given;
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

    public function index()
    {
        Log::info('Database query: getting all active items.');
        return item::orderby('Name','asc')->where('Status', '!=', 'cancelled')->paginate(10);
    }

    public function viewAllItems()
    {
        Log::info('Database query: getting all items.');
        return item::orderby('Name','asc')->paginate(10);
    }

    public function update($id)
    {
        Log::info('Database query: Item ' . $id . ' status changed to cancelled.');
        $item = item::find($id);

        $item->Status = 'cancelled';
        $item->save();
    }

    public function numTransactions($id)
    {
        $numTransactions = DB::table('transactions')->where('item_fk', $id)->count();
        Log::info('Database query: Item ' . $id . ' number of transactions updated to : ' . $numTransactions);
        DB::table('items')
            ->where('id', $id)
            ->update(['Number_Transactions' => $numTransactions]);
    }

    public function find($id)
    {
        Log::info('Database query: retrieving item ' . $id);
        return item::find($id);
    }

    public function checkCommit($item)
    {
        Log::info('Database query: finding the number of users commited to item ' . $item->id);
        return DB::table('transactions')->where([['email', Auth::user()->email],['item_fk', $item->id]])->count();
    }

    public function setThresholdReached($id)
    {
        Log::info('Database query: updating item ' . $id . ' status to threshold reached');
        DB::table('items')->where('id', $id)->update(['status' => 'threshold reached']);
    }

    public function getExpiredItems()
    {
        Log::info('Database query: retrieving all items that expire today (on ' .  Carbon::today() . ')');
        return DB::table('items')->whereRaw('date(End_Date) = ?', [Carbon::today()])->get();
    }

    public function setExpired($id)
    {
        Log::info('Database query: changing status of item ' . $id . ' to expired.');
        DB::table('items')->where('id', $id)->update(['status' => 'expired']);
    }
}