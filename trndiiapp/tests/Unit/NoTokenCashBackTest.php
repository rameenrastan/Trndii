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
     * Tests that the a user will not receive any cash back if no tokens were spent on the item.
     *
     * @return void
     */
    public function testNoTokenCashBack()
    {
        $userRepoMock = Mockery::mock('App\Repositories\UserRepository');
        $itemRepoMock = Mockery::mock('App\Repositories\ItemRepository');
        $transactionRepoMock = Mockery::mock('App\Repositories\TransactionRepository');
        
        $tokenManager = new TokenManager($userRepoMock, $transactionRepoMock, $itemRepoMock);

        $itemPrice = 100;
        $totalTokens = 0;
        $tokensSpent = 0;
        $moneyPool = 1000;

        $moneyBack = $tokenManager->calculateCashBackFromTokens($itemPrice, $totalTokens, $tokensSpent, $moneyPool);

        $expectedMoneyBack = 0;

        $this->assertEquals($moneyBack, $expectedMoneyBack);
    }
}
