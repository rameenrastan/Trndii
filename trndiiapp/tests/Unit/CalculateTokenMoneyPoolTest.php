<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\TokenManager;
use Mail;
use Log;
use Mockery;

class CalculateMoneyPoolTest extends TestCase
{
    /**
     * Tests that the token money pool is calculated properly. 
     *
     * @return void
     */
    public function testCalculateTokenMoneyPool()
    {
        $userRepoMock = Mockery::mock('App\Repositories\UserRepository');
        $itemRepoMock = Mockery::mock('App\Repositories\ItemRepository');
        $transactionRepoMock = Mockery::mock('App\Repositories\TransactionRepository');

        $item = factory(\App\item::class)->make([
            'Price' => 500,
            'Bulk_Price' => 450,
            'Threshold' => 25 
        ]);
        
        $tokenManager = new TokenManager(new Mail, new Log, $userRepoMock, $transactionRepoMock, $itemRepoMock);

        $totalSavings = $tokenManager->calculateMoneyPool($item);

        $this->assertEquals($totalSavings, 1250);
    }
}
