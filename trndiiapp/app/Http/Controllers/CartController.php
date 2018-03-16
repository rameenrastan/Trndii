<?php

namespace App\Http\Controllers;

use App\item;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Repositories\Interfaces\CartRepositoryInterface as CartRepositoryInterface;
use Log;
use Auth;

class CartController extends Controller
{
    protected $cartRepo;
    protected $logger;

    public function __construct(CartRepositoryInterface $cartRepo, Log $logger){
        
        $this->cartRepo=$cartRepo;
        $this->logger=$logger;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->logger::info(session()->getId() . ' | [Viewing Shopping Cart] | ' . Auth::user()->email);
        $this->cartRepo->removeNonPendingItems();
        return view('item.shoppingCart');
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
        $this->logger::info(session()->getId() . ' | [Adding to Shopping Cart] | ' . Auth::user()->email);
        $this->cartRepo->store($request);
        $this->cartRepo->removeNonPendingItems();
        return redirect('/shoppingCart')->with('success', 'The item has been added to the cart');
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
        $this->logger::info(session()->getId() . ' | [Removing from Shopping Cart] | ' . Auth::user()->email);
        $this->cartRepo->destroy($id);
        $this->cartRepo->removeNonPendingItems();
        return redirect('/shoppingCart')->with('success', 'The item has been removed from your shopping cart.');
    }
}
