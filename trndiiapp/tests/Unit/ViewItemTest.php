<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
use Carbon\Carbon;
use App;
use DB;
use App\Http\Controllers;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Model;

class ViewItemTest extends TestCase
{

        /**
         * tests viewing an item
         *
         * @return void
         */
         public function testViewItem()
         {
    
             $user = factory(App\User::class)->create([
                'stripe_id' => 'tok_visa'
             ]);
    
             $item = factory(App\item::class)->create();
     
             $response = $this->actingAs($user)
                 ->withSession(['email' => $user->email ,'password'=>$user->password])
                 ->get('/item/{{$item->id}}');
                 
             $response->assertViewIs('item.show');   
    
         }
     
}
