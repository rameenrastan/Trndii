<?php

namespace App\Http\Controllers;

use App\item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;

class ItemsController extends Controller
{
    public function index(){

        $items=item::orderby('Name','asc')->paginate(10);
        return view('item.index')->with('items',$items);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Validate data
        $this->validate($request, array(

            'Name'=>'required|max:255',
            'Price'=>'required',
            'Bulk_Price'=>'required',
            'Tokens_Given'=>'required',
            'Threshold' => 'required| integer',
            'Short_Description' => 'required',
            'Long_Description' => 'required| string',
            'Start_Date' => 'required| date',
           'End_Date' => 'required| date'
        ));

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

        $item->save();

        session()->flash('success','Item has been successfully created');

        //Redirect
        return redirect()->route('item.show', $item->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\i
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $item=item::find($id);

        $checkCommit = DB::table('transactions')->where([['email', Auth::user()->email],['item_fk', $item->id]])->count();

        return view('item.show')->withitem($item)
                                ->with('checkCommit', $checkCommit);
    }

    
    /**
     * Displays the current number of users who are commmited to an item.
     *
     * @param  $id
     * @return $numTransactions
     */
    public function numTransactions($id)
    {

        $numTransactions = DB::table('transactions')->where('item_fk', $id)->count();

        DB::table('items')
                        ->where('id', $id)
                        ->update(['Number_Transactions' => $numTransactions]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(item $item)
    {
        //
    }
}
