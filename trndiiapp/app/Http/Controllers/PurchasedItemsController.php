<?php

namespace App\Http\Controllers;

use App\PurchasedItem;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Log;
use Illuminate\Support\Facades\DB;

class PurchasedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $itemsfk = DB::table('purchased_items')->where('email', Auth::user()->email)->pluck('item_fk');

      //   echo $itemsfk;


        $items = DB::table('items')->whereIn('id',$itemsfk)->select('*')->get();

     //   echo $items;

      //  return view('user.index', ['users' => $users]);
       // return view('layouts.purchasehistory')->with('items',json_decode($items, true));
        return view('layouts.purchasehistory')->with('items',$items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
