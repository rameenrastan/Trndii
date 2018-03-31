<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\TokenManager;
use Mockery;

class CalculateMoneyPoolTest extends TestCase
{
    /**
     * Tests that the token money pool (total savings) is calculated properly. 
     *
     * @return void
     */
    public function testCalculateTokenMoneyPool()
    {
        $userRepoMock = Mockery::mock('App\Repositories\UserRepository');
        $itemRepoMock = Mockery::mock('App\Repositories\ItemRepository');
        $transactionRepoMock = Mockery::mock('App\Repositories\TransactionRepository');

        //makes item with specified price, bulk price and threshold (used in money pool calculation)
        //(500 - 450) * 25 = 1250
        $item = factory(\App\item::class)->make([
            'Price' => 500,
            'Bulk_Price' => 450,
            'Threshold' => 25 
        ]);
        
        $tokenManager = new TokenManager($userRepoMock, $transactionRepoMock, $itemRepoMock);

        $totalSavings = $tokenManager->calculateMoneyPool($item);

        $expectedTotalSavings = ($item->Price - $item->Bulk_Price) * $item->Threshold;

        $this->assertEquals($totalSavings, $expectedTotalSavings);
    }
}
