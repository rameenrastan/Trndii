<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewsController extends Controller
{
    public function preregistration(){
        return view('preregistration');
    }

    public function successpreregistration(){
        return view('successpreregistration');
    }
}
