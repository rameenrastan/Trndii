<?php

namespace Tests\Unit;

use App;
use DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;

class PurchaseHistoryVerifyCountTest extends TestCase
{


    public function setUp() {
        parent::setUp();


        Model::unguard();
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {


        $users = factory(App\User::class,1000)->create([
            'stripe_id' => 'tok_visa'
        ]);;
        $items = factory(App\item::class, 100)->create();



        //mt_rand(50, 100)
        // for 50 different users we add a random item to them
        for ($i = 0; $i < 50; $i++ ){

            $response = $this->actingAs($users[$i])
                ->withSession(['email' => $users[$i]->id ,'password'=>$users[$i]->password])
                ->get('/login');

            $request = new Request();
            $controller = new App\Http\Controllers\TransactionsController();
            $controller->update($request ,$items[mt_rand(1, 99)]->id);


        }




        //assert now that 50 users are indeed bound to an item in the transaction table
        /// this test checks for duplicate tests for duplicate values or undercreated values
        ///

        for ($i = 0; $i < 50; $i++ ) {
            $checkCount = DB::table('transactions')->where(['email', $users[$i]->email])->count();
        }
        $this->assertTrue($checkCount=50);



    }
}
