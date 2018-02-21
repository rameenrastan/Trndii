<?php

namespace App\Repositories;

use App\item;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Repositories\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface{

    public function store(Request $request){

        Cart::add($request->id, $request->Name, 1, $request->Price)->associate('App\item');
    }

    public function destroy($id){
        
        Cart::remove($id);
    }

    public function removeNonPendingItems(){

        foreach(Cart::content() as $item){
            
            if($item->model->Status != 'pending'){

                Cart::remove($item->rowId);
            }
        }
    }
}