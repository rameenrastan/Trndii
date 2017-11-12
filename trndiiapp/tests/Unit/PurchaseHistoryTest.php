<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
use App;
use DB;
use App\Http\Controllers;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Model;

class PurchaseHistoryTest extends TestCase
{
    /**
     * tests viewing purchase history
     *
     * @return void
     */
     public function testPurchaseHistory()
     {

         $user = factory(App\User::class)->create([
            'stripe_id' => 'tok_visa'
         ]);

         $item = factory(App\item::class)->create();
 
         $response = $this->actingAs($user)
             ->withSession(['email' => $user->id ,'password'=>$user->password])
             ->get('/purchaseHistory');
             
         $response->assertViewIs('layouts.purchasehistory');   

     }
    
    }
 
 