<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Domain\ItemManager;
use Carbon\Carbon;
use Log;
use App\Repositories;
use App\Transaction;
use App\User;
use Mail;
use Mockery;

class ItemManagerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Tests that proper method calls are made in ItemManager's setExpired() method
     *
     * @return void
     */
    public function testSetItemExpired()
    {

        putenv('DB_CONNECTION=sqlite_testing');

        Log::shouldReceive('info');
        Mail::shouldReceive('to');

        $item = factory(\App\item::class)->make([
            'End_Date' =>  Carbon::today()
        ]);

        $item->save();

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'Status' => 'pending'
        ]);

        $userRepoMock = Mockery::mock('App\Repositories\UserRepository');
        $itemRepoMock = Mockery::mock('App\Repositories\ItemRepository');
        $transactionRepoMock = Mockery::mock('App\Repositories\TransactionRepository');
        $paymentManager = Mockery::mock('App\Domain\PaymentManager');

        $itemRepoMock->shouldReceive('getExpiredItems')->with()->once();
        $itemRepoMock->shouldReceive('find');
        $transactionRepoMock->shouldReceive('getAllByItemId');

        $itemManager = new ItemManager($itemRepoMock, $transactionRepoMock, $userRepoMock, $paymentManager);

        $itemManager->setExpired();

    }
}
