<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\TokenManager;
use Mockery;

class NoTokenCashBackTest extends TestCase
{
    /**
     * Tests that the a user receives the correct cash back value from spending tokens
     *
     * @return void
     */
    public function testCashBackFromTokens()
    {
        $userRepoMock = Mockery::mock('App\Repositories\UserRepository');
        $itemRepoMock = Mockery::mock('App\Repositories\ItemRepository');
        $transactionRepoMock = Mockery::mock('App\Repositories\TransactionRepository');
        
        $tokenManager = new TokenManager($userRepoMock, $transactionRepoMock, $itemRepoMock);

        //makes item with specified price, bulk price and threshold (used in money pool calculation)
        //(500 - 450) * 25 = 1250
        $item = factory(\App\item::class)->make([
            'Price' => 500,
            'Bulk_Price' => 450,
            'Threshold' => 25 
        ]);
        
        $tokenManager = new TokenManager($userRepoMock, $transactionRepoMock, $itemRepoMock);

        $moneyPool = $tokenManager->calculateMoneyPool($item);
        $itemPrice = $item->Price;
        $totalTokens = 200;
        $tokensSpent = 30;

        $expectedMoneyBack = ($tokensSpent / $totalTokens) * $moneyPool; 

        $moneyBack = $tokenManager->calculateCashBackFromTokens($itemPrice, $totalTokens, $tokensSpent, $moneyPool);

        $this->assertEquals($moneyBack, $expectedMoneyBack);
    }
}
