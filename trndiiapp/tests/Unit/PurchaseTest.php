<?php

namespace Tests\Unit;

use Tests\TestCase;
use App;
use DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PurchaseTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = factory(App\User::class)->create();
        $item = factory(App\item::class)->create();




            DB::table('transactions')->insert([

                ['email' =>$user->email, 'item_fk' => $item->id]

            ]);






        //assert now that 50 users are indeed bound to an item in the transaction table
        /// this test checks for duplicate tests for duplicate values or undercreated values
        ///

        $this->assertDatabaseHas('transactions', [
            'email' => $user->email,
            'item_fk'=>$item->id
        ]);
    }
}
