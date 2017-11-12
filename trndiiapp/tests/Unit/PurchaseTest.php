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

class PurchaseTest extends TestCase
{

    public function setUp() {

        parent::setUp();
        Model::unguard();

    }

    /**
     * tests a user creating a new transaction
     *
     * @return void
     */
    public function testPurchase()
    {

        $user = factory(App\User::class)->create([
            'stripe_id' => 'tok_visa'
        ]);

        $item = factory(App\item::class)->create();

        $response = $this->actingAs($user)
            ->withSession(['email' => $user->id ,'password'=>$user->password])
            ->get('/login');

        $request = new Request();
        $controller = new App\Http\Controllers\TransactionsController();
        $controller->update($request ,$item->id);

        

        $this->assertDatabaseHas('transactions', [
            'email' => $user->email,
            'item_fk'=>$item->id
        ]);

     }
    
    }
 
 