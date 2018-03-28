<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories;
use App\User;
use App\Transaction;
use Log;

class TransactionRepositoryTest extends TestCase
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

        $user = factory(\App\User::class)->make();

        $this->be($user);

        $user->save();

        $item = factory(\App\item::class)->make();

        $item->save();

        Log::shouldReceive('info');

        $repository = new Repositories\TransactionRepository(new Transaction, new Repositories\ItemRepository);
        $repository->insert($user->email, $item->id, 0);

        $this->assertDatabaseHas('transactions', [
            'email' => $user->email,
            'item_fk'=>$item->id
        ]);
    }
}
