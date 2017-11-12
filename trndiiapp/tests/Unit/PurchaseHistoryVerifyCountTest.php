<?php

namespace Tests\Unit;
use App\User;
use App\item;
use App;
use Tests\TestCase;
//use Tests\Unit\Artisan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PurchaseHistoryVerifyCountTest extends TestCase
{


    public function setUp() {
        parent::setUp();

        Artisan::call('migrate'); //run migrations
        Eloquent::unguard(); // disable eloquent guard
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {


        $users = factory(App\User::class, 1000)->create();
        $items = factory(App\item::class, 100)->create();



        //mt_rand(50, 100)
        // for 50 different users we add a random item to them
        for ($i = 0; $i < 50; $i++ ){

            DB::table('transactions')->insert([

                ['email' => $users[$i]->email(), 'item_fk' => $items[mt_rand(1, 100)]->id()]

            ]);

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
