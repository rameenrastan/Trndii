<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

use Stripe\{Stripe, Charge, Customer};

class PaymentsController extends Controller
{
    public function updateCard(){


       Stripe::setApiKey('sk_test_NT3PRUGQkLOj8cnPlp1X2APb');
       
       $user = Auth::user();
       
       $customer = Customer::create([

        'email' => request('stripeEmail'),
        'source' => request('stripeToken') 

       ]);

   
        $user->stripe_id = $customer->id;
        $user->save();
        
        //$customer = Customer::retrieve($user->stripe_id);
        return redirect() -> action('HomeController@index');

    }

}
