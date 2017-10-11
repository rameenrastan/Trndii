<?php

namespace App\Http\Controllers;

use App\item;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index(){

        $items=item::all();

        return view('itemsList',compact('items'));

    }
}
