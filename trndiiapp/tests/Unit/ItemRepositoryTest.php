<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
use App\Repositories;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Log;
use App\Transaction;

class ItemRepositoryTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * Testing the @update function in Item repository
     * Tests that status of item is correctly set to cancelled
     * @return void
     */
    public function testUpdateRepository()
    {

        putenv('DB_CONNECTION=sqlite_testing');

        $test_item = factory(\App\item::class)->make();

        Log::shouldReceive('info');

        $test_item->save();

        $repository = new Repositories\ItemRepository();
        $repository->update($test_item->id);


        $this->assertDatabaseHas('items', [
            'id' => $test_item->id,
            'Status' => 'cancelled'
        ]);

    }

    /**
     * Tests that Item Repository's find method returns the correct item.
     * @return void
     */
    public function testFindAnItem()
    {

        putenv('DB_CONNECTION=sqlite_testing');

        Log::shouldReceive('info');

        $test_item = factory(\App\item::class)->make();

        $test_item->save();

        $repository = new Repositories\ItemRepository();

        $item_from_search = $repository->find($test_item->id);

        $this->assertTrue(
        $item_from_search->id == $test_item ->id &&
        $item_from_search->Name == $test_item->Name
    );

    }

     /**
     * Tests that an item's number of transactions is properly updated.
     * @return void
     */
    public function testUpdateNumTransactions()
    {

        putenv('DB_CONNECTION=sqlite_testing');

        Log::shouldReceive('info');

        $item = factory(\App\item::class)->make();

        $item->save();

        $user = factory(\App\User::class)->make();

        $user->save();
        $repository = new Repositories\ItemRepository();

        $transaction = new Transaction;

        $transaction->email = $user->email;
        $transaction->item_fk = $item->id;
        $transaction->charge_id = '';
        $transaction->tokens_spent = 0;

        $transaction->save();

        $repository->numTransactions($item->id);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'Number_Transactions' => 1
        ]);

    }

    /**
     * Tests that an item is properly retrieved and returned
     * @return void
     */
    public function testFindItem()
    {

        putenv('DB_CONNECTION=sqlite_testing');

        Log::shouldReceive('info');

        $item = factory(\App\item::class)->make();

        $item->save();

        $repository = new Repositories\ItemRepository();

        $foundItem = $repository->find($item->id);

        $this->assertTrue($foundItem->is($item));

    }

    /**
     * Tests that an item's number of transactions is properly updated.
     * @return void
     */
    public function testNumberOfCommits()
    {

        putenv('DB_CONNECTION=sqlite_testing');

        Log::shouldReceive('info');

        $item = factory(\App\item::class)->make();

        $item->save();

        $user = factory(\App\User::class)->make();

        $this->be($user);
    
        $user->save();
        
        $repository = new Repositories\ItemRepository();

        $transaction = new Transaction;

        $transaction->email = $user->email;
        $transaction->item_fk = $item->id;
        $transaction->charge_id = '';
        $transaction->tokens_spent = 0;

        $transaction->save();

        $numCommits = $repository->checkCommit($item);

        $this->assertEquals($numCommits, 1);

    }

}
