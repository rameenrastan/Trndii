<?php

namespace App\Repositories;

use App\item;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use Illuminate\Http\Request;
use DB;
use Auth;

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
        $item->Start_Date=$request->Start_Date;
        $item->Status = 'pending';
        $item->End_Date=$request->End_Date;
        $item->Picture_URL=$request->Picture_URL;
        $item->Shipping_To=$request->Shipping_To;

        $item->save();

    }

    public function index()
    {
        return item::orderby('Name','asc')->where('Status', '!=', 'cancelled')->paginate(10);
    }

    public function viewAllItems()
    {
        return item::orderby('Name','asc')->paginate(10);
    }

    public function update($id)
    {
        $item = item::find($id);

        $item->Status = 'cancelled';
        $item->save();
    }

    public function numTransactions($id)
    {
        $numTransactions = DB::table('transactions')->where('item_fk', $id)->count();

        DB::table('items')
            ->where('id', $id)
            ->update(['Number_Transactions' => $numTransactions]);
    }

    public function find($id)
    {
        return item::find($id);
    }

    public function checkCommit($item)
    {
        return DB::table('transactions')->where([['email', Auth::user()->email],['item_fk', $item->id]])->count();
    }
}