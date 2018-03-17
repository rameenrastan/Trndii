<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories;
use App\User;
use App\Transaction;
use Log;
use Mockery;

class TransacationRepistoryTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * Tests the adding of a transaction to the transactions table
     *
     * @return void
     */
    public function testInsertingNewTransaction()
    {
        putenv('DB_CONNECTION=sqlite_testing');

        $test_user = new User([
            'name' => "Test User",
            'phone'=> "5145555555",
            'addressline1'=> "1455 Boulevard de Maisonneuve O, Montreal, QC H3G 1M8",
            'postalcode'=>"H3G 1M8",
            'city'=>"Montreal",
            'country'=>'Canada',
            'email' => "test@test.com",
            'password' => bcrypt('password'),
        ]);
        $this->be($test_user);
        $test_user->save();

        $test_item = new \App\item([
            'id' => "1",
            'Name'=> "testItem",
            'Price'=> 1,
            'Bulk_Price'=>1,
            'Threshold'=>20,
            'Tokens_Given'=>0,
            'Short_Description' => "test short description",
            'Long_Description' => "test long description",
            'Category'=>"Electronics",
            'Status'=>"pending",
            'Number_Transactions'=>0,
            'Start_Date'=>"2018-01-14 00:20:09",
            'End_Date'=>"2018-08-14 00:20:09",
            'Picture_URL'=>"test.jpg",
            'Shipping_To'=>"Canada",
            'Supplier'=>"FakeSupplier",
            'created_at'=>"2018-01-14 00:20:09",
            'updated_at'=>"2018-01-14 00:20:09"
        ]);

        $test_item->save();

        Log::shouldReceive('info');

        $repository = new Repositories\TransactionRepository(new Transaction, new Repositories\ItemRepository);
        $repository->insert($test_user->email, $test_item->id);

        $this->assertDatabaseHas('transactions', [
            'email' => $test_user->email,
            'item_fk'=>$test_item->id
        ]);
    }
}
