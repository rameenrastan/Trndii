<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

use Stripe\{Stripe, Charge, Customer};

class PaymentsController extends Controller
{

    /**
     * Updates a user's credit card info
     */
    public function updateCard(){


       Stripe::setApiKey('sk_test_NT3PRUGQkLOj8cnPlp1X2APb');
       
       $user = Auth::user();
       
       $customer = Customer::create([

        'email' => request('stripeEmail'),
        'source' => request('stripeToken') 

       ]);

   
        $user->stripe_id = $customer->id;
        $user->save();
        
        return redirect('/editDetails')->with('success', 'Credit Card Updated');

    }

    /**
     * Charges a user's credit card
     *
     * @param  amount, customer
     */
    public function charge($amount, $customerId){

        Stripe::setApiKey('sk_test_NT3PRUGQkLOj8cnPlp1X2APb');    

        $charge = Charge::create([

            "amount" => $amount,
            "currency" => "cad",
            "customer" => $customerId

        ]);

    }   

}
