<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Auth;
use Log;
use App\User;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemsfk = DB::table('transactions')->where('email', Auth::user()->email)->pluck('item_fk');

        //return $itemsfk;

        //$transactions = DB::table('items')->wherein('id',$itemsfk)->select('*')->get();

        $transactions = DB::table('items')
                        ->join('transactions', 'items.id', '=', 'transactions.item_fk')
                        ->select('items.Name', 'items.Price', 'items.Bulk_Price', 'items.Short_Description', 'items.Start_Date', 'items.End_Date', 'items.Status')
                        ->get();

        //return $transactions;

        return view('layouts.viewprogress')->with('transactions', $transactions);
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
        //
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